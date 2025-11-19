@extends(head)
<body>

	<h1>Bienvenido a tu panel</h1>

	<p><a href="?slug=logout">Cerrar sesión de {{ ID_USUARIO }}</a></p>

	<h2>Generar Web de:</h2>
	<form action="?slug=panel" method="POST">
		<input type="text" name="txt_nombre" placeholder="Nombre de la web" required>
		<input type="submit" name="btn_crear_web" value="Crear web">
	</form>

	<div style="color: green;">{{ MESSAGE }}</div>

	<h2>Mis webs:</h2>
	<div>{{ WEBS_LIST }}</div>

	@extends(footer)
	
</body>
</html>