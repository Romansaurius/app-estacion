
    
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

    ?>