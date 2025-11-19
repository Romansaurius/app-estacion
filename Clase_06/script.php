<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Script</title>
    </style>
</head>
<body>
    <h1>Generador de Script</h1>

    <?php
    $error = "";
    $success = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $scriptName = $_POST["script"];
        $commands = $_POST["command"];

        if (empty($scriptName) || empty($commands)) {
            $error = "Por favor, completa ambos campos.";
        } else {
            $fileName = $scriptName . ".sh";
            $file = fopen($fileName, "w");
            if ($file) {
                fwrite($file, $commands);
                chmod($fileName, 0777);
                fclose($file);
                $success = "El script '$fileName' ha sido generado exitosamente.";
            } else {
                $error = "No se pudo crear el archivo '$fileName'. Verifica los permisos del servidor.";
            }
        }
    }
    ?>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label for="script">Nombre Del Script:</label>
            <input type="text" id="script" name="script">
        </div>
        <div>
            <label for="command">Commands:</label>
            <textarea id="command" name="command"></textarea>
        </div>
        <button type="submit">Generar Script</button>
    </form>
</body>
</html>