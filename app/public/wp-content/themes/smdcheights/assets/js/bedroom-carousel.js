document.addEventListener("DOMContentLoaded", function () {
    const carousels = document.querySelectorAll(".bedroom-carousel-container");

    carousels.forEach((carousel) => {
        const track = carousel.querySelector(".bedroom-carousel-track");
        const items = carousel.querySelectorAll(".bedroom-gallery-item");
        const prevBtn = carousel.querySelector(".bedroom-prev-btn");
        const nextBtn = carousel.querySelector(".bedroom-next-btn");

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

        // let autoplayInterval = setInterval(goToNextSlide, 5000);

        // track.addEventListener('mouseenter', () => clearInterval(autoplayInterval));
        // track.addEventListener('mouseleave', () => {
        //     autoplayInterval = setInterval(goToNextSlide, 5000);
        // });

        window.addEventListener("resize", updateCarousel);
        updateCarousel();
    });
});