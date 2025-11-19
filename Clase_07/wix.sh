
DEST="$1/proyecto"
NOMBRE_ALUMNO="$2"


mkdir -p "$DEST/css/user"
mkdir -p "$DEST/css/admin"
mkdir -p "$DEST/js/validations"
mkdir -p "$DEST/js/effects"
mkdir -p "$DEST/tpl"
mkdir -p "$DEST/php"


cat > "$DEST/index.php" <<EOL

<?php
  echo "¡Hola, $NOMBRE_ALUMNO!";
?>

EOL


touch "$DEST/css/user/estilo.css"
touch "$DEST/css/admin/estilo.css"
touch "$DEST/js/validations/login.js"
touch "$DEST/js/validations/register.js"
touch "$DEST/js/effects/panels.js"
touch "$DEST/php/create.php"
touch "$DEST/php/read.php"
touch "$DEST/php/update.php"
touch "$DEST/php/delete.php"
touch "$DEST/php/dbconect.php"

echo "Proyecto creado en '$DEST' para $NOMBRE_ALUMNO"