from django.db import models
from django.utils import timezone

class Farmers(models.Model):
    f_no = models.AutoField(primary_key=True)
    f_id = models.CharField(max_length=50)
    f_name = models.CharField(max_length=100)
    f_locality = models.CharField(max_length=100)
    f_ac = models.FloatField()
    last_paid = models.DateField(null=True)  # Assuming last_paid is a DateField
    f_phone = models.CharField(max_length=20, null=True)  # Assuming f_phone is a CharField
    f_photo = models.BinaryField(null=True)  # Assuming f_photo is a BinaryField

    class Meta:
        db_table = 'farmers'  # Replace with the actual table name if needed

class Delivery(models.Model):
    id = models.AutoField(primary_key=True)
    r_f_no = models.ForeignKey(Farmers, on_delete=models.CASCADE)
    r_kg = models.FloatField()
    r_dt = models.DateTimeField(default=timezone.now)
    r_received_by = models.CharField(max_length=50)
    r_deliverer = models.CharField(max_length=50)

    class Meta:
        db_table = 'delivery'
