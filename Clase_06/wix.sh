#!/bin/bash
mkdir proyecto
cat > proyecto/index.php <<EOL
<?php
  echo "¡Hola desde index.php!";
?>
EOL
mkdir -p proyecto/css/user
mkdir -p proyecto/css/admin
touch proyecto/css/user/estilo.css
touch proyecto/css/admin/estilo.css
mkdir -p proyecto/img/avatars
mkdir -p proyecto/img/buttons
mkdir -p proyecto/img/products
mkdir -p proyecto/img/pets
mkdir -p proyecto/js/validations
mkdir -p proyecto/js/effects
touch proyecto/js/validations/login.js
touch proyecto/js/validations/register.js
touch proyecto/js/effects/panels.js
mkdir proyecto/tpl
touch proyecto/tpl/main.tpl
touch proyecto/tpl/login.tpl
touch proyecto/tpl/register.tpl
touch proyecto/tpl/panel.tpl
touch proyecto/tpl/profile.tpl
touch proyecto/tpl/crud.tpl
mkdir proyecto/php
touch proyecto/php/create.php
touch proyecto/php/read.php
touch proyecto/php/update.php
touch proyecto/php/delete.php
touch proyecto/php/dbconect.php
echo "Árbol de directorios 'proyecto' creado exitosamente."