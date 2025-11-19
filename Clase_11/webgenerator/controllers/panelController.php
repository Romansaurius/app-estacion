<?php 

	session_start();

	/* si el usuario no está logueado, redirigir a login */
	if(!isset($_SESSION['idUsuario'])){
		header("Location: ?slug=login");
		exit;
	}

	$usuario = new Usuario();
	$web = new Web();
	$message = "";

	/* crear nueva web */
	if(isset($_POST['btn_crear_web'])){
		if(strlen($_POST['txt_nombre']) > 0){
			$response = $usuario->createWeb($_SESSION['idUsuario'], $_POST['txt_nombre']);
			$message = $response["error"];
			
			if($response["errno"] == 201){
				/* crear directorio webs si no existe */
				if(!is_dir('webs')){
					mkdir('webs', 0755, true);
				}
				/* ejecutar script wix.sh */
				$dominio = $response["dominio"];
				shell_exec("bash scripts/wix.sh ".$dominio);
			}
		} else {
			$message = "Falta nombre para la web";
		}
	}

	/* eliminar web */
	if(isset($_GET['delete'])){
		$idWeb = $_GET['delete'];
		$web->getById($idWeb);
		
		/* verificar que la web pertenece al usuario o es admin */
		if($web->idUsuario == $_SESSION['idUsuario'] || $_SESSION['email'] == 'admin@server.com'){
			/* eliminar carpeta */
			shell_exec("rm -rf webs/".$web->dominio);
			/* eliminar de base de datos */
			$usuario->deleteWeb($idWeb, $web->idUsuario);
			$message = "Web eliminada";
		}
	}

	/* descargar web */
	if(isset($_GET['download'])){
		$idWeb = $_GET['download'];
		$web->getById($idWeb);
		
		if($web->idUsuario == $_SESSION['idUsuario'] || $_SESSION['email'] == 'admin@server.com'){
			$zipFile = $web->dominio.".zip";
			shell_exec("cd webs && zip -r ../".$zipFile." ".$web->dominio);
			
			header('Content-Type: application/zip');
			header('Content-Disposition: attachment; filename="'.$zipFile.'"');
			header('Content-Length: ' . filesize($zipFile));
			readfile($zipFile);
			unlink($zipFile);
			exit;
		}
	}

	/* obtener webs del usuario */
	$webs = [];
	if($_SESSION['email'] == 'admin@server.com'){
		$webs = $usuario->getAllWebs();
	} else {
		$webs = $usuario->getWebs($_SESSION['idUsuario']);
	}
	
	$tpl = new Lagarto("panel");
	$tpl->assing([
		"MESSAGE" => $message,
		"ID_USUARIO" => $_SESSION['idUsuario'],
		"WEBS_LIST" => generateWebsList($webs, $_SESSION['email'] == 'admin@server.com')
	]);
	$tpl->printToScreen();

	function generateWebsList($webs, $isAdmin){
		$html = "";
		foreach($webs as $web){
			$userInfo = $isAdmin ? " (Usuario: ".$web['email'].")" : "";
			$html .= "<div>";
			$html .= "<a href='webs/".$web['dominio']."/index.html' target='_blank'>".$web['dominio']."</a>".$userInfo;
			$html .= " <a href='?slug=panel&download=".$web['idWeb']."'>descargar web</a>";
			$html .= " <a href='?slug=panel&delete=".$web['idWeb']."' onclick='return confirm(\"¿Eliminar web?\")'>Eliminar</a>";
			$html .= "</div>";
		}
		return $html;
	}

 ?>