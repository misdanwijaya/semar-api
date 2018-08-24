
import numpy as np
import pandas as pd
import xarray as xr
import sys, json
import base64
import datetime
import time
import os

#buka file
ds = xr.open_dataset('/home/misdan/Documents/Data/Angin/wind_1992.nc')

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
data_nilai = ds['u10'].sel(time=s_datetime,latitude=a, longitude=b,method='nearest').data.tolist()
data_tgl = ds['u10'].sel(time=s_datetime,latitude=a, longitude=b,method='nearest').time.data.astype(str).tolist()
data_longitude = ds['u10'].sel(time=s_datetime,latitude=a, longitude=b,method='nearest').longitude.data.tolist()
data_latitude = ds['u10'].sel(time=s_datetime,latitude=a, longitude=b,method='nearest').latitude.data.tolist()
data_nama = ds['u10'].sel(time=s_datetime,latitude=a, longitude=b,method='nearest').long_name
data_unit = ds['u10'].sel(time=s_datetime,latitude=a, longitude=b,method='nearest').units

# Generate some data to send to PHP
result = {'nilai': data_nilai,
'tanggal': data_tgl,
'longitude': data_longitude,
'latitude': data_latitude,
'detail_nama': data_nama,
'detail_satuan': data_unit
}

# Send it to stdout (to PHP)
print json.dumps(result)