# WoLManager

WoLManager is a small tool I wrote using PHP to be able to startup devices in my network using their WakeOnLan functionality.
It provides a minimalistic web interface to wake up devices. Just install it on a web server in your network and you are good to go.
It stores the IP, Subnetmask and MAC Address of every device you added in a SQLite database and sends the MagicPacket to the Broadcast
according to the information.

![Screenshot](http://hothead.lpnw.de/wolmanager3.jpg)

### Requirements

* Webserver with rewrite support
* PHP >7.0 with sockets support and pdo_sqlite support
* composer
* npm

### TODO

* Better error handling
* Add tests
* Add more comments

#### Note
This is still in development. If you find any issues or have an idea for a new feature I'm happy to hear from you!

### Installation
```
# cd /var/www
# git clone https://github.com/p4ddy1/WoLManager
# cd WoLManager
# composer install
# npm install
# npm run build
```
Make sure the _db_ and _config_ is writeable for the webserver:

```
# chown -R www-data:www-data db config
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

Point your browser to the address of your installation and complete the setup process. Create a user account and supply a
path where the SQLite database should be saved (default is the db directory). Done!

### Troubleshooting

Q: I am unable to add new devices or edit existing devices.  
A: Check the permissions of the _db_ folder. The user which executes the PHP scripts (in most cases the user of the webserver)
needs write permissions to that folder. Example for Ubuntu Server with apache2:
```
# chown -R www-data:www-data db
```
