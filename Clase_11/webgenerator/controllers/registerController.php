<?php 

	session_start();

	/* si el usuario ya está logueado, redirigir a panel */
	if(isset($_SESSION['idUsuario'])){
		header("Location: ?slug=panel");
		exit;
	}

	$usuario = new Usuario();
	$message = "";

	$response = $usuario->register($_POST);

	if($response["errno"]==201){
		$message = $response["error"];
		header("refresh:2;url=?slug=login");
	} else if($response["errno"] != 204){
		$message = $response["error"];
	}
	
	$tpl = new Lagarto("register");
	$tpl->assing(["MESSAGE" => $message]);
	$tpl->printToScreen();

 ?>