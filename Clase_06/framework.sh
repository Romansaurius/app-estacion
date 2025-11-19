#!/bin/bash
mkdir framework
cat > framework/.env <<CONFIG
APP_NAME=MiFramework
APP_VERSION=1.0.0
DATABASE_HOST=localhost
DATABASE_USER=root
DATABASE_PASSWORD=secret
CONFIG
touch framework/.gitignore
touch framework/.htaccess
touch framework/README.md
mkdir -p framework/app/http/controllers
touch framework/app/http/controllers/LandingController.php
touch framework/app/http/controllers/NotFoundController.php
mkdir -p framework/app/http/models
touch framework/app/http/models/User.php
touch framework/app/http/models/Client.php
mkdir -p framework/database/mysqli
touch framework/database/mysqli/Connect.php
mkdir framework/public
touch framework/public/index.php
mkdir -p framework/resources/css
touch framework/resources/css/style.css
mkdir -p framework/resources/js
touch framework/resources/js/defaul.js
mkdir -p framework/resources/views/landing
touch framework/resources/views/landing/index.tpl.php
mkdir -p framework/resources/views/notfound
touch framework/resources/views/notfound/index.tpl.php
mkdir framework/router
touch framework/router/RouterHandler.php
mkdir framework/vendor
echo "Árbol de directorios 'framework' creado exitosamente."