# WoLManager

WoLManager is a small tool I wrote to be able to startup devices in my network using their WakeOnLan functionality.
It provides a minimalistic web interface to wake up devices. Just install it on a web server in your network and you are good to go.
It stores the IP, Subnetmask and MAC Address of every device you added in a SQLite database and sends the MagicPacket to the Broadcast
according to the information.

### Requirements

* Webserver with rewrite support
* PHP >7.0 with sockets support and pdo_sqlite support
* composer
* npm

### TODO

* Add authentication support
* Add configuration support 
* Error handling

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