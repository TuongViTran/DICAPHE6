document.addEventListener("DOMContentLoaded", function() {
    const slider = document.getElementById("auto-slider");
    const slides = slider.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".dot");

    let currentSlide = 0;
    const totalSlides = slides.length;
    const slideIntervalTime = 4000;

    function showSlide(index) {
        slider.style.transform = `translateX(-${index * 100}%)`;

        dots.forEach(dot => dot.classList.remove("active"));
        dots[index].classList.add("active");
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    let autoSlide = setInterval(nextSlide, slideIntervalTime);

    dots.forEach(dot => {
        dot.addEventListener("click", function() {
            clearInterval(autoSlide);
            currentSlide = parseInt(this.getAttribute("data-slide"));
            showSlide(currentSlide);
            autoSlide = setInterval(nextSlide, slideIntervalTime);
        });
    });

    showSlide(currentSlide);
});