from django.urls import path

from . import views

app_name = 'predict'

urlpatterns = [
    path("", views.main_view, name="main_view"),
    path('farmer/', views.predict_view, name='predict_view'),
    path('dairy/', views.dairy_prediction_view, name='dairy_prediction_view'),
    path('predict-single-date/', views.single_date_predict_view, name='single_date_predict_view'),
    path('predict-dairy-single-date/', views.single_date_dairy_predict_view, name='single_date_dairy_predict_view'),
]