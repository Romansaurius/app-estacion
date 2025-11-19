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
				console.log('Cargando desde:', '{{ API_URL }}');
				const response = await fetch('{{ API_URL }}');
				
				if (!response.ok) {
					throw new Error(`HTTP ${response.status}`);
				}
				
				const data = await response.json();
				console.log('Datos recibidos:', data);
				
				mostrarEstaciones(data);
				
			} catch (error) {
				console.error('Error API:', error);
				// Usar datos de prueba como fallback
				const datosPrueba = [
					{chipid: '001', apodo: 'Estación Centro', ubicacion: 'Buenos Aires', visitas: 150},
					{chipid: '002', apodo: 'Estación Norte', ubicacion: 'Córdoba', visitas: 89},
					{chipid: '003', apodo: 'Estación Sur', ubicacion: 'Mendoza', visitas: 203}
				];
				mostrarEstaciones(datosPrueba);
				document.getElementById('loading').textContent = 'Usando datos de prueba (API no disponible)';
			}
		}
		
		function mostrarEstaciones(data) {
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
		}
		
		cargarEstaciones();
	</script>
	
	@extends(footer)
</body>
</html>