
 <?php




 function PokeToTabla($ruta){ 
  $file = fopen($ruta, "r");

    
    $matrizPoke = array();

    
    while (!feof($file)) {

      
      $data = fgets($file);

      if($data!="" && strlen($data) > 1){
      
        $matrizPoke[] = explode("|", rtrim($data));
      }
    }

    $tabla = "<table border='1'>";

    
    for ($i=0; $i < count($matrizPoke); $i++) { 
      
      
      $tabla .="<tr>";

      
      for ($x=0; $x < count($matrizPoke[$i]); $x++) {
        $tabla .= "<td>";
        $tabla .= $matrizPoke[$i][$x];
        $tabla .= "</td>";

      }

      $tabla .="</tr>";
    }

    
    $tabla .= "</table>"; 

    
    echo "$tabla";
  
}


  

   
  if(isset($_POST['btn__matriz'])){

    PokeToTabla("comandos_71_Ranucci_Roman.csv", "r");
  }

?>



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


  </body>
  </html>





 