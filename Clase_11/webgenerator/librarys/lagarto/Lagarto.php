<?php 


	/**
	 * 
	 */
	class Lagarto
	{

		private $tpl_name;
		private $buffer_tpl;
		
		function __construct($tpl_name)
		{
			$this->tpl_name = $tpl_name;
			$this->load();
		}


		private function load(){
			/* aqui se guarda el contenido de la vista*/
			$this->buffer_tpl = file_get_contents("views/".$this->tpl_name."View.tpl.php"); 

			/* aqui se guarda el contenido del footer */
				$buffer_extends = file_get_contents("views/extends/footerExtends.tpl.php"); 

			/* reemplazo la palabra reservada @extends(footer) por el contenido de buffer_extends */
			$this->buffer_tpl = str_replace("@extends(footer)", $buffer_extends, $this->buffer_tpl);

			/* aqui se guarda el contenido del footer */
				$buffer_extends = file_get_contents("views/extends/headExtends.tpl.php"); 

			/* reemplazo la palabra reservada @extends(head) por el contenido de buffer_extends */
			$this->buffer_tpl = str_replace("@extends(head)", $buffer_extends, $this->buffer_tpl);

			$this->assing(["APP_NAME" => APP_NAME]);
				$this->assing(["APP_AUTHOR" => APP_AUTHOR]);
					$this->assing(["APP_DESCRIPTION" => APP_DESCRIPTION]);

		}

		public function assing($array_assoc){

			foreach ($array_assoc as $name_var_html => $value_var_php) {
				$this->buffer_tpl = str_replace("{{ ".$name_var_html." }}", $value_var_php, $this->buffer_tpl);			}

			
		}


		public function printToScreen(){
			echo $this->buffer_tpl;
		}
	}


 ?>