<?php 

	$chipid = isset($_GET['chipid']) ? $_GET['chipid'] : '';

	$tpl = new Lagarto("detalle");
	$tpl->assing([
		"CHIPID" => $chipid,
		"API_URL" => API_ESTACIONES
	]);
	$tpl->printToScreen();

 ?>