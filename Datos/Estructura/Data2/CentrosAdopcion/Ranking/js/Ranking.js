/* Ranking.js */
document.addEventListener('DOMContentLoaded', function() {
    const contenedor = document.getElementById('contenedorRankingEstados');
    const estados = ["Aguascalientes", "Baja California", "Baja California Sur", "Campeche", "Chiapas", "Chihuahua", "CDMX", "Coahuila", "Colima", "Durango", "Estado de México", "Guanajuato", "Guerrero", "Hidalgo", "Jalisco", "Michoacán", "Morelos", "Nayarit", "Nuevo León", "Oaxaca", "Puebla", "Querétaro", "Quintana Roo", "San Luis Potosí", "Sinaloa", "Sonora", "Tabasco", "Tamaulipas", "Tlaxcala", "Veracruz", "Yucatán", "Zacatecas"];

    // Generar automáticamente las 32 entidades con datos de ejemplo
    estados.forEach(estado => {
        const card = document.createElement('div');
        card.className = 'estado-card';
        card.innerHTML = `
            <h5>${estado}</h5>
            <ul class="top3-lista">
                <li>🥇 Centro Estatal de Control</li>
                <li>🥈 Refugio Local OSC</li>
                <li>🥉 Asociación Civil Regional</li>
            </ul>
        `;
        contenedor.appendChild(card);
    });
});