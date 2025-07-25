<?php

function enqueue_swiper_assets() {
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), null, true);

    wp_add_inline_script('swiper-js', '
        document.addEventListener("DOMContentLoaded", function () {
            new Swiper(".location-swiper", {
                slidesPerView: 1,
                spaceBetween: 24,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev"
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 24,
                    }
                }
            });
        });
    ');
}
add_action('wp_enqueue_scripts', 'enqueue_swiper_assets');