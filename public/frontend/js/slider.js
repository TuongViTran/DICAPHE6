document.addEventListener("DOMContentLoaded", function () {
    const autoSlider = document.getElementById("auto-slider");
    const autoSlides = autoSlider.querySelectorAll(".slide");

    const contentSlider = document.getElementById("content-slider");
    const contentSlides = contentSlider.querySelectorAll(".slide");

    const dots = document.querySelectorAll(".dot");
    const dotsContent = document.querySelectorAll(".dot-content");

    let currentSlide = 0;
    const totalSlides = autoSlides.length;
    const slideIntervalTime = 4000;

    function showSlide(index) {
        // Di chuyển cả hai slider cùng lúc
        autoSlider.style.transform = `translateX(-${index * 100}%)`;
        contentSlider.style.transform = `translateX(-${index * 100}%)`;

        // Cập nhật dot của autoSlider
        dots.forEach((dot) => dot.classList.remove("active"));
        if (dots[index]) dots[index].classList.add("active");

        // Cập nhật dot của contentSlider
        dotsContent.forEach((dot) => dot.classList.remove("active"));
        if (dotsContent[index]) dotsContent[index].classList.add("active");
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    let autoSlide = setInterval(nextSlide, slideIntervalTime);

    // Dots bên phải (auto-slider)
    dots.forEach((dot) => {
        dot.addEventListener("click", function () {
            clearInterval(autoSlide);
            currentSlide = parseInt(this.getAttribute("data-slide"));
            showSlide(currentSlide);
            autoSlide = setInterval(nextSlide, slideIntervalTime);
        });
    });

    // Dots bên trái (content-slider)
    dotsContent.forEach((dot) => {
        dot.addEventListener("click", function () {
            clearInterval(autoSlide);
            currentSlide = parseInt(this.getAttribute("data-slide"));
            showSlide(currentSlide);
            autoSlide = setInterval(nextSlide, slideIntervalTime);
        });
    });

    showSlide(currentSlide);
});
