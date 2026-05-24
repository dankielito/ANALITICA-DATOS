/* centrosAdopcion.js - Enfoque exclusivo en Gráficas de Infraestructura */

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartEstados').getContext('2d');
    
    // Identificadores de los 32 estados de la República Mexicana
    const estados = [
        "AGS", "BC", "BCS", "CAM", "CHIS", "CHIH", "CDMX", "COAH", 
        "COL", "DGO", "MEX", "GTO", "GRO", "HGO", "JAL", "MICH", 
        "MOR", "NAY", "NL", "OAX", "PUE", "QRO", "QR", "SLP", 
        "SIN", "SON", "TAB", "TAM", "TLA", "VER", "YUC", "ZAC"
    ];
    
    const dataRefugios = {
        labels: estados,
        datasets: [
            {
                label: 'Centros Gubernamentales',
                data: [5, 8, 3, 4, 6, 10, 15, 7, 3, 5, 12, 9, 4, 6, 11, 8, 5, 3, 10, 5, 9, 7, 5, 6, 7, 8, 4, 6, 3, 10, 6, 4],
                backgroundColor: '#01833d', // Verde Institucional
                borderRadius: 5
            },
            {
                label: 'Refugios Privados (OSC)',
                data: [12, 15, 7, 8, 10, 18, 45, 14, 6, 10, 35, 20, 11, 15, 28, 16, 12, 7, 25, 12, 22, 18, 14, 15, 16, 18, 9, 14, 8, 20, 14, 9],
                backgroundColor: '#ffd600', // Amarillo de contraste
                borderRadius: 5
            }
        ]
    };

    // Inicialización de Chart.js
    new Chart(ctx, {
        type: 'bar',
        data: dataRefugios,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    stacked: true,
                    title: {
                        display: true,
                        text: 'Cantidad de Centros'
                    }
                },
                x: { 
                    stacked: true,
                    grid: {
                        display: false // Limpia el ruido visual del fondo
                    }
                }
            },
            plugins: {
                legend: { 
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    padding: 12,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)'
                }
            }
        }
    });
});