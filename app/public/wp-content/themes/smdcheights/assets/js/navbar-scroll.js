document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('navbar');

    if (navbar && navbar.classList.contains('homepage-navbar')) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 10) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const animatedItems = document.querySelectorAll('.animate-on-scroll');
    const animatedItemsBtn = document.querySelectorAll('.animate-on-scroll-btn');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target); // Run once
            }
        });
    }, {
        threshold: 0.5
    });

    const observerBtn = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observerBtn.unobserve(entry.target); // Run once
            }
        });
    }, {
        threshold: 0.5
    });

    animatedItems.forEach(item => observer.observe(item));
    animatedItemsBtn.forEach(itemBtn => observerBtn.observe(itemBtn));
});