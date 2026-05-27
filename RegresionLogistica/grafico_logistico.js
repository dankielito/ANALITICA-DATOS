let chartAdopcion;

function cargarModeloLogistico() {
    const tamano = document.getElementById('filtro-tamano').value;
    
    // Mostrar estado de carga y desactivar botón temporalmente
    document.getElementById('cargando-logistico').style.display = 'inline-block';
    document.getElementById('filtro-tamano').disabled = true;

    fetch('RegresionLogistica/api_adoptabilidad.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `tamano=${tamano}`
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('cargando-logistico').style.display = 'none';
        document.getElementById('filtro-tamano').disabled = false;
        
        if(data.error) {
            alert(data.error);
            return;
        }
        renderizarCanvasLogistico(data.scatter, data.curve, data.max_dias);
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('cargando-logistico').style.display = 'none';
        document.getElementById('filtro-tamano').disabled = false;
    });
}

function renderizarCanvasLogistico(datosDispersos, curvaProbabilidad, max_dias) {
    const ctx = document.getElementById('canvasLogistico').getContext('2d');
    
    if (chartAdopcion) {
        chartAdopcion.destroy();
    }

    chartAdopcion = new Chart(ctx, {
        type: 'scatter',
        data: {
            datasets: [
                {
                    type: 'line',
                    label: 'Curva de Probabilidad (S)',
                    data: curvaProbabilidad,
                    borderColor: '#2ecc71',
                    borderWidth: 3,
                    pointRadius: 0, 
                    fill: false,
                    tension: 0.4
                },
                {
                    type: 'scatter',
                    label: 'Registros Reales',
                    data: datosDispersos,
                    backgroundColor: 'rgba(52, 152, 219, 0.4)',
                    borderColor: 'rgba(52, 152, 219, 0.8)',
                    borderWidth: 1,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Forzado por el contenedor estricto de CSS
            resizeDelay: 50, // Evita ejecuciones en bucle al redimensionar la ventana
            animation: { duration: 1000, easing: 'easeOutQuart' },
            scales: {
                x: {
                    title: { display: true, text: 'Tiempo en Refugio (Días)', font: { weight: 'bold', size: 11 } },
                    type: 'linear',
                    position: 'bottom',
                    min: 0,
                    max: max_dias + 5,
                    ticks: { font: { size: 10 } }
                },
                y: {
                    title: { display: true, text: 'Probabilidad', font: { weight: 'bold', size: 11 } },
                    min: -0.05,
                    max: 1.05,
                    ticks: {
                        font: { size: 10 },
                        callback: function(value) {
                            if(value === 1) return '100% (Adoptado)';
                            if(value === 0) return '0%';
                            return (value * 100).toFixed(0) + '%';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    labels: { boxWidth: 12, font: { size: 11 } }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            if (context.datasetIndex === 0) {
                                return `Probabilidad: ${(context.raw.y * 100).toFixed(1)}% a los ${context.raw.x} días`;
                            } else {
                                return `Registro: ${context.raw.x} días -> Estado: ${context.raw.y === 1 ? 'Adoptado' : 'En Refugio'}`;
                            }
                        }
                    }
                }
            }
        }
    });
}

// Cargar globalmente al iniciar
document.addEventListener('DOMContentLoaded', cargarModeloLogistico);