#!/bin/bash

# Script para generar una web simple
# Parámetro: nombre del dominio

if [ -z "$1" ]; then
    echo "Error: Falta el nombre del dominio"
    exit 1
fi

DOMINIO=$1
WEB_DIR="webs/$DOMINIO"

# Crear directorio de la web y estructura de carpetas
mkdir -p "$WEB_DIR" 2>/dev/null || mkdir "$WEB_DIR"
mkdir -p "$WEB_DIR/css/user"
mkdir -p "$WEB_DIR/css/admin"
mkdir -p "$WEB_DIR/js/validations"
mkdir -p "$WEB_DIR/js/effects"
mkdir -p "$WEB_DIR/tpl"
mkdir -p "$WEB_DIR/php"

# Crear index.html básico
cat > "$WEB_DIR/index.html" << EOF
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$DOMINIO</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido a $DOMINIO</h1>
        <p>Esta es tu nueva página web generada automáticamente.</p>
        <p>Puedes personalizar este contenido editando el archivo index.html</p>
        <p>¡Gracias por usar WebGenerator!</p>
    </div>
</body>
</html>
EOF

# Crear archivos vacíos
touch "$WEB_DIR/css/user/estilo.css"
touch "$WEB_DIR/css/admin/estilo.css"
touch "$WEB_DIR/js/validations/login.js"
touch "$WEB_DIR/js/validations/register.js"
touch "$WEB_DIR/js/effects/panels.js"
touch "$WEB_DIR/php/create.php"
touch "$WEB_DIR/php/read.php"
touch "$WEB_DIR/php/update.php"
touch "$WEB_DIR/php/delete.php"
touch "$WEB_DIR/php/dbconect.php"

echo "Web $DOMINIO creada exitosamente en $WEB_DIR con estructura completa"