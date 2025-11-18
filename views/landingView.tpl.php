@extends(head)
<body>
	<div class="container">
		<h1>{{ APP_NAME }}</h1>
		<div style="text-align: center; padding: 40px;">
			<h2>Monitor de Estaciones Meteorológicas</h2>
			<p>Esta aplicación te permite monitorear estaciones meteorológicas en tiempo real. 
			Consulta datos de temperatura, humedad y otras variables climáticas de diferentes ubicaciones.</p>
			<a href="?slug=panel" class="btn">Ver Estaciones</a>
		</div>
	</div>
	@extends(footer)
</body>
</html>