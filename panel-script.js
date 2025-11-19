document.addEventListener('DOMContentLoaded', function() {
    actualizarFechaHora();
    setInterval(actualizarFechaHora, 1000);
    crearGrafico();
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

function crearGrafico() {
    const ctx = document.getElementById('tempChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['01:09', '01:10', '01:11', '01:12', '01:13', '01:14'],
            datasets: [{
                data: [25, 25, 25, 25, 25, 25],
                borderColor: '#ffa500',
                backgroundColor: 'transparent',
                borderWidth: 3,
                pointBackgroundColor: '#ffa500',
                pointBorderColor: '#ffa500',
                pointRadius: 6,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: 'white'
                    }
                },
                y: {
                    min: 0,
                    max: 30,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'white',
                        stepSize: 5
                    }
                }
            }
        }
    });
}