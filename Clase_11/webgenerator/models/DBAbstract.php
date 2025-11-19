<?php 



	/**
	 * Esta clase solo es funcional si es heredada
	 */
	class DBAbstract
	{

		private $db;
		
		function __construct()
		{
			$this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		}


		/* funciona con SELECT, INSERT, UPDATE, DELETE */
		public function consulta($ssql){
			$response = $this->db->query($ssql);

			/* si es SELECT devolver los resultados */
			if($response && $response instanceof mysqli_result){
				return $response->fetch_all(MYSQLI_ASSOC);
			}

			/* para INSERT, UPDATE, DELETE devolver true/false */
			return $response;
		}


	}
	


 ?>