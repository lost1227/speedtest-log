#!/usr/bin/env python
import speedtest
import requests
import time

s = speedtest.Speedtest()
s.get_best_server()
s.download()
s.upload()
results = s.results.dict()
results["download"] = round((results["download"] / 1000000),3)
results["upload"] = round((results["upload"] / 1000000),3)
r = requests.post("http://jordanpowers.net/graphSpeeds/addData.php",results);
if r.text != '1':
    print("Error: Returned %s" % r.text)
#print(r.text);
print("Test completed: %s" % time.strftime("%m-%d-%y %I:%M:%S%p"))
