<?php 

	$tpl = new Lagarto("panel");
	$tpl->assing(["API_URL" => API_ESTACIONES]);
	$tpl->printToScreen();

 ?>