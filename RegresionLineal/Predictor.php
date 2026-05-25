<div class="section-header">
    <h2>Proyección Predictiva Avanzada</h2>
    <p>Analiza el histórico mensual y proyecta escenarios futuros de abandono.</p>
</div>

<div style="display: flex; gap: 20px; flex-wrap: wrap;">
    
    <div style="flex: 3; min-width: 0; width: 100%; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); overflow: hidden;">
        
        <p style="font-size: 0.9em; color: #555; font-style: italic; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
            * Nuestro modelo de proyección predictiva se basa en esta información recopilada de los últimos 5 años.
        </p>

        <div id="controles-historico" style="display: flex; gap: 15px; margin-bottom: 20px; background: #f4f6f8; padding: 12px; border-radius: 6px; align-items: flex-end; flex-wrap: wrap;">
            <div>
                <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #333;">Fuente de Datos:</label>
                <select id="hist-fuente" onchange="toggleEstado(); cargarHistorico();" style="padding: 6px; border-radius: 4px; border: 1px solid #ccc; width: 200px;">
                    <option value="Estatal">Por Estado (Ambos)</option>
                    <option value="Perros">Total Nacional (Solo Perros)</option>
                    <option value="Gatos">Total Nacional (Solo Gatos)</option>
                </select>
            </div>
            
            <div id="contenedor-estado">
                <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #333;">Estado:</label>
                <select id="hist-estado" onchange="cargarHistorico()" style="padding: 6px; border-radius: 4px; border: 1px solid #ccc; width: 180px;">
                    <option value="1">Aguascalientes</option><option value="2">Baja California</option>
                    <option value="3">Baja California Sur</option><option value="4">Campeche</option>
                    <option value="5">Coahuila</option><option value="6">Colima</option>
                    <option value="7">Chiapas</option><option value="8">Chihuahua</option>
                    <option value="9" selected>CDMX</option><option value="10">Durango</option>
                    <option value="11">Guanajuato</option><option value="12">Guerrero</option>
                    <option value="13">Hidalgo</option><option value="14">Jalisco</option>
                    <option value="15">Estado de México</option><option value="16">Michoacán</option>
                    <option value="17">Morelos</option><option value="18">Nayarit</option>
                    <option value="19">Nuevo León</option><option value="20">Oaxaca</option>
                    <option value="21">Puebla</option><option value="22">Querétaro</option>
                    <option value="23">Quintana Roo</option><option value="24">San Luis Potosí</option>
                    <option value="25">Sinaloa</option><option value="26">Sonora</option>
                    <option value="27">Tabasco</option><option value="28">Tamaulipas</option>
                    <option value="29">Tlaxcala</option><option value="30">Veracruz</option>
                    <option value="31">Yucatán</option><option value="32">Zacatecas</option>
                </select>
            </div>

            <div>
                <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #333;">Año a visualizar:</label>
                <select id="hist-anio" onchange="cargarHistorico()" style="padding: 6px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="2020">2020</option><option value="2021" selected>2021</option>
                    <option value="2022">2022</option><option value="2023">2023</option>
                    <option value="2024">2024</option><option value="2025">2025</option>
                </select>
            </div>
        </div>

        <div id="controles-prediccion" style="display: none; justify-content: space-between; align-items: center; margin-bottom: 20px; background: #e8f4f8; padding: 12px; border-radius: 6px; flex-wrap: wrap; border: 1px solid #bce8f1;">
            <div>
                <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #01833d;">Vista de Resultados:</label>
                <select id="tipo-vista-pred" onchange="cambiarVistaPrediccion()" style="padding: 6px; border-radius: 4px; border: 1px solid #ccc; width: 220px;">
                    <option value="bar">Gráfico de Barras</option>
                    <option value="scatter">Gráfico de Dispersión</option>
                    <option value="explicacion">Explicación Matemática</option>
                </select>
            </div>
            <div>
                <button onclick="volverAlHistorico()" style="padding: 7px 15px; background: #7f8c8d; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; margin-top: 15px;">← Volver al Histórico</button>
            </div>
        </div>

        <div id="contenedor-scroll" style="width: 100%; overflow-x: auto; overflow-y: hidden; padding-bottom: 10px; position: relative;">
            <div id="contenedor-canvas" style="height: 400px; width: 100%; position: relative;">
                <canvas id="chartPredictivo"></canvas>
            </div>
        </div>
        
        <div id="contenedor-explicacion" style="display: none; height: 400px; width: 100%; overflow-y: auto; padding: 20px; background: #fafafa; border: 1px solid #ddd; border-radius: 8px; color: #333;">
            </div>
        
    </div>

    <div style="flex: 1; min-width: 300px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); height: fit-content;">
        <h4 style="color: #01833d; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-top: 0;">Proyección Predictiva</h4>
        
        <div style="margin-top: 15px;">
            <label style="display:block; margin-bottom:8px; font-weight:bold;">Especie a predecir:</label>
            <div style="margin-bottom:15px; background: #f9f9f9; padding: 10px; border-radius: 6px;">
                <label style="display: block; margin-bottom: 5px;"><input type="radio" name="pred-especie" value="ambos" checked> Ambos</label>
                <label style="display: block; margin-bottom: 5px;"><input type="radio" name="pred-especie" value="perros"> Perros</label>
                <label style="display: block;"><input type="radio" name="pred-especie" value="gatos"> Gatos</label>
            </div>

            <label style="display:block; margin-bottom:8px; font-weight:bold;">Resolución:</label>
            <div style="margin-bottom:15px; background: #f9f9f9; padding: 10px; border-radius: 6px; display: flex; gap: 15px;">
                <label><input type="radio" name="pred-resolucion" value="mensual" checked> Mensual (Mes a mes)</label>
                <label><input type="radio" name="pred-resolucion" value="anual"> Anual (Total)</label>
            </div>

            <label style="display:block; margin-bottom:8px; font-weight:bold;">Años a proyectar:</label>
            <div style="margin-bottom:25px; display:grid; grid-template-columns: 1fr 1fr; gap: 8px; background: #f9f9f9; padding: 10px; border-radius: 6px;">
                <label><input type="checkbox" class="pred-anio" value="2026"> 2026</label>
                <label><input type="checkbox" class="pred-anio" value="2027"> 2027</label>
                <label><input type="checkbox" class="pred-anio" value="2028"> 2028</label>
                <label><input type="checkbox" class="pred-anio" value="2029"> 2029</label>
                <label><input type="checkbox" class="pred-anio" value="2030"> 2030</label>
            </div>
            
            <button id="btn-predecir" onclick="iniciarPrediccion()" style="width:100%; padding:12px; background:#01833d; color:#fff; border:none; border-radius:4px; font-weight:bold; cursor:pointer; transition: background 0.3s;">Generar Predicción</button>
            
            <div id="progreso-container" style="display: none; margin-top: 20px;">
                <div style="display: flex; justify-content: space-between; font-size: 0.85em; color: #555; margin-bottom: 5px;">
                    <span id="progreso-texto">Calculando...</span>
                    <span id="progreso-porcentaje">0%</span>
                </div>
                <div style="width: 100%; background: #e0e0e0; border-radius: 10px; overflow: hidden; height: 12px;">
                    <div id="progreso-barra" style="width: 0%; height: 100%; background: #01833d; transition: width 0.2s;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'Grafico/render_grafico.php'; ?>