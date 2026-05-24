<link rel="stylesheet" href="Estructura/Data1/css/Data1.css">
<link rel="stylesheet" href="Estructura/Data1/fuentes/css/fuentes.css">

<style>
    /* Forzamos a que el contenido de Data1 no se centre */
    #vulnerabilidad-animal {
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100% !important;
    }
    
    .data-content {
        margin: 0 !important;
        max-width: 100% !important;
    }

    .swal2-icon.swal2-info {
        border-color: #01833d !important;
        color: #01833d !important;
        transition: all 1.5s ease !important;
    }
</style>

<section class="data-section" id="vulnerabilidad-animal">
    <div class="data-content" style="position: relative; z-index: 2; padding: 20px;">
        
        <header class="section-header" style="background: #f4f4f4; border: 2px solid #01833d; padding: 25px; border-radius: 15px; margin-bottom: 30px;">
            <h2 style="color: #000; font-weight: 800; margin: 0; font-size: 1.6rem;">
                Componente 1: Índice de Vulnerabilidad Animal en México
            </h2>
            <p class="data-description" style="color: #555; margin-top: 10px; font-size: 1rem;">
                Análisis de la población estimada de perros y gatos en situación de calle.
            </p>
        </header>

        <?php include 'fuentes/fuentes.php'; ?>

        <div class="stats-grid">
            <div class="chart-container" style="height:350px;">
                <canvas id="chartPoblacion"></canvas>
            </div>

            <div class="info-cards">
                <div class="card" style="border-left: 8px solid #01833d;">
                    <div class="card-body">
                        <h3>70%</h3>
                        <p>Animales en situación de calle.</p>
                    </div>
                </div>
                <div class="card" style="border-left: 8px solid #ffd600;">
                    <div class="card-body">
                        <h3>27 Millones</h3>
                        <p>Estimado sin hogar fijo.</p>
                    </div>
                </div>
                <div class="card card-dark">
                    <div class="card-body">
                        <h3>80 Millones</h3>
                        <p>Mascotas totales registradas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="Estructura/Data1/js/Data1.js"></script>