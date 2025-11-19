



  <!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

     <h1>Lee Comandos.csv ROMAN RANUCCI</h1>
     <form action="" method="POST">
      <input type="submit" name="btn__matriz" value="leer">
      <br>
      <br>
      <h2>Añadir Usuario</h2>
        <form action="" method="POST">
      
          <input type="text" name="txt__nombre" placeholder="Nombre">
          <input type="text" name="txt__apellido" placeholder="Apellido">
          <input type="text" name="txt__nacimiento" placeholder="Año De Nacimiento">
          <input type="text" name="txt__localidad" placeholder="Localidad">
          <input type="text" name="txt__provincia" placeholder="Provincia">
         

          <input type="submit" name="btn__guardar" value="guardar">

        </form>

    <br>
    <br>

  </body>
  </html>


   <?php




 function PokeToTabla($ruta){ 
  $file = fopen($ruta, "r");

    
    $matrizPoke = array();

    
    while (!feof($file)) {

      
      $data = fgets($file);

      if($data!="" && strlen($data) > 1){
      
        $matrizPoke[] = explode(",", rtrim($data));
      }
    }

    $tabla = "<table border='1'>";

    
    for ($i=0; $i < count($matrizPoke); $i++) { 
      
      
      $tabla .="<tr>";

      
      for ($x=0; $x < count($matrizPoke[$i]); $x++) {

          $celda = htmlspecialchars($matrizPoke[$i][$x]);
            if ($i == 0) {
                $tabla .= "<td><b>$celda</b></td>"; 
            } else {
                $tabla .= "<td>$celda</td>";
            }

      }

      $tabla .="</tr>";
    }

    
    $tabla .= "</table>"; 

    
    echo "<center>$tabla</center>";
  
}

function PokeToMatriz($ruta){ 
    $file = fopen($ruta, "r");
    $matrizPoke = array();

    while (!feof($file)) {
        $data = fgets($file);

        if($data!="" && strlen($data) > 1){
            $matrizPoke[] = explode(",", rtrim($data));
        }
    }

    fclose($file); 

    return $matrizPoke;
}



function addPoke($Poke){
    $PokeMatriz = PokeToMatriz("nomina.csv");

    $newCarnet = $PokeMatriz[count($PokeMatriz)-1][0]+1;

    
    $file = fopen("nomina.csv","a");

    $nombre = $Poke["txt__nombre"];
    $apellido = $Poke["txt__apellido"];
    $localidad = $Poke["txt__localidad"];
    $provincia = $Poke["txt__provincia"];
    $AnioNac = $Poke["txt__nacimiento"];
    
    
    
    fwrite($file, "$newCarnet,$nombre,$apellido,$AnioNac,$localidad,$provincia".PHP_EOL);
  }  













   
  if(isset($_POST['btn__matriz'])){

    PokeToTabla("nomina.csv", "r");
  }


  if(isset($_POST['btn__guardar'])){

    addPoke($_POST);
  }
  

?>



