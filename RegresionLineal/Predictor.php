<div class="section-header">
    <h2>Proyección Predictiva Avanzada</h2>
    <p>Analiza el histórico mensual y proyecta escenarios futuros de abandono.</p>
</div>

<div style="display: flex; gap: 20px; flex-wrap: wrap;">
    <div style="flex: 3; min-width: 60%; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <p style="font-size: 0.9em; color: #555; font-style: italic; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
            * Nuestro modelo de proyección predictiva se basa en esta información recopilada de los últimos 5 años.
        </p>

        <div style="display: flex; gap: 15px; margin-bottom: 20px; background: #f4f6f8; padding: 12px; border-radius: 6px; align-items: flex-end; flex-wrap: wrap;">
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
                    <?php 
                    $estados = ["Aguascalientes", "Baja California", "Baja California Sur", "Campeche", "Coahuila", "Colima", "Chiapas", "Chihuahua", "CDMX", "Durango", "Guanajuato", "Guerrero", "Hidalgo", "Jalisco", "Estado de México", "Michoacán", "Morelos", "Nayarit", "Nuevo León", "Oaxaca", "Puebla", "Querétaro", "Quintana Roo", "San Luis Potosí", "Sinaloa", "Sonora", "Tabasco", "Tamaulipas", "Tlaxcala", "Veracruz", "Yucatán", "Zacatecas"];
                    foreach($estados as $index => $nombre): 
                        $val = $index + 1;
                        echo "<option value='$val' ".($val == 9 ? 'selected' : '').">$nombre</option>";
                    endforeach; 
                    ?>
                </select>
            </div>

            <div>
                <label style="font-weight: bold; display: block; margin-bottom: 5px; color: #333;">Año a visualizar:</label>
                <select id="hist-anio" onchange="cargarHistorico()" style="padding: 6px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="2020">2020</option>
                    <option value="2021" selected>2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </div>
        </div>

        <div style="height: 400px; width: 100%;">
            <canvas id="chartPredictivo"></canvas>
        </div>
        
        <div id="resultado-descripcion" style="margin-top: 20px; padding: 15px; background: #e9f7ef; border-left: 4px solid #01833d; border-radius: 4px; display: none;"></div>
    </div>

    <div style="flex: 1; min-width: 300px; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); height: fit-content;">
        <h4 style="color: #01833d; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-top: 0;">Proyección Predictiva</h4>
        <div style="margin-top: 15px;">
            <label style="display:block; margin-bottom:8px; font-weight:bold;">Especie a predecir:</label>
            <div style="margin-bottom:20px; background: #f9f9f9; padding: 10px; border-radius: 6px;">
                <label style="display: block; margin-bottom: 5px;"><input type="radio" name="pred-especie" value="ambos" checked> Ambos</label>
                <label style="display: block; margin-bottom: 5px;"><input type="radio" name="pred-especie" value="perros"> Perros</label>
                <label style="display: block;"><input type="radio" name="pred-especie" value="gatos"> Gatos</label>
            </div>
            <label style="display:block; margin-bottom:8px; font-weight:bold;">Años a proyectar:</label>
            <div style="margin-bottom:25px; display:grid; grid-template-columns: 1fr 1fr; gap: 8px; background: #f9f9f9; padding: 10px; border-radius: 6px;">
                <label><input type="checkbox" class="pred-anio" value="2026"> 2026</label><label><input type="checkbox" class="pred-anio" value="2027"> 2027</label>
                <label><input type="checkbox" class="pred-anio" value="2028"> 2028</label><label><input type="checkbox" class="pred-anio" value="2029"> 2029</label>
                <label><input type="checkbox" class="pred-anio" value="2030"> 2030</label>
            </div>
            <button id="btn-predecir" onclick="iniciarPrediccion()" style="width:100%; padding:12px; background:#01833d; color:#fff; border:none; border-radius:4px; font-weight:bold; cursor:pointer;">Generar Predicción</button>
            <div id="progreso-container" style="display: none; margin-top: 20px;">
                <div style="width: 100%; background: #e0e0e0; border-radius: 10px; overflow: hidden; height: 12px;">
                    <div id="progreso-barra" style="width: 0%; height: 100%; background: #01833d; transition: width 0.2s;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'Grafico/render_grafico.php'; ?>