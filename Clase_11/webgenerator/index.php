<?php 


	/**
	 * 
	 * index.php va a funcionar como un ROUTER y FIREWALL
	 * 
	 * 
	 * */

	/* clases, modelos, librerias que van a funcionar en todos los controladores*/

	include '.env.php';
	include 'models/DBAbstract.php';
	include 'models/Usuario.php';
	include 'models/Web.php';

	include 'librarys/lagarto/Lagarto.php';


	/* por defecto el controlador a cargar es landing */
	$section = "landing";

	/* en caso de que pasen un valor por slug*/
	if(isset($_GET['slug'])){
		$section = $_GET['slug'];
	}

	/* en caso de que el controlador no exista debo mostrar un mensaje de seccion no valida */

	if(!file_exists('controllers/'.$section.'Controller.php')){
		$section = "error";
	}



	include 'controllers/'.$section.'Controller.php';

 ?>