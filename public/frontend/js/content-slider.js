document.addEventListener("DOMContentLoaded", function() {
    const slider = document.getElementById("content-slider");
    const slides = slider.querySelectorAll(".slide");
    let currentSlide = 0;
    const totalSlides = slides.length;
    const slideIntervalTime = 4000; // 4 giây

    function showSlide(index) {
        slider.style.transform = `translateX(-${index * 100}%)`;
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    // Tự động chạy
    let autoSlide = setInterval(nextSlide, slideIntervalTime);

    // Optional: dừng khi hover (nếu muốn)
    slider.addEventListener("mouseenter", () => clearInterval(autoSlide));
    slider.addEventListener("mouseleave", () => {
        autoSlide = setInterval(nextSlide, slideIntervalTime);
    });

    // Khởi động slide đầu tiên
    showSlide(currentSlide);
});