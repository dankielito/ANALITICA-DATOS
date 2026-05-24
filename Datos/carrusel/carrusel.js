/* carrusel.js */
let slideIndex = 0;
const slides = document.getElementsByClassName("img-carrusel");
const dots = document.getElementsByClassName("dot");
let timer;

function showSlides() {
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
        dots[i].classList.remove("active");
    }
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1; }
    
    if (slides[slideIndex - 1]) {
        slides[slideIndex - 1].classList.add("active");
        dots[slideIndex - 1].classList.add("active");
    }
    
    timer = setTimeout(showSlides, 4000);
}

function currentSlide(n) {
    clearTimeout(timer);
    slideIndex = n;
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
        dots[i].classList.remove("active");
    }
    slides[slideIndex].classList.add("active");
    dots[slideIndex].classList.add("active");
    slideIndex++;
    timer = setTimeout(showSlides, 4000);
}

// Iniciar carrusel al cargar
document.addEventListener("DOMContentLoaded", showSlides);