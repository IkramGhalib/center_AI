#!/bin/bash

user="root"
pass="ElectrocureDB@12345"
#db="dbnme"
host="10.13.144.6"

#############CISNR#####################
####4. Cust Current Logs 24 Hour Backup #######
 mysql -h "$host" -u "$user" -p"$pass" -e "INSERT INTO netmeter_26217.`cust_kwh_hourly_logs` SELECT null,cid,hour(datetime) as hour, day(datetime) as day,month(datetime) as month,year(datetime) as year,sum(round(offpkunits,2)) as offpeak, sum(round(pkunits,2)) as peak FROM netmeter_26217.cust_kwh_logs where datetime > now()-interval 1 hour GROUP BY cid, hour,day,month,year ORDER BY year,month,day,hour"


