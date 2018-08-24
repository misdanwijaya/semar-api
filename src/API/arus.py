
import numpy as np
import pandas as pd
import xarray as xr
import sys, json
import base64
import datetime
import time
import os

#buka file
ds = xr.open_dataset('/home/misdan/Documents/Data/Arus/1992_10.nc')

# Load JSON
try:
    data = json.loads(base64.b64decode(sys.argv[1]))
except:
    print "ERROR"
    sys.exit(1)

#Baca data
a_temp = data[0]
b_temp = data[1]
c_temp = data[2]

a = float(a_temp)
b = float(b_temp)
c = str(c_temp)
s_datetime = datetime.datetime.strptime(c, '%Y%m%d')

#Cari data
data_nilai = ds['water_u'].sel(time=s_datetime,lat=a, lon=b,method='nearest').data.tolist()
z = data_nilai[0]
data_tgl = ds['water_u'].sel(time=s_datetime,lat=a, lon=b,method='nearest').time.data.astype(str).tolist()
data_latitude = ds['water_u'].sel(time=s_datetime,lat=a, lon=b,method='nearest').lat.data.tolist()
data_longitude = ds['water_u'].sel(time=s_datetime,lat=a, lon=b,method='nearest').lon.data.tolist()
data_nama = ds['water_u'].sel(time=s_datetime,lat=a, lon=b,method='nearest').long_name
data_unit = ds['water_u'].sel(time=s_datetime,lat=a, lon=b,method='nearest').units

# Generate some data to send to PHP
result = {'nilai': z,
'tanggal': data_tgl,
'latitude': data_latitude,
'longitude': data_longitude,
'detail_nama': data_nama,
'detail_satuan': data_unit
}

# Send it to stdout (to PHP)
print json.dumps(result)