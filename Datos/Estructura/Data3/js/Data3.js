document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('chartImpactoSalud').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            datasets: [
                {
                    label: 'Casos de Zoonosis (Tendencia)',
                    data: [45, 42, 38, 35, 30, 28, 25, 22, 20, 18, 15, 12],
                    borderColor: '#8a2e4f', // Guinda sustituyendo al negro
                    backgroundColor: 'rgba(138, 46, 79, 0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Eficacia Esterilización (%)',
                    data: [10, 15, 25, 35, 45, 50, 60, 70, 75, 80, 85, 90],
                    borderColor: '#01833d', // Verde
                    backgroundColor: 'transparent',
                    borderDash: [5, 5],
                    tension: 0.1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});