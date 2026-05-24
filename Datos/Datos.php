<?php include '../Estructura/php/head.php'; ?>
<link rel="stylesheet" href="css/datos.css">

<body>
    <?php include '../Estructura/php/header.php'; ?>

    <main class="container-datos">
        <header class="datos-header">
            <h1>Panel de Análisis de Datos</h1>
            <p>Monitoreo estadístico de poblaciones animales y centros de apoyo en México.</p>
        </header>

        <section class="data-wrapper">
            
            <div class="componente-pro-wrapper">
                <div class="columna-izquierda">
                    <?php include 'Estructura/Data1/Data1.php'; ?>
                </div>
                
                <div class="columna-derecha">
                    <?php include 'carrusel/carrusel.php'; ?>
                </div>
            </div>

            <div class="divisor-pro-full"></div>

            <div class="componente-centered-wrapper">
                <?php include 'Estructura/Data2/Data2.php'; ?>
            </div>

            <div class="divisor-pro-full"></div>

            <div class="componente-pro-wrapper" style="flex-direction: row-reverse;">
                <div class="columna-izquierda">
                    <?php include 'Estructura/Data3/Data3.php'; ?>
                </div>
                
                <div class="columna-derecha">
                    <?php include 'carrusel2/carrusel2.php'; ?>
                </div>
            </div>

        </section>
    </main>

    <?php include '../Estructura/php/footer.php'; ?>

    </body>
</html>