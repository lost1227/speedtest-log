#Speedtest-Log
Logs speedtest data to a website

#Install
Prerequisites:
  1. Webserver running mysql, php, and apache
  2. Local computer running python (could be a raspberry pi)
 
Directions:
  1. In the webroot of the webserver, make a folder to hold the php files
  2. In the mysql server, make a database and a table for the data. Edit the php files to match. The table should contain the following 5 rows: id (int, primary key), download (int), upload (int), ping (int), time (varchar(26))
  3. On the local computer, edit the python file testAndUpload.py to point to the address for your webserver.
  4. On the local computer, add a crontab to run the testAndUpload.py file periodically
