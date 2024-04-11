# In your predict app's models.py file

from django.db import models

class Delivery(models.Model):
    r_dt = models.DateTimeField()
    r_kg = models.FloatField()
    r_f_no = models.CharField(max_length=50)

    class Meta:
        db_table = 'delivery'
 