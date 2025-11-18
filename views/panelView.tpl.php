@extends(head)
<body>
	<div class="container">
		<h1>Panel de Estaciones</h1>
		<div class="loading" id="loading">Cargando estaciones...</div>
		<div class="estacion-list" id="estacionList"></div>
		
		<template id="estacionTemplate">
			<a href="#" class="estacion-btn">
				<strong class="apodo"></strong><br>
				<span class="ubicacion"></span><br>
				<small>Visitas: <span class="visitas"></span></small>
			</a>
		</template>
	</div>

	<script>
		async function cargarEstaciones() {
			try {
				const response = await fetch('{{ API_URL }}');
				const data = await response.json();
				
				const loading = document.getElementById('loading');
				const list = document.getElementById('estacionList');
				const template = document.getElementById('estacionTemplate');
				
				loading.style.display = 'none';
				
				data.forEach(estacion => {
					const clone = template.content.cloneNode(true);
					clone.querySelector('.apodo').textContent = estacion.apodo;
					clone.querySelector('.ubicacion').textContent = estacion.ubicacion;
					clone.querySelector('.visitas').textContent = estacion.visitas;
					clone.querySelector('.estacion-btn').href = `?slug=detalle&chipid=${estacion.chipid}`;
					list.appendChild(clone);
				});
			} catch (error) {
				document.getElementById('loading').textContent = 'Error al cargar estaciones';
			}
		}
		
		cargarEstaciones();
	</script>
	
	@extends(footer)
</body>
</html>