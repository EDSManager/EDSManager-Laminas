# EDSManager

## Introduction

This application based on a Laminas Framework (https://github.com/laminas).

## Installation using Composer

The easiest way to install EDSManager is to use [Composer](https://getcomposer.org/). 
If you don't have it already installed, then please install as per the [documentation](https://getcomposer.org/doc/00-intro.md).

To install EDSManager copy project in Application folder from GitHub and run:

```bash
$ composer install
```

## Web server setup

### Apache setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

```apache conf/httpd.conf:
LoadModule access_compat_module modules/mod_access_compat.so
LoadModule rewrite_module modules/mod_rewrite.so
```

for windows-version add support PHP:

```apache conf/httpd.conf:

# before PHP 8.0.0 the name of the module was php7_module
LoadModule php7_module "C:\php\php7.4.24\php7apache2_4.dll"
<FilesMatch \.php$>
    SetHandler application/x-httpd-php
</FilesMatch>
# configure the path to php.ini
PHPIniDir "C:/php/php7.4.24"

```

```apache
<VirtualHost *:80>
    ServerName laminasapp.localhost
    DocumentRoot /path/to/laminasapp/public
    <Directory /path/to/laminasapp/public>
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
        <IfModule mod_authz_core.c>
        Require all granted
        </IfModule>
    </Directory>
</VirtualHost>
```


```MySQL:
CREATE TABLE user (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  login varchar(128) NOT NULL UNIQUE KEY,
  password varchar(128) NOT NULL,
  status int(11) NOT NULL,
  date_created datetime NOT NULL,
  date_last_login datetime,
  person_id int(11)
  );
```
```MySQL:
CREATE TABLE person (
  id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  last_name varchar(128),
  first_name varchar(128),
  middle_name varchar(128),
  email varchar(128)
  );
```