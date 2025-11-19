<?php 
$logFile = 'navegacion.log';


$fechaHora = date('Ymd_His');
$ip = $_SERVER['REMOTE_ADDR'] ?? 'IP desconocida';
$navegador = $_SERVER['HTTP_USER_AGENT'] ?? 'Navegador desconocido';

$mensaje = "*|$fechaHora|$ip|$navegador|anónimo ingreso a index.php." . PHP_EOL;


if (!isset($_POST['btn__guardar'])) {

	  
    $archivo = fopen($logFile, "a");
    fwrite($archivo, "*|$fechaHora|$ip|$navegador|anónimo ingreso a index.php." . PHP_EOL);
    fclose($archivo);
}

if (isset($_POST['btn__guardar'])) {
    $fechaHora = date('Ymd_His'); 
    $archivo = fopen($logFile, "a");
    fwrite($archivo, "+|$fechaHora|$ip|$navegador|anónimo presionó 'Login'." . PHP_EOL);
    fclose($archivo);
}



    $file = fopen("navegacion.log", "r");
    $logins = 0;
    $ingresos = 0;
    while (!feof($file)) {

	        $data = fgets($file);
		      $matriz = str_split($data);
		      if (count($matriz) >= 2) {
				        if ($matriz[0] == '*' && $matriz[1] == '|') {
				            $ingresos++;
				        } elseif ($matriz[0] == '+' && $matriz[1] == '|') {
				            $logins++;
				        }
				  }
			      
    }


    fclose($file); 

  



?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<title>Escribir</title>
 </head>
 <body>

 	<h1>Registro de nuevo entrenador</h1>
 	<form action="" method="POST">
 		
 		<input type="submit" name="btn__guardar" value="Login">

 		<table border="1" style="margin-top: 20px;">
    <tr>
        <th>Ingresos</th>
        <th>Login</th>
    </tr>
    <tr>
        <td><?php echo $ingresos; ?></td>
        <td><?php echo $logins; ?></td>
    </tr>
</table>


 	</form>
 	
 </body>
 </html>