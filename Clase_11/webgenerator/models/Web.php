<?php 

	/**
	 * 
	 * Clase que contiene todos los atributos y metodos de una web
	 * 
	 */
	class Web extends DBAbstract
	{
		public $idWeb;
		public $idUsuario;
		public $dominio;
		
		function __construct()
		{
			parent::__construct();
			$this->idWeb = 0;
			$this->idUsuario = 0;
			$this->dominio = "";
		}

		public function getById($idWeb){
			$response = $this->consulta("SELECT * FROM webs WHERE idWeb = ".$idWeb);
			if(count($response) > 0){
				$this->idWeb = $response[0]["idWeb"];
				$this->idUsuario = $response[0]["idUsuario"];
				$this->dominio = $response[0]["dominio"];
				return true;
			}
			return false;
		}
	}

 ?>