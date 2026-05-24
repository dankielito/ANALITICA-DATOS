<link rel="stylesheet" href="Mapa/css/Mapa.css">

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/mx/mx-all.js"></script>

<section class="map-section">
    <div class="map-container">
        <header class="map-header-pro">
            <h3>Distribución Geográfica por Entidad</h3>
            <p>Pasa el cursor sobre un estado para ver las estadísticas de situación de calle.</p>
        </header>

        <div class="map-layout-pro">
            <div id="container-mapa-mx"></div>

            <div id="state-info" class="state-info-panel-pro">
                <h4 id="state-name">México</h4>
                <div class="divisor-sutil"></div>
                <div class="info-data-pro">
                    <div class="data-item">
                        <span class="label">Perros y Gatos:</span>
                        <span id="pob-cantidad" class="value">Selecciona un estado</span>
                    </div>
                    <div class="data-item">
                        <span class="label">Abandono:</span>
                        <span id="pob-porcentaje" class="value">-</span>
                    </div>
                </div>
                <div class="percentage-bar">
                    <div id="bar-fill" class="bar-fill-pro"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="Mapa/js/Mapa.js"></script>