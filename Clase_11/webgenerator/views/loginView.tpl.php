@extends(head)
<body>

	<h1>webgenerator Roman</h1>

	<form action="?slug=login" method="POST">
		<input type="email" name="txt_email" placeholder="Email" required>
		<input type="password" name="txt_password" placeholder="Contraseña" required>
		<input type="submit" name="btn_login" value="Ingresar">
	</form>

	<p><a href="?slug=register">Registrarse</a></p>

	<div style="color: red;">{{ MESSAGE }}</div>

	@extends(footer)
	
</body>
</html>