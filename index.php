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
            <section id="mapa-interactivo" class="dashboard-section"><?php include 'Mapa/Mapa.php'; ?></section>
            <section id="modulo-prediccion" class="dashboard-section"><?php include 'RegresionLineal/Predictor.php'; ?></section>
            <section id="modulo-adopcion" class="dashboard-section"><?php include 'RegresionLogistica/VistaAdopcion.php'; ?></section>
            <section id="modulo-reportes" class="dashboard-section"><?php include 'ETL/Reportes.php'; ?></section>
        </main>
    </div>

    <?php include 'Estructura/php/footer.php'; ?>
</body>
</html>