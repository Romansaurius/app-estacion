<?php 

	session_start();

	/* si el usuario ya está logueado, redirigir a panel */
	if(isset($_SESSION['idUsuario'])){
		header("Location: ?slug=panel");
		exit;
	}

	$usuario = new Usuario();
	$message = "";

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$response = $usuario->login($_POST);

		if($response["errno"]==201){
			$_SESSION['idUsuario'] = $usuario->idUsuario;
			$_SESSION['email'] = $usuario->email;
			header("Location: ?slug=panel");
			exit;
		}

		if($response["errno"] != 204){
			$message = $response["error"];
		}
	}
	
	$tpl = new Lagarto("login");
	$tpl->assing(["MESSAGE" => $message]);
	$tpl->printToScreen();

 ?>