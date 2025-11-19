<?php 

	/**
	 * 
	 * Clase que contiene todos los atributos y metodos de un usuario
	 * 
	 */
	class Usuario extends DBAbstract
	{
		public $idUsuario;
		public $email;
		
		function __construct()
		{
			parent::__construct();
			$this->idUsuario = 0;
			$this->email = "";
		}
	

		public function login($form){

			/* si no se presiono el boton */
			if(!isset($form["btn_login"])){
				return ["errno" => 204,
				 "error" => "Falta presionar el botón"];
			}

			/* no esta cargado el email */
			if( strlen($_POST['txt_email'])==0){
				return ["errno" => 400,
				 "error" => "Falta email"];
			}

			/*no esta cargada la contraseña */
			if( strlen($_POST['txt_password']) == 0){
				return ["errno" => 400,
				 "error" => "Falta contraseña"];
			}

			$response = $this->consulta("SELECT * FROM usuarios WHERE email like '".$_POST['txt_email']."'");

			/* averiguo si existe el email en la base de datos*/
			if(count($response)==0){
				return ["errno" => 404,
				 "error" => "Email no registrado"]; 
			}

			if($_POST['txt_password']!=$response[0]["password"]){
				return ["errno" => 404,
				 "error" => "Contraseña incorrecta"]; 
			}

			/* si llegamos hasta aqui es que el email y la pass son validos*/
			$this->idUsuario = $response[0]["idUsuarios"];
			$this->email = $_POST['txt_email'];

			return ["errno" => 201,
				 "error" => "Logueo exitoso"];
		}

		public function register($form){
			/* si no se presiono el boton */
			if(!isset($form["btn_register"])){
				return ["errno" => 204,
				 "error" => ""];
			}

			/* validaciones */
			if(strlen($_POST['txt_email'])==0){
				return ["errno" => 400,
				 "error" => "Falta email"];
			}

			if(strlen($_POST['txt_password'])==0){
				return ["errno" => 400,
				 "error" => "Falta contraseña"];
			}

			if(strlen($_POST['txt_password2'])==0){
				return ["errno" => 400,
				 "error" => "Falta repetir contraseña"];
			}

			if($_POST['txt_password'] != $_POST['txt_password2']){
				return ["errno" => 400,
				 "error" => "Las contraseñas no coinciden"];
			}

			/* verificar si el email ya existe */
			$response = $this->consulta("SELECT * FROM usuarios WHERE email like '".$_POST['txt_email']."'");
			
			if(count($response) > 0){
				return ["errno" => 409,
				 "error" => "El email ya está registrado"];
			}

			/* insertar nuevo usuario */
			$this->consulta("INSERT INTO usuarios (email, password, fechaRegistro) VALUES ('".$_POST['txt_email']."', '".$_POST['txt_password']."', NOW())");

			return ["errno" => 201,
				 "error" => "Registro exitoso"];
		}

		public function getWebs($idUsuario){
			return $this->consulta("SELECT * FROM webs WHERE idUsuario = ".$idUsuario);
		}

		public function getAllWebs(){
			return $this->consulta("SELECT w.*, u.email FROM webs w JOIN usuarios u ON w.idUsuario = u.idUsuario");
		}

		public function createWeb($idUsuario, $nombre){
			$dominio = $nombre . $idUsuario;
			
			/* verificar si el dominio ya existe */
			$response = $this->consulta("SELECT * FROM webs WHERE dominio like '".$dominio."'");
			
			if(count($response) > 0){
				return ["errno" => 409,
				 "error" => "Ya existe una web con ese nombre"];
			}

			/* insertar nueva web */
			$this->consulta("INSERT INTO webs (idUsuario, dominio, fechaCreacion) VALUES (".$idUsuario.", '".$dominio."', NOW())");

			return ["errno" => 201,
				 "error" => "Web creada exitosamente",
				 "dominio" => $dominio];
		}

		public function deleteWeb($idWeb, $idUsuario){
			$this->consulta("DELETE FROM webs WHERE idWeb = ".$idWeb." AND idUsuario = ".$idUsuario);
		}
	}

 ?>