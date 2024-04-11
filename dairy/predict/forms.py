# forms.py

from django import forms
from .models import Delivery, Farmers

class PredictForm(forms.Form):
    farmer = forms.ModelChoiceField(queryset=Farmers.objects.all())
    start_date = forms.DateField()
    end_date = forms.DateField()
