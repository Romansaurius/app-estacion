<?php 


	/***
	 * 
	 * 
	 * librerias
	 * 
	 * 
	 * */



	/***
	 * 
	 * 
	 * logica de negocio
	 * 
	 * 
	 * */


	/**
	 * 
	 * 
	 * imprimir la vista
	 * 
	 * 
	 * */
	$tpl = new Lagarto("landing");
	
	$tpl->assing(["APP_SECTION" => "Bienvenido"]);

	$tpl->printToScreen();


 ?>