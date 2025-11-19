@extends(head)
<body>
	<div class="container">
		<h1>Detalle de Estación</h1>
		<div class="loading" id="loading">Cargando datos...</div>
		<div id="detalleContent" style="display: none;">
			<h2 id="apodo"></h2>
			<p><strong>Ubicación:</strong> <span id="ubicacion"></span></p>
			<p><strong>ChipID:</strong> <span id="chipidDisplay"></span></p>
			<a id="verDatosReales" href="#" target="_blank" class="btn">Ver Datos en Tiempo Real</a>
			<a href="?slug=panel" class="btn">Volver al Panel</a>
		</div>
	</div>

	<script>
		const chipid = '{{ CHIPID }}';
		
		async function cargarDetalle() {
			try {
				const response = await fetch('{{ API_URL }}');
				const data = await response.json();
				mostrarDetalle(data);
			} catch (error) {
				document.getElementById('loading').textContent = 'Error al cargar estación';
			}
		}
		
		function mostrarDetalle(data) {
			const estacion = data.find(e => e.chipid == chipid);
			
			if (estacion) {
				document.getElementById('apodo').textContent = estacion.apodo;
				document.getElementById('ubicacion').textContent = estacion.ubicacion;
				document.getElementById('loading').style.display = 'none';
				document.getElementById('detalleContent').style.display = 'block';
			} else {
				document.getElementById('loading').textContent = 'Estación no encontrada';
			}
		}
		
		if (chipid) {
			cargarDetalle();
		}
	</script>
	
	@extends(footer)
</body>
</html>