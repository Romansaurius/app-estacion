document.addEventListener('DOMContentLoaded', function() {
    cargarEstaciones();
});

async function cargarEstaciones() {
    try {
        const response = await fetch('api.php');
        const estaciones = await response.json();
        
        const container = document.getElementById('estaciones-list');
        container.innerHTML = '';
        
        estaciones.forEach(estacion => {
            const card = crearTarjetaEstacion(estacion);
            container.appendChild(card);
        });
        
    } catch (error) {
        console.error('Error al cargar estaciones:', error);
    }
}

function crearTarjetaEstacion(estacion) {
    const card = document.createElement('a');
    card.href = `panel.php?chipid=${estacion.chipid}`;
    card.className = `estacion-card ${estacion.dias_inactivo > 0 ? 'inactiva' : ''}`;
    
    const isInactiva = parseInt(estacion.dias_inactivo) > 0;
    
    card.innerHTML = `
        <div class="estacion-header">
            <div class="estacion-name">${estacion.apodo}</div>
            <div class="estacion-visitas">
                ${estacion.visitas} <i class="fas fa-tower-observation"></i>
            </div>
        </div>
        <div class="estacion-location">
            <i class="fas fa-map-marker-alt location-icon"></i>
            ${estacion.ubicacion}
        </div>
        ${isInactiva ? '<span class="status-badge">Inactiva</span>' : ''}
    `;
    
    return card;
}