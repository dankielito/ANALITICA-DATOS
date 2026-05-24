<?php include 'Estructura/php/head.php'; ?>

<body>

    <?php include 'Estructura/php/header.php'; ?>

    <div class="dashboard-layout">
        
        <aside class="sidebar-nav">
            <div class="sidebar-sticky">
                <h3>Módulos de Análisis</h3>
                <ul>
                    <li><a href="#mapa-interactivo">🗺️ Mapa Interactivo</a></li>
                    <li><a href="#modulo-prediccion">📈 Proyección Predictiva</a></li>
                    <li><a href="#modulo-adopcion">🐕 Probabilidad de Adopción</a></li>
                    <li><a href="#modulo-reportes">📊 Exportar Reportes (ETL)</a></li>
                </ul>
            </div>
        </aside>

        <main class="main-content">
            
            <section id="mapa-interactivo" class="dashboard-section">
                <div class="section-header">
                    <h2>Análisis Geográfico y Descriptivo</h2>
                    <p>Visualización de población en situación de calle mediante Data Marts geográficos.</p>
                </div>
                <div class="map-index-wrapper">
                    <?php include 'Mapa/Mapa.php'; ?>
                </div>
            </section>

            <section id="modulo-prediccion" class="dashboard-section">
                <div class="section-header">
                    <h2>Proyección Predictiva (Regresión Lineal)</h2>
                    <p>Simula el crecimiento poblacional a 5 años basado en tendencias históricas del Data Warehouse.</p>
                </div>
                <div class="card-analitica">
                    <div class="card-icon">📈</div>
                    <div class="card-info">
                        <h4>Modelo Predictivo Poblacional</h4>
                        <p>Calcula la tendencia matemática de abandono si no se aplican campañas de esterilización.</p>
                    </div>
                    <button class="btn-analitica">Ejecutar Simulación</button>
                </div>
            </section>

            <section id="modulo-adopcion" class="dashboard-section">
                <div class="section-header">
                    <h2>Probabilidad de Adopción (Regresión Logística)</h2>
                    <p>Evalúa las posibilidades de que un animal encuentre hogar según sus características.</p>
                </div>
                <div class="card-analitica">
                    <div class="card-icon">🐕</div>
                    <div class="card-info">
                        <h4>Evaluador de Casos</h4>
                        <p>Introduce variables (edad, tamaño, estado) para calcular el porcentaje de éxito (0-100%).</p>
                    </div>
                    <button class="btn-analitica">Abrir Evaluador</button>
                </div>
            </section>

            <section id="modulo-reportes" class="dashboard-section">
                <div class="section-header">
                    <h2>Exportación de Inteligencia (Carga ETL)</h2>
                    <p>Descarga los indicadores clave (KPIs) procesados y limpios para su uso externo.</p>
                </div>
                <div class="card-analitica">
                    <div class="card-icon">📊</div>
                    <div class="card-info">
                        <h4>Generador de Reportes</h4>
                        <p>Extrae la información del modelo transaccional en formato CSV o Excel.</p>
                    </div>
                    <button class="btn-analitica">Generar Reporte Excel</button>
                </div>
            </section>

        </main>
    </div>

    <?php include 'Estructura/php/footer.php'; ?>

</body>
</html>