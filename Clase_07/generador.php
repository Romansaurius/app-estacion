<?php
/* Actualizado - 2024 */
if (isset($_POST['Generar'])) {

 $contenido = '
    
    <?php

        shell_exec("rm -r alumnos");
        shell_exec("mkdir alumnos");
        shell_exec("mkdir alumnos/G1");
        shell_exec("mkdir alumnos/G2");
        

        $stream = file_get_contents("71alumnos.csv");
        $rows = explode(PHP_EOL, $stream);

        foreach ($rows as $key => $row) {
            if (strlen($row) > 0) {
                $alumno = explode(",", $row);
              $ruta = "alumnos/" . $alumno[1] . "/" . $alumno[0] . "/" . str_replace(" ", "_", $alumno[2]); 
              $nombre = $alumno[2]; 
              shell_exec("./wix.sh \"$ruta\" \"$nombre\"");
     
                

            }
        }

        echo "Ejecución finalizada"; 

    ?>';
    

        file_put_contents("newseven.php", $contenido);

        echo "<p>CSV analizado, se creó el script <strong>newseven.php</strong>.</p>";
        echo '<form action="newseven.php" method="POST">
                <button type="submit">Ejecutar</button>
              </form>';
}




?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ejecutor de Scrpit</title>
</head>
<body>
     <form method="POST">
         
         <button type="submit" name="Generar">Generar</button>
   
    </form>
</body>
</html>