from django.shortcuts import render
from .models import Delivery, Farmers
from datetime import datetime
import pandas as pd
from statsmodels.tsa.statespace.sarimax import SARIMAX
from django.utils import timezone
import statsmodels.api as sm
from pmdarima import auto_arima

def main_view(request):
    return render(request, 'predict/main.html')
    
def predict_view(request):
    farmers = Farmers.objects.order_by('f_no')

    if request.method == 'POST':
        r_f_no = request.POST.get('r_f_no')
        start_date = request.POST.get('start_date')
        end_date = request.POST.get('end_date')

        print("Selected Farmer Number:", r_f_no)
        print("Start Date:", start_date)
        print("End Date:", end_date)

        try:
            start_date = timezone.make_aware(timezone.datetime.strptime(start_date, "%Y-%m-%d"))
            end_date = timezone.make_aware(timezone.datetime.strptime(end_date, "%Y-%m-%d"))

            # Retrieve all historical data for the selected farmer from the database
            all_data = Delivery.objects.filter(r_f_no_id=r_f_no).order_by('r_dt')

            if not all_data:
                return render(request, 'predict/prediction.html', {'error_message': 'No data available.', 'farmers': farmers})

            print("Number of Historical Data Entries:", len(all_data))

            # Extract the delivery dates and weights for the SARIMA model training
            dates = [entry.r_dt.date() for entry in all_data]
            weights = [entry.r_kg for entry in all_data]

            # Train the SARIMA model using all available historical data
            seasonal_order = (1, 1, 1, 30)  # Example seasonal order (p, d, q, seasonal_periods)
            model = SARIMAX(weights, order=(1, 1, 1), seasonal_order=seasonal_order)
            model_fit = model.fit()

            # Generate forecasts for the selected date range (daily forecasts)
            forecast_dates = pd.date_range(start=start_date.date(), end=end_date.date(), freq='D')
            forecast = model_fit.predict(start=len(weights), end=len(weights) + len(forecast_dates) - 1)

            # Round the forecasted values to 2 decimal places
            forecast = [round(value, 2) for value in forecast]

            # Combine forecast_dates and forecasts into a list of tuples
            forecasts_zipped = list(zip(forecast_dates.date.tolist(), forecast))

            # Get the farmer object for the selected farmer
            farmer = Farmers.objects.get(f_no=r_f_no)

            context = {
                'forecasts': forecasts_zipped,
                'farmers': farmers,
                'f_name': farmer.f_name,  # Include the farmer's name in the context
                'selected_start_date': start_date,  # Include the selected start date
                'selected_end_date': end_date,      # Include the selected end date
            }
            return render(request, 'predict/prediction.html', context)
        except Exception as e:
            print("Error occurred during forecasting:", str(e))
            return render(request, 'predict/prediction.html', {'error_message': 'Error occurred during forecasting.', 'farmers': farmers})
    else:
        return render(request, 'predict/predict_farmer.html', {'farmers': farmers})
    
def dairy_prediction_view(request):
    if request.method == 'POST':
        start_date = request.POST.get('start_date')
        end_date = request.POST.get('end_date')

        try:
            start_date = timezone.make_aware(timezone.datetime.strptime(start_date, "%Y-%m-%d"))
            end_date = timezone.make_aware(timezone.datetime.strptime(end_date, "%Y-%m-%d"))

            # Retrieve all historical data for individual farmers from the database
            all_data = Delivery.objects.order_by('r_dt')

            if not all_data:
                return render(request, 'predict/prediction_dairy.html', {'error_message': 'No data available for the dairy firm.'})

            # Aggregating data on a daily basis
            daily_data = {}
            for entry in all_data:
                date = entry.r_dt.date()
                weight = entry.r_kg
                if date in daily_data:
                    daily_data[date] += weight
                else:
                    daily_data[date] = weight

            # Extract the delivery dates and weights for the SARIMA model training
            dates = list(daily_data.keys())
            weights = list(daily_data.values())

            # Train the SARIMA model using aggregated daily data
            seasonal_order = (1, 1, 1, 30)  # Example seasonal order (p, d, q, seasonal_periods)
            model = SARIMAX(weights, order=(1, 1, 1), seasonal_order=seasonal_order)
            model_fit = model.fit()

            # Generate forecasts for the selected date range (daily forecasts)
            forecast_dates = pd.date_range(start=start_date.date(), end=end_date.date(), freq='D')
            forecast = model_fit.predict(start=len(weights), end=len(weights) + len(forecast_dates) - 1)

            # Round the forecasted values to 2 decimal places
            forecast = [round(value, 2) for value in forecast]

            # Combine forecast_dates and forecasts into a list of tuples
            forecasts_zipped = list(zip(forecast_dates.date.tolist(), forecast))

            context = {
                'creamery_forecasts': forecasts_zipped,
                'creamery_selected_start_date': start_date,  # Include the selected start date
                'creamery_selected_end_date': end_date,      # Include the selected end date
            }
            return render(request, 'predict/prediction_dairy.html', context)
        except Exception as e:
            print("Error occurred during dairy-wide forecasting:", str(e))
            return render(request, 'predict/prediction_dairy.html', {'error_message': 'Error occurred during dairy-wide forecasting.'})
    else:
        return render(request, 'predict/predict_dairy.html')

def single_date_predict_view(request):
    if request.method == 'POST':
        farmer_id = request.POST['r_f_no']
        single_date = request.POST['single_date']

        try:
            farmer = Farmers.objects.get(f_no=farmer_id)
            historical_data = list(Delivery.objects.filter(r_f_no=farmer, r_dt__lte=single_date).values_list('r_kg', flat=True))

            if not historical_data:
                error_message = "No historical data available for the selected farmer and date."
                return render(request, 'predict/result.html', {'error_message': error_message})
            
            # Print historical data for debugging
            print("Historical Data:", historical_data)

            # Dummy SARIMA parameters for testing
            p, d, q, P, D, Q, s = 1, 1, 1, 1, 1, 1, 12

            sarima_model = sm.tsa.SARIMAX(historical_data, order=(p, d, q), seasonal_order=(P, D, Q, s))
            sarima_result = sarima_model.fit()

            # Convert single_date to a datetime object
            single_date = datetime.strptime(single_date, '%Y-%m-%d')

            # Forecast for the selected future date
            forecast = sarima_result.get_forecast(steps=1)
            forecasted_value = forecast.predicted_mean[0]

            # Format the forecasted value to two decimal places
            formatted_forecast = "{:.2f}".format(forecasted_value)

            return render(request, 'predict/result.html', {
                'selected_single_date': single_date,
                'total_weight': formatted_forecast
            })
            
        except Farmers.DoesNotExist:
            error_message = "Selected farmer does not exist."
            return render(request, 'predict/result.html', {'error_message': error_message})

    farmers = Farmers.objects.all()
    return render(request, 'predict/predict_farmer.html', {'farmers': farmers})

def single_date_dairy_predict_view(request):
    if request.method == 'POST':
        single_date_str = request.POST.get('single_date')

        try:
            # Convert the single_date from the POST request into a Python datetime object
            single_date = datetime.strptime(single_date_str, "%Y-%m-%d")

            # Check if the selected date is in the future
            if single_date.date() <= timezone.now().date():
                return render(request, 'predict/result_dairy.html', {'error_message': 'Please select a future date for prediction.'})

            # Retrieve all historical data for the dairy firm from the database
            all_data = Delivery.objects.filter(r_dt__lte=single_date).order_by('r_dt')

            if not all_data:
                return render(request, 'predict/result_dairy.html', {'error_message': 'No data available for the dairy firm on the selected date.'})

            # Aggregating data on a daily basis
            daily_data = {}
            for entry in all_data:
                date = entry.r_dt.date()
                weight = entry.r_kg
                if date in daily_data:
                    daily_data[date] += weight
                else:
                    daily_data[date] = weight

            # Extract the delivery weights for the SARIMA model training
            weights = list(daily_data.values())

            # Train the SARIMA model using all available historical data
            seasonal_order = (1, 1, 1, 30)  # Example seasonal order (p, d, q, seasonal_periods)
            model = SARIMAX(weights, order=(1, 1, 1), seasonal_order=seasonal_order)
            model_fit = model.fit(maxiter=1000)

            # Generate forecast for the selected single date
            forecast = model_fit.forecast(steps=1)

            # Round the forecasted value to 2 decimal places
            forecast_value = round(forecast[0], 2)

            context = {
                'forecast_value': forecast_value,
                'creamery_selected_date': single_date,  # Include the selected single date for creamery prediction
            }
            return render(request, 'predict/result_dairy.html', context)
        except Exception as e:
            print("Error occurred during dairy-wide forecasting for single date:", str(e))
            return render(request, 'predict/result_dairy.html', {'error_message': 'Error occurred during dairy-wide forecasting for single date.'})
    else:
        return render(request, 'predict/predict_dairy.html')