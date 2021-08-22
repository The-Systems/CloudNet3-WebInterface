[![License](https://img.shields.io/badge/License-Apache%202.0-blue.svg)](https://opensource.org/licenses/Apache-2.0)
[![Discord](https://img.shields.io/discord/340197684688453632.svg?label=&logo=discord&logoColor=ffffff&color=7389D8&labelColor=6A7EC2)](https://discord.gg/CYHuDpx)
<br>

<img src="https://cdn.the-systems.eu/icon-transparent-banner.png" width="300px" />

# <b>CloudNet3-Webinterface</b>

## Requirement

- CloudNet 3.5 and the Rest-Module

- Webserver (or Webspace)
    - PHP 8
    - PHP Extensions: Curl (apt-get install php8-curl)
    - Apache2 Mods: rewrite (a2enmod rewrite)

## Download

You can download the latest version from https://project.the-systems.eu/resources/cloudnet3-webinterface

## Installation

1. Load the files into your Webserve
2. Copy the file config/config-sample.php to config/config.php
3. run the command "composer install" (If this doesn't work, go to "Install Composer")
4. Setup the Webserver

Info: The web interface also works on an external Webspace!

### Webserver Configuration

#### Apache2

1. Go to /etc/apache2/sites-available
2. Create a file with the extension .conf
   (Example: webinterface.conf)
3. Add the following and customize it.

        <VirtualHost *:80>
            ServerName webinterface.domain.com
            DocumentRoot "/var/www/webinterface/public"

            <Directory /var/www/webinterface/public>
                    AllowOverride All
            </Directory>


        </VirtualHost>

4. Activate the page with

        a2ensite webinterface.conf

5. Restart Apache2

        service apache2 restart

7. Install SSL Certificate with https://certbot.eff.org/

### Install Composer

#### Debian 10

    curl -sS https://getcomposer.org/installer | php
    php composer.phar install --no-dev -o

## Docker

For the docker setup you just need to have `docker` and `git` installed.

## Close the repository
``git clone https://github.com/The-Systems/CloudNet3-WebInterface.git``

## Build the docker image

``docker build -t cloudnet-webinterface .``

## Run the image

The interface will run on port 8080 on the host.

```bash
docker run -d --name cloudnet-webinterface \ 
        --port 8080:80 \
        cloudnet-webinterface
```

# GERMAN

## Vorraussetzungen

- CloudNet 3.5 and the Rest-Module

- Webserver (oder Webspace)
    - PHP 8
    - PHP Erweiterungen: Curl (apt-get install php8-curl)
    - Apache2 Mods: rewrite (a2enmod rewrite)

## Download

Du kannst die aktuelle Version von https://project.the-systems.eu/resources/cloudnet3-webinterface herunterladen

## Installation

1. Lade die Dateien auf deinen Webserver
2. Kopiere die config/config-sample.php in config/config.php und stelle diese ein
3. Führe "composer install" aus (Sollte das nicht funktionieren, befolge "Composer installieren")
4. Richte den Webserver ein

Info: Das Webinterface funktioniert ebenfalls auf einem Externen Webserver/Webspace!

### Webserver Configuration

#### Apache2

1. Gehe zu /etc/apache2/sites-available
2. Erstelle eine Datei mit der Endung .conf
   (Beispiel: webinterface.conf)
3. Füge das folgende ein und füge deine Daten ein

        <VirtualHost *:80>
            ServerName webinterface.domain.com
            DocumentRoot "/var/www/webinterface/public"

            <Directory /var/www/webinterface/public>
                    AllowOverride All
            </Directory>


        </VirtualHost>

4. Aktiviere die Seite mit

        a2ensite webinterface.conf

5. Starte Apache2 neu

        service apache2 restart

6. Sollte der Kommand nicht funktionieren, führe "a2enmod rewrite" aus

7. Installier ein SSL-Zertifikat mit https://certbot.eff.org/

### Composer installieren

#### Debian 10

    curl -sS https://getcomposer.org/installer | php
    php composer.phar install --no-dev -o

