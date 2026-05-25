<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let miGrafico;

$(document).ready(function() {
    toggleEstado();
    cargarHistorico();
});

function toggleEstado() {
    if($('#hist-fuente').val() === 'Estatal') {
        $('#contenedor-estado').show();
    } else {
        $('#contenedor-estado').hide();
    }
}

function cargarHistorico() {
    const fuente = $('#hist-fuente').val();
    const anio = $('#hist-anio').val();
    const estadoID = $('#hist-estado').val();
    const estadoNombre = $('#hist-estado option:selected').text();
    
    $.ajax({
        url: `RegresionLineal/Grafico/get_datos${fuente}.php`,
        type: 'POST',
        data: { anio: anio, estado: estadoID },
        success: function(response) {
            try {
                const data = JSON.parse(response);
                let color = (fuente === 'Perros') ? '#2980b9' : ((fuente === 'Gatos') ? '#d35400' : '#27ae60');
                let titulo = (fuente === 'Estatal') ? `Abandono en ${estadoNombre} (${anio})` : `Nacional (${fuente}) - ${anio}`;
                renderizarGrafico(data.labels, data.valores, titulo, color);
            } catch(e) { console.error("Error:", response); }
        }
    });
}

function renderizarGrafico(labels, valores, tituloLabel, color) {
    const ctx = document.getElementById('chartPredictivo').getContext('2d');
    if (miGrafico) miGrafico.destroy();
    miGrafico = new Chart(ctx, {
        type: 'bar',
        data: { labels: labels, datasets: [{ label: tituloLabel, data: valores, backgroundColor: color }] },
        options: { responsive: true, maintainAspectRatio: false }
    });
}
</script>