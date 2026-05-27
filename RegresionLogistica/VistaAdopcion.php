<div class="section-header" style="margin-bottom: 25px;">
    <h2>Modelo Predictivo: Probabilidad de Adopción</h2>
    <p>Evalúa las posibilidades reales de que un animal encuentre hogar utilizando un modelo matemático de Regresión Logística.</p>
</div>

<div class="card" style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); box-sizing: border-box;">
    
    <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-bottom: 25px; align-items: stretch;">
        
        <div style="flex: 1; min-width: 300px; background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #2980b9;">
            <h4 style="margin-top: 0; color: #2c3e50;">Configuración del Modelo</h4>
            <label style="font-weight: bold; display: block; margin-bottom: 10px; color: #333;">Tamaño del Animal:</label>
            <select id="filtro-tamano" onchange="cargarModeloLogistico()" style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc; font-size: 1em;">
                <option value="todos">Cualquier tamaño</option>
                <option value="Pequeño">Pequeño</option>
                <option value="Mediano">Mediano</option>
                <option value="Grande">Grande</option>
            </select>
            
            <div id="cargando-logistico" style="display: none; margin-top: 15px; color: #e67e22; font-weight: bold;">
                <span style="display: inline-block; animation: spin 1s linear infinite;">⚙️</span> Entrenando algoritmo...
            </div>
        </div>

        <div style="flex: 2; min-width: 400px; background: #fcfcfc; padding: 20px; border-radius: 8px; border: 1px solid #eee;">
            <h4 style="margin-top: 0; color: #2c3e50;">¿Cómo interpretar este gráfico?</h4>
            <p style="font-size: 0.9em; line-height: 1.5; color: #555;">
                A diferencia de la regresión lineal que traza una línea recta infinita, la <strong>Regresión Logística</strong> dibuja una <em>Curva Sigmoidea (forma de "S")</em>. Esto es porque evalúa eventos binarios (0 = Sigue en refugio, 1 = Adoptado) y los traduce en una probabilidad del 0% al 100%.<br><br>
                Los puntos azules muestran tus registros reales extraídos de la tabla <code>perfil_animal</code>. La línea verde muestra el cálculo predictivo del algoritmo.
            </p>
        </div>
    </div>

    <div style="width: 100%; border: 1px solid #ecf0f1; padding: 15px; border-radius: 8px; box-sizing: border-box; background: #fafafa;">
        <div style="height: 280px; max-height: 280px; width: 100%; max-width: 800px; margin: 0 auto; position: relative; overflow: hidden;">
            <canvas id="canvasLogistico"></canvas>
        </div>
    </div>
</div>

<style>
@keyframes spin { 100% { transform: rotate(360deg); } }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="RegresionLogistica/grafico_logistico.js"></script>