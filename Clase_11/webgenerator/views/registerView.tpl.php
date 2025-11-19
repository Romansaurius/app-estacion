@extends(head)
<body>

	<h1>Registrarte es simple.</h1>

	<form action="?slug=register" method="POST">
		<input type="email" name="txt_email" placeholder="Email" required>
		<input type="password" name="txt_password" placeholder="Contraseña" required>
		<input type="password" name="txt_password2" placeholder="Repetir contraseña" required>
		<input type="submit" name="btn_register" value="Registrarse">
	</form>

	<p><a href="?slug=login">Ya tengo cuenta</a></p>

	<div style="color: red;">{{ MESSAGE }}</div>

	@extends(footer)
	
</body>
</html>