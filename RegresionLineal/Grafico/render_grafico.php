<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let miGrafico;
let datosPrediccionActual = null; 

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

// ================= HISTÓRICO =================
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
            const data = JSON.parse(response);
            let titulo = fuente === 'Estatal' ? `Abandono (Ambos) en ${estadoNombre} - Año ${anio}` : `Total Nacional (${fuente}) - Año ${anio}`;
            let color = (fuente === 'Perros') ? '#2980b9' : ((fuente === 'Gatos') ? '#d35400' : '#27ae60');

            $('#contenedor-scroll').show();
            $('#contenedor-canvas').css('width', '100%');
            
            const datasetsFormat = [{
                label: titulo,
                data: data.valores,
                backgroundColor: color,
                borderColor: color,
                borderWidth: 1,
                borderRadius: 4
            }];

            renderizarGenerico(data.labels, datasetsFormat, 'bar');
        }
    });
}

// ================= PREDICCIÓN =================
function iniciarPrediccion() {
    const especie = $('input[name="pred-especie"]:checked').val();
    const resolucion = $('input[name="pred-resolucion"]:checked').val();
    const aniosSeleccionados = [];
    $('.pred-anio:checked').each(function() { aniosSeleccionados.push($(this).val()); });

    if(aniosSeleccionados.length === 0) {
        alert("Por favor, selecciona al menos un año a proyectar."); return;
    }

    $('#btn-predecir').prop('disabled', true).css({background: '#95a5a6'});
    $('#progreso-container').fadeIn();
    let progreso = 0;
    
    const intervalo = setInterval(() => {
        progreso += Math.floor(Math.random() * 20) + 5;
        if(progreso >= 100) {
            progreso = 100;
            clearInterval(intervalo);
            ejecutarAjaxPrediccion(especie, aniosSeleccionados, resolucion);
        }
        $('#progreso-barra').css('width', progreso + '%');
        $('#progreso-porcentaje').text(progreso + '%');
    }, 150);
}

function ejecutarAjaxPrediccion(especie, anios, resolucion) {
    $.ajax({
        url: 'RegresionLineal/ProyeccionPredictiva.php',
        type: 'POST',
        data: { especie: especie, anios: anios, resolucion: resolucion },
        success: function(response) {
            datosPrediccionActual = JSON.parse(response);

            $('#controles-historico').hide();
            $('#controles-prediccion').css('display', 'flex').hide().fadeIn();
            $('#tipo-vista-pred').val('bar'); 
            
            cambiarVistaPrediccion(); 

            $('#btn-predecir').prop('disabled', false).css({background: '#01833d'});
            $('#progreso-container').hide();
            $('#progreso-barra').css('width', '0%');
        }
    });
}

function cambiarVistaPrediccion() {
    if(!datosPrediccionActual) return;
    const vista = $('#tipo-vista-pred').val();

    if (vista === 'explicacion') {
        $('#contenedor-scroll').hide();
        $('#contenedor-explicacion').html(datosPrediccionActual.explicacion).fadeIn();
    } else {
        $('#contenedor-explicacion').hide();
        $('#contenedor-scroll').fadeIn();

        let numLabels = datosPrediccionActual.labels.length;
        if (numLabels > 15) {
            $('#contenedor-canvas').css('width', (numLabels * 35) + 'px');
        } else {
            $('#contenedor-canvas').css('width', '100%');
        }

        let datasetsFormat = [];
        const esDispersion = (vista === 'scatter');
        
        datosPrediccionActual.datasets.forEach(ds => {
            datasetsFormat.push({
                // Si es dispersión, usamos 'line' con la línea oculta para conservar el eje categórico intacto
                type: esDispersion ? 'line' : 'bar',
                label: ds.label,
                data: ds.data,
                backgroundColor: ds.color,
                borderColor: ds.color,
                borderWidth: esDispersion ? 0 : 2,
                borderRadius: 4,
                pointRadius: esDispersion ? 6 : 0, // Tamaño visible para los puntos
                pointHoverRadius: 8,
                showLine: !esDispersion, // Desactiva la línea si es vista de dispersión
                fill: false
            });
        });

        renderizarGenerico(datosPrediccionActual.labels, datasetsFormat, 'bar');
    }
}

function volverAlHistorico() {
    $('#controles-prediccion').hide();
    $('#contenedor-explicacion').hide();
    $('#contenedor-scroll').fadeIn();
    $('#controles-historico').css('display', 'flex').hide().fadeIn();
    cargarHistorico(); 
}

function renderizarGenerico(labels, datasets, tipoPrincipal) {
    const ctx = document.getElementById('chartPredictivo').getContext('2d');
    if (miGrafico) { miGrafico.destroy(); }
    miGrafico = new Chart(ctx, {
        type: tipoPrincipal,
        data: { labels: labels, datasets: datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 800 },
            scales: { 
                x: {
                    type: 'category' // Forzamos el comportamiento de categorías para evitar desborde de cuadrantes
                },
                y: { 
                    beginAtZero: true 
                } 
            }
        }
    });
}
</script>