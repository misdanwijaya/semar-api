import numpy as np
import pandas as pd
import xarray as xr
import sys, json
import base64
import datetime
import time
import os

#encoder
class NumpyEncoder(json.JSONEncoder):
    """ Special json encoder for numpy types """
    def default(self, obj):
        if isinstance(obj, (np.int_, np.intc, np.intp, np.int8,
            np.int16, np.int32, np.int64, np.uint8,
            np.uint16, np.uint32, np.uint64)):
            return int(obj)
        elif isinstance(obj, (np.float_, np.float16, np.float32, 
            np.float64)):
            return float(obj)
        elif isinstance(obj,(np.ndarray,)): #### This is the fix
            return obj.tolist()
        return json.JSONEncoder.default(self, obj)



ds = xr.open_dataset('/home/misdan/Documents/Data/Angin/wind_1992.nc')

# Load the data that PHP sent us
try:
    data = json.loads(base64.b64decode(sys.argv[1]))
except:
    print "ERROR"
    sys.exit(1)

a_temp = data[0]
b_temp = data[1]
c_temp = data[2]

a = float(a_temp)
b = float(b_temp)
c = str(c_temp)

s_datetime = datetime.datetime.strptime(c, '%Y%m%d')

da = ds['u10'].sel(time=s_datetime,latitude=a, longitude=b,method='nearest').data

# Generate some data to send to PHP
result = {'kirim': da}

dumped = json.dumps(result, cls=NumpyEncoder)

# Send it to stdout (to PHP)
print json.dumps(dumped)