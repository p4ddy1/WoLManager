# WoLManager

WoLManager is a small tool I wrote to be able to startup devices in my network using their WakeOnLan functionality.
It provides a minimalistic web interface to wake up devices. Just install it on a web server in your network and you are good to go.
It stores the IP, Subnetmask and MAC Address of every device you added in a SQLite database and sends the MagicPacket to the Broadcast
according to the information.

![Screenshot](http://hothead.lpnw.de/wolmanager.jpg)

### Requirements

* Webserver with rewrite support
* PHP >7.0 with sockets support and pdo_sqlite support
* composer
* npm

### TODO

* Add configuration support 
* Better error handling
* Add more comments
* Add tests
* Implement better setup process

### Installation
```
# cd /var/www
# git clone https://github.com/p4ddy1/WoLManager
# cd WoLManager
# composer install
# npm install
# npm run build
# php setup.php
```

Point webserver root to _/public_ directory. Example configuration for apache2:
```
<VirtualHost *:80>
    ServerName wolmanager.local
    DocumentRoot /var/www/WoLManager/public
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>

<Directory "/var/www/WoLManager/public">
    AllowOverride all
    Require all granted
</Directory>
```

### Troubleshooting

Q: I am unable to add new devices or edit existing devices.  
A: Check the permissions of the _db_ folder. The user which executes the PHP scripts (in most cases the user of the webserver)
needs write permissions to that folder. Example for Ubuntu Server with apache2:
```
# chown -R www-data:www-data db
```