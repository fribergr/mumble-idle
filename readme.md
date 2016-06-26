Idle script for mumble-server
=============================

Install mumble-server
---------------------
Run `apt-get install mumble-server`

Configure mumble-server
-----------------------
Configure `/etc/mumble-server.ini` to expose ice-endpoint by making sure the settings looks like this:
```
ice="tcp -h 127.0.0.1 -p 6502"
#icesecretwrite=
```
You will need to restart the mumble-server by running `sudo systemctl restart mumble-server` after the configuration change

Install and configure ice-extension for PHP
-------------------------------------------
You also need to install the ice extension for php and generate a class for Murmur (mumble-server)
```
apt-get install php5-cli php-zeroc-ice libzeroc-ice35
cd /usr/share/slice/
slice2php Murmur.ice -I//usr/share/Ice-3.5.1/slice
```

Copy the newly generated `Murmur.php` to the folder where you will have `idle.php`.
You probably need to modify the `idle.php`-script to have your AFK-channel ID configured correctly.

Running in crontab (scheduled)
-------
To have the script run every minute, add the following to your cron.d or crontab:
```
* * * * * php /path/to/idle.php 2>&1 > /dev/null
```
This expects the idle.php to be installed in the folder `/path/to` alongside `Murmur.php`
