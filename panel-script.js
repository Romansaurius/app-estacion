let charts = {};
let chipid = '';
let datosHistoricos = {
    temperatura: [],
    humedad: [],
    viento: [],
    presion: [],
    incendio: [],
    timestamps: []
};

document.addEventListener('DOMContentLoaded', function() {
    // Obtener chipid de la URL
    const urlParams = new URLSearchParams(window.location.search);
    chipid = urlParams.get('chipid') || '713630';
    
    // Inicializar
    actualizarFechaHora();
    setInterval(actualizarFechaHora, 1000);
    
    inicializarGraficos();
    cargarDatos();
    
    // Actualizar datos cada 60 segundos
    setInterval(cargarDatos, 60000);
    
    // Manejar pestañas
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => cambiarTab(btn.dataset.tab));
    });
});

function actualizarFechaHora() {
    const ahora = new Date();
    
    const fecha = ahora.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
    
    const hora = ahora.toLocaleTimeString('es-ES', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    });
    
    document.getElementById('fecha').textContent = fecha;
    document.getElementById('hora').textContent = hora;
}

async function cargarDatos() {
    try {
        // Cargar información de la estación si no la tenemos
        if (document.getElementById('ubicacion').textContent === 'Cargando...') {
            await cargarInfoEstacion();
        }
        
        const response = await fetch(`datos-estacion.php?chipid=${chipid}`);
        const datos = await response.json();
        
        if (datos.error) {
            console.error('Error:', datos.error);
            return;
        }
        
        // Actualizar datos históricos
        const ahora = new Date();
        const timestamp = ahora.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
        
        datosHistoricos.temperatura.push(datos.temperatura);
        datosHistoricos.humedad.push(datos.humedad);
        datosHistoricos.viento.push(datos.viento_velocidad);
        datosHistoricos.presion.push(datos.presion);
        datosHistoricos.incendio.push(getRiesgoNumerico(datos.riesgo_incendio));
        datosHistoricos.timestamps.push(timestamp);
        
        // Mantener solo los últimos 10 puntos
        if (datosHistoricos.temperatura.length > 10) {
            Object.keys(datosHistoricos).forEach(key => {
                datosHistoricos[key].shift();
            });
        }
        
        // Actualizar UI
        actualizarInterfaz(datos);
        actualizarGraficos();
        
        document.getElementById('last-update').textContent = ahora.toLocaleTimeString('es-ES');
        
    } catch (error) {
        console.error('Error al cargar datos:', error);
    }
}

async function cargarInfoEstacion() {
    try {
        const response = await fetch('api.php');
        const estaciones = await response.json();
        
        const estacion = estaciones.find(e => e.chipid === chipid);
        if (estacion) {
            document.getElementById('ubicacion').textContent = estacion.ubicacion;
        }
    } catch (error) {
        console.error('Error al cargar info de estación:', error);
        document.getElementById('ubicacion').textContent = 'Ubicación no disponible';
    }
}

function actualizarInterfaz(datos) {
    // Valores principales
    document.getElementById('temp-value').textContent = datos.temperatura.toFixed(1);
    document.getElementById('humidity-value').textContent = datos.humedad;
    document.getElementById('wind-value').textContent = datos.viento_velocidad.toFixed(1);
    document.getElementById('wind-dir').textContent = datos.viento_direccion;
    document.getElementById('pressure-value').textContent = datos.presion.toFixed(1);
    document.getElementById('fire-risk').textContent = datos.riesgo_incendio;
    
    // Tarjetas laterales
    document.getElementById('temp-card').textContent = `${datos.temperatura.toFixed(1)}°C`;
    document.getElementById('humidity-card').textContent = `${datos.humedad}%`;
    document.getElementById('wind-card').textContent = `${datos.viento_velocidad.toFixed(1)}Km/H`;
    document.getElementById('wind-dir-card').textContent = datos.viento_direccion;
    document.getElementById('pressure-card').textContent = `${datos.presion.toFixed(1)}hPa`;
    document.getElementById('fire-card').textContent = datos.riesgo_incendio;
}

function inicializarGraficos() {
    const opciones = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: {
                grid: { display: false },
                ticks: { color: 'white' }
            },
            y: {
                grid: { color: 'rgba(255, 255, 255, 0.1)' },
                ticks: { color: 'white' }
            }
        }
    };
    
    // Temperatura
    charts.temperatura = new Chart(document.getElementById('tempChart'), {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                data: [],
                borderColor: '#ffa500',
                backgroundColor: 'transparent',
                borderWidth: 3,
                pointBackgroundColor: '#ffa500',
                pointRadius: 4,
                tension: 0.1
            }]
        },
        options: { ...opciones, scales: { ...opciones.scales, y: { ...opciones.scales.y, min: 0, max: 40 } } }
    });
    
    // Humedad
    charts.humedad = new Chart(document.getElementById('humidityChart'), {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                data: [],
                borderColor: '#00bfff',
                backgroundColor: 'transparent',
                borderWidth: 3,
                pointBackgroundColor: '#00bfff',
                pointRadius: 4,
                tension: 0.1
            }]
        },
        options: { ...opciones, scales: { ...opciones.scales, y: { ...opciones.scales.y, min: 0, max: 100 } } }
    });
    
    // Viento
    charts.viento = new Chart(document.getElementById('windChart'), {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                data: [],
                borderColor: '#87ceeb',
                backgroundColor: 'transparent',
                borderWidth: 3,
                pointBackgroundColor: '#87ceeb',
                pointRadius: 4,
                tension: 0.1
            }]
        },
        options: { ...opciones, scales: { ...opciones.scales, y: { ...opciones.scales.y, min: 0, max: 50 } } }
    });
    
    // Presión
    charts.presion = new Chart(document.getElementById('pressureChart'), {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                data: [],
                borderColor: '#44ff44',
                backgroundColor: 'transparent',
                borderWidth: 3,
                pointBackgroundColor: '#44ff44',
                pointRadius: 4,
                tension: 0.1
            }]
        },
        options: { ...opciones, scales: { ...opciones.scales, y: { ...opciones.scales.y, min: 990, max: 1040 } } }
    });
    
    // Riesgo de incendio
    charts.incendio = new Chart(document.getElementById('fireChart'), {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: '#ff4444',
                borderColor: '#ff4444',
                borderWidth: 1
            }]
        },
        options: { ...opciones, scales: { ...opciones.scales, y: { ...opciones.scales.y, min: 0, max: 5 } } }
    });
}

function actualizarGraficos() {
    Object.keys(charts).forEach(tipo => {
        charts[tipo].data.labels = [...datosHistoricos.timestamps];
        charts[tipo].data.datasets[0].data = [...datosHistoricos[tipo]];
        charts[tipo].update('none');
    });
}

function cambiarTab(tab) {
    // Actualizar botones
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelector(`[data-tab="${tab}"]`).classList.add('active');
    
    // Actualizar paneles
    document.querySelectorAll('.panel-section').forEach(panel => panel.classList.remove('active'));
    document.getElementById(`${tab}-panel`).classList.add('active');
}

function getRiesgoNumerico(riesgo) {
    const niveles = {
        'Muy bajo': 1,
        'Bajo': 2,
        'Moderado': 3,
        'Alto': 4,
        'Muy alto': 5
    };
    return niveles[riesgo] || 1;
}