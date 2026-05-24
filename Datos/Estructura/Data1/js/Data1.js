document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartPoblacion').getContext('2d');

    // Función para crear el patrón de silueta (Marca de agua)
    function createPattern(emoji, bgColor) {
        const patternCanvas = document.createElement('canvas');
        const pCtx = patternCanvas.getContext('2d');
        const size = 60; 
        patternCanvas.width = size;
        patternCanvas.height = size;

        pCtx.fillStyle = bgColor;
        pCtx.fillRect(0, 0, size, size);

        pCtx.textAlign = 'center';
        pCtx.textBaseline = 'middle';
        pCtx.font = '30px serif';
        // Ajustamos la opacidad para que el emoji sea visible sobre colores oscuros
        pCtx.fillStyle = 'rgba(255, 255, 255, 0.2)'; 
        pCtx.fillText(emoji, size / 2, size / 2);

        return ctx.createPattern(patternCanvas, 'repeat');
    }

    // Definición de patrones con colores institucionales
    const patternPerro = createPattern('🐕', '#01833d'); // Verde UPIICSA
    const patternGato = createPattern('🐈', '#ffd600');  // Amarillo Acento
    const patternCasa = createPattern('🏠', '#762744');  // Guinda IPN (Actualizado)

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Perros (Calle)', 'Gatos (Calle)', 'Mascotas'],
            datasets: [{
                data: [18.9, 8.1, 53],
                backgroundColor: [patternPerro, patternGato, patternCasa],
                hoverOffset: 25,
                borderWidth: 4,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        color: '#000000',
                        font: { size: 14, weight: 'bold' }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.parsed;
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentage = ((value * 100) / total).toFixed(2);

                            return `${label}: ${value} Millones (${percentage}%)`;
                        }
                    },
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: { size: 16 },
                    bodyFont: { size: 14 },
                    padding: 12,
                    displayColors: true
                }
            },
            // Efecto de animación para que se vea más fluido al cargar
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
});