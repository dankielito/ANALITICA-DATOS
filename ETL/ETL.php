<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<div class="etl-container" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333;">
    <div class="section-header" style="margin-bottom: 25px;">
        <h2>Exportación de Inteligencia (Carga ETL)</h2>
        <p>Selecciona los orígenes de datos operacionales o analíticos para extraer, transformar y consolidar reportes en Excel.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; margin-bottom: 25px;">
        
        <div class="card-etl" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border-top: 4px solid #9b59b6;">
            <h4 style="margin-top: 0; color: #2c3e50; border-bottom: 2px solid #f1f2f6; padding-bottom: 10px;">Fuentes Disponibles</h4>
            
            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #2980b9;">🗄️ 1. Base Operacional (analitca_animales_bd)</label>
                <div style="padding-left: 10px;">
                    <label style="display: block; margin: 5px 0; cursor: pointer;">
                        <input type="checkbox" class="chk-tabla" value="estadisticas_anuales"> Estadísticas Anuales
                    </label>
                    <label style="display: block; margin: 5px 0; cursor: pointer;">
                        <input type="checkbox" class="chk-tabla" value="perfil_animal"> Perfil del Animal (Registros de Adopción)
                    </label>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; display: block; margin-bottom: 8px; color: #27ae60;">📊 2. Data Warehouse (dwh_analitica_animales)</label>
                <div style="padding-left: 10px;">
                    <label style="display: block; margin: 5px 0; cursor: pointer;">
                        <input type="checkbox" class="chk-tabla" value="hechos_abandono_estatal"> Hechos de Abandono Estatal
                    </label>
                    <label style="display: block; margin: 5px 0; cursor: pointer;">
                        <input type="checkbox" class="chk-tabla" value="hechos_abandono_gatos"> Hechos Abandono Gatos
                    </label>
                    <label style="display: block; margin: 5px 0; cursor: pointer;">
                        <input type="checkbox" class="chk-tabla" value="hechos_abandono_perros"> Hechos Abandono Perros
                    </label>
                </div>
            </div>

            <button onclick="ejecutarPipelineETL()" style="width: 100%; background: #9b59b6; color:#fff; border:none; padding:12px; border-radius:5px; font-weight:bold; cursor:pointer; font-size:1em; transition: background 0.3s;">
                ⚙️ Iniciar Proceso ETL y Previsualizar
            </button>
        </div>

        <div class="card-etl" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between;">
            <h4 style="margin-top: 0; color: #2c3e50; border-bottom: 2px solid #f1f2f6; padding-bottom: 10px;">Pipeline de Datos Monitor</h4>
            
            <div class="etl-steps-box" style="padding: 10px 0;">
                <div id="step-e" class="etl-step" style="margin: 10px 0; padding: 10px; border-radius: 5px; background: #f8f9fa; border-left: 4px solid #ccc; color: #7f8c8d;">
                    <strong>Fase E: Extract (Extracción)</strong> <span class="status-txt" style="float: right;">Inactivo</span>
                </div>
                <div id="step-t" class="etl-step" style="margin: 10px 0; padding: 10px; border-radius: 5px; background: #f8f9fa; border-left: 4px solid #ccc; color: #7f8c8d;">
                    <strong>Fase T: Transform (Transformación)</strong> <span class="status-txt" style="float: right;">Inactivo</span>
                </div>
                <div id="step-l" class="etl-step" style="margin: 10px 0; padding: 10px; border-radius: 5px; background: #f8f9fa; border-left: 4px solid #ccc; color: #7f8c8d;">
                    <strong>Fase L: Load (Carga)</strong> <span class="status-txt" style="float: right;">Inactivo</span>
                </div>
            </div>

            <button id="btn-excel" onclick="exportarConsolidadoExcel()" disabled style="width: 100%; background: #27ae60; color:#fff; border:none; padding:12px; border-radius:5px; font-weight:bold; cursor:not-allowed; font-size:1em; opacity: 0.5;">
                📥 Descargar Reporte Excel Profesional 📊
            </button>
        </div>
    </div>

    <div style="background: #fff; border: 1px solid #ecf0f1; border-radius: 8px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f2f6; padding-bottom: 10px; margin-bottom: 15px;">
            <h4 style="margin: 0; color: #2c3e50;">Previsualizador de Datos Cargados</h4>
            <select id="select-pestaña-vista" onchange="cambiarTablaVista()" style="padding: 5px 10px; border-radius: 4px; display: none;"></select>
        </div>
        
        <div id="vacio-mensaje" style="text-align: center; color: #95a5a6; padding: 40px 20px;">
            <span style="font-size: 3em; display: block; margin-bottom: 10px;">📊</span>
            No se han cargado datos aún. Selecciona las tablas arriba e inicia el procesamiento ETL.
        </div>

        <div id="tabla-contenedor-scroll" style="width: 100%; overflow-x: auto; max-height: 400px; display: none;">
            <table id="tabla-etl-preview" style="width: 100%; border-collapse: collapse; font-size: 0.9em; min-width: 600px;">
                <thead>
                    <tr id="th-dinamico" style="background: #2c3e50; color: #fff; text-align: left;"></tr>
                </thead>
                <tbody id="tb-dinamico"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
let datosETLCargadosGlobal = null;

function ejecutarPipelineETL() {
    const checkboxes = document.querySelectorAll('.chk-tabla:checked');
    const tablas = Array.from(checkboxes).map(cb => cb.value);

    if (tablas.length === 0) {
        alert("Por favor selecciona al menos una tabla para iniciar el proceso de extracción.");
        return;
    }

    // Resetear monitor e iniciar simulación fluida visual de estados ETL
    resetearMonitorETL();
    actualizarPasoETL('step-e', '#e67e22', 'Extrayendo de origen MySQL...');

    fetch('ETL/procesar_etl.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ tablas: tablas })
    })
    .then(response => response.json())
    .then(res => {
        if (res.error) {
            alert(res.error);
            resetearMonitorETL();
            return;
        }

        // Simulación controlada y estética del pipeline en milisegundos
        setTimeout(() => {
            actualizarPasoETL('step-e', '#27ae60', '✔ Completado');
            actualizarPasoETL('step-t', '#e67e22', 'Llimpiando nulos y cruzando tablas...');
            
            setTimeout(() => {
                actualizarPasoETL('step-t', '#27ae60', '✔ Estandarizado Exitoso');
                actualizarPasoETL('step-l', '#e67e22', 'Escribiendo en memoria intermedia...');
                
                setTimeout(() => {
                    actualizarPasoETL('step-l', '#27ae60', '✔ Listo para Exportar');
                    
                    // Almacenar respuesta de las DBs y pintar visor
                    datosETLCargadosGlobal = res.data;
                    renderizarPrevisualizador();
                    
                    // Desbloquear botón de descarga de Excel profesional
                    const btnExcel = document.getElementById('btn-excel');
                    btnExcel.disabled = false;
                    btnExcel.style.cursor = 'pointer';
                    btnExcel.style.opacity = '1';
                }, 600);
            }, 700);
        }, 600);
    })
    .catch(err => {
        console.error("Error ETL:", err);
        alert("Hubo un percance en la conexión interna del proceso ETL.");
        resetearMonitorETL();
    });
}

function actualizarPasoETL(idElemento, color, texto) {
    const contenedor = document.getElementById(idElemento);
    contenedor.style.borderLeftColor = color;
    contenedor.style.color = '#2c3e50';
    contenedor.style.background = '#f1f2f6';
    contenedor.querySelector('.status-txt').innerText = texto;
    contenedor.querySelector('.status-txt').style.color = color;
}

function resetearMonitorETL() {
    const pasos = ['step-e', 'step-t', 'step-l'];
    pasos.forEach(id => {
        const div = document.getElementById(id);
        div.style.borderLeftColor = '#ccc';
        div.style.color = '#7f8c8d';
        div.style.background = '#f8f9fa';
        div.querySelector('.status-txt').innerText = 'Inactivo';
        div.querySelector('.status-txt').style.color = '#7f8c8d';
    });
    
    // Bloquear descarga
    const btnExcel = document.getElementById('btn-excel');
    btnExcel.disabled = true;
    btnExcel.style.cursor = 'not-allowed';
    btnExcel.style.opacity = '0.5';
}

function renderizarPrevisualizador() {
    document.getElementById('vacio-mensaje').style.display = 'none';
    const selectorPestaña = document.getElementById('select-pestaña-vista');
    selectorPestaña.innerHTML = '';
    selectorPestaña.style.display = 'inline-block';
    
    // Llenar selector de pestañas basado en los datos devueltos
    Object.keys(datosETLCargadosGlobal).forEach(nombreTabla => {
        let opt = document.createElement('option');
        opt.value = nombreTabla;
        opt.innerText = nombreTabla;
        selectorPestaña.appendChild(opt);
    });

    cambiarTablaVista();
}

function cambiarTablaVista() {
    const tablaSeleccionada = document.getElementById('select-pestaña-vista').value;
    const filasDatos = datosETLCargadosGlobal[tablaSeleccionada];
    
    const thDinamico = document.getElementById('th-dinamico');
    const tbDinamico = document.getElementById('tb-dinamico');
    
    thDinamico.innerHTML = '';
    tbDinamico.innerHTML = '';
    
    if(!filasDatos || filasDatos.length === 0) {
        thDinamico.innerHTML = "<th style='padding:12px;'>Sin datos transformados</th>";
        return;
    }
    
    // Renderizar cabeceras dinámicamente según las claves de las columnas SQL procesadas
    const columnas = Object.keys(filasDatos[0]);
    columnas.forEach(col => {
        let th = document.createElement('th');
        th.style.padding = '12px';
        th.style.borderBottom = '2px solid #ddd';
        th.innerText = col;
        thDinamico.appendChild(th);
    });
    
    // Renderizar los registros reales obtenidos
    filasDatos.forEach((fila, index) => {
        let tr = document.createElement('tr');
        tr.style.background = (index % 2 === 0) ? '#ffffff' : '#f9f9f9';
        tr.style.borderBottom = '1px solid #eee';
        
        columnas.forEach(col => {
            let td = document.createElement('td');
            td.style.padding = '10px 12px';
            td.innerText = (fila[col] !== null) ? fila[col] : 'N/A';
            tr.appendChild(td);
        });
        tbDinamico.appendChild(tr);
    });
    
    document.getElementById('tabla-contenedor-scroll').style.display = 'block';
}

function exportarConsolidadoExcel() {
    if(!datosETLCargadosGlobal) return;
    
    // Creamos el libro de trabajo virtual (Workbook)
    const wb = XLSX.utils.book_new();
    
    // Generar una pestaña (Sheet) por cada conjunto de datos procesado de forma dinámica
    Object.keys(datosETLCargadosGlobal).forEach(nombrePestaña => {
        const datosTabla = datosETLCargadosGlobal[nombrePestaña];
        
        if(datosTabla && datosTabla.length > 0) {
            // Convierte el JSON limpio de PHP directamente a una matriz nativa compatible con Excel
            const ws = XLSX.utils.json_to_sheet(datosTabla);
            
            // Adjuntar la pestaña al libro con su respectivo nombre
            XLSX.utils.book_append_sheet(wb, ws, nombrePestaña);
        }
    });
    
    // Disparar descarga en formato .xlsx ultra-veloz del lado del cliente
    XLSX.writeFile(wb, "Reporte_Inteligencia_Animal_Consolidado.xlsx");
}
</script>

<style>
.card-etl {
    box-sizing: border-box;
}
.chk-tabla {
    transform: scale(1.1);
    margin-right: 8px;
    vertical-align: middle;
}
#tabla-etl-preview th {
    font-weight: 600;
}
</style>