/* carrusel2.js - Lógica de transición automática y manual */

document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.carrusel2-slide img');
    const dots = document.querySelectorAll('.carrusel2-dots .dot');
    let currentSlide = 0;
    const slideInterval = 3500; // Cambio cada 3.5 segundos

    // Función para cambiar de imagen
    function showSlide(index) {
        // Quitamos la clase active de todas las imágenes y puntos
        slides.forEach(img => img.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        // Añadimos active al elemento correspondiente
        slides[index].classList.add('active');
        dots[index].classList.add('active');
        
        currentSlide = index;
    }

    // Función para pasar a la siguiente imagen automáticamente
    function nextSlide() {
        let next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }

    // Iniciar el temporizador
    let timer = setInterval(nextSlide, slideInterval);

    // Permitir cambio manual al hacer clic en los puntos (dots)
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            // Detenemos el temporizador para que no cambie justo después del clic
            clearInterval(timer);
            showSlide(index);
            // Reiniciamos el temporizador
            timer = setInterval(nextSlide, slideInterval);
        });
    });
});