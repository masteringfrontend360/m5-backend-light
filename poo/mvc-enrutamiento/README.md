# Prueba MVC con enrutamiento

Para que funcione la prueba

Editar
```
sudo nano /etc/apache2/sites-available/000-default.conf
```
```
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html

    <Directory /var/www/html/m5-backend-light/poo/mvc-enrutamiento/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
Luego ejecuta
```
sudo apache2ctl configtest
sudo systemctl restart apache2
```