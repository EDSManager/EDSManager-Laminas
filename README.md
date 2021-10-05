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
PHPIniDir "C:/php-8"
AddHandler application/x-httpd-php .php
LoadModule php_module "C:/php-8/php8apache2_4.dll"

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


