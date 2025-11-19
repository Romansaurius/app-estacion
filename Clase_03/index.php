
 


<?php

$archivo = fopen("comandos_response_71_Ranucci_Roman.csv", "r");
$comandos_listados = 0;
$caracteres_leidos = 0;



    while (($linea = fgets($archivo)) !== false) {
        $caracteres_leidos += strlen($linea);

        $linea = trim($linea);
        
        if (str_contains($linea, '<center><h4>')) {
            $Nombre = $linea;
            continue;
        }

       
        $partes = explode("|", $linea);

        if (count($partes) >= 2) {
            $comando = $partes[0];
            $funcion = str_replace('*<br>', '', $partes[1]);

            echo "<b>$comando</b><br>";
            echo " $funcion<br>";
            echo "<hr>";
            $comandos_listados++;
        }
    }

    fclose($archivo);



echo "<br><b>Comandos Listados: $comandos_listados</b><br>";
echo "<b>Caracteres Leídos: $caracteres_leidos</b><br><br>";


echo "$Nombre";
?>
