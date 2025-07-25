document.addEventListener("DOMContentLoaded", function () {
    const track = document.querySelector(".carousel-track");
    const items = document.querySelectorAll(".gallery-item");
    const prevBtn = document.querySelector(".frontage-previous-btn");
    const nextBtn = document.querySelector(".frontage-next-btn");

    let currentIndex = 0;
    let totalItems = items.length;

    function updateCarousel() {
        const offset = -currentIndex * items[0].offsetWidth;
        track.style.transform = `translateX(${offset}px)`;
    }

    function goToNextSlide() {
        currentIndex = (currentIndex + 1) % totalItems;
        updateCarousel();
    }

    function goToPrevSlide() {
        currentIndex = (currentIndex - 1 + totalItems) % totalItems;
        updateCarousel();
    }

    nextBtn.addEventListener("click", goToNextSlide);
    prevBtn.addEventListener("click", goToPrevSlide);

    // Autoplay every 5 seconds
    let autoplayInterval = setInterval(goToNextSlide, 5000);

    // Optional: Pause on hover
    track.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
    track.addEventListener('mouseleave', () => {
        autoplayInterval = setInterval(goToNextSlide, 5000);
    });

    // Recalculate on resize to ensure correct width
    window.addEventListener("resize", updateCarousel);
});