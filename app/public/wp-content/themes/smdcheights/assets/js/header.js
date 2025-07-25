jQuery(document).ready(function ($) {
    // Create overlay element
    if (!$('.sidebar-overlay').length) {
        $('body').append('<div class="sidebar-overlay" id="sidebarOverlay"></div>');
    }

    const $sidebar = $('#sidebar');
    const $burger = $('#burger');
    const $closeBtn = $('#closeBtn');
    const $overlay = $('#sidebarOverlay');
    const $body = $('body');

    // Open sidebar
    function openSidebar() {
        $sidebar.addClass('open');
        $overlay.addClass('active');
        $body.addClass('sidebar-open');
        // Prevent body scroll when sidebar is open
        $body.css('overflow', 'hidden');

        // Focus management for accessibility
        $closeBtn.focus();
    }

    // Close sidebar
    function closeSidebar() {
        $sidebar.removeClass('open');
        $overlay.removeClass('active');
        $body.removeClass('sidebar-open');
        // Restore body scroll
        $body.css('overflow', '');

        // Return focus to burger button
        $burger.focus();
    }

    // Event listeners
    $burger.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        openSidebar();
    });

    $closeBtn.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        closeSidebar();
    });

    // Close sidebar when clicking overlay
    $overlay.on('click', function (e) {
        e.preventDefault();
        closeSidebar();
    });

    // Close sidebar when clicking outside
    $(document).on('click', function (e) {
        if ($sidebar.hasClass('open') &&
            !$sidebar.is(e.target) &&
            $sidebar.has(e.target).length === 0 &&
            !$burger.is(e.target)) {
            closeSidebar();
        }
    });

    // Keyboard navigation
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape' && $sidebar.hasClass('open')) {
            closeSidebar();
        }
    });

    // Handle smooth scrolling for anchor links
    $('.sidebar a[href^="#"]').on('click', function (e) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            closeSidebar();

            // Wait for sidebar to close before scrolling
            setTimeout(function () {
                $('html, body').animate({
                    scrollTop: target.offset().top - 80 // Account for header height
                }, 800);
            }, 300);
        }
    });

    // Handle Get A Quote button
    $('.get-a-quote').on('click', function (e) {
        e.preventDefault();

        const contactSection = $('#quote-section');

        if (typeof closeSidebar === 'function') {
            closeSidebar();
        }

        if (contactSection.length) {

            $('html, body').animate({
                scrollTop: contactSection.offset().top - 80
            }, 800);
        } else {
            // Fallback: redirect to contact page
            window.location.href = '/contact';
        }
    });

    // Prevent sidebar from closing when clicking inside it
    $sidebar.on('click', function (e) {
        e.stopPropagation();
    });

    // Handle window resize
    $(window).on('resize', function () {
        // Close sidebar on larger screens if open
        if ($(window).width() > 1024 && $sidebar.hasClass('open')) {
            closeSidebar();
        }
    });

    // Touch/swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    $sidebar.on('touchstart', function (e) {
        touchStartX = e.originalEvent.changedTouches[0].screenX;
    });

    $sidebar.on('touchend', function (e) {
        touchEndX = e.originalEvent.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeThreshold = 50;
        const swipeDistance = touchEndX - touchStartX;

        // Swipe right to close (when sidebar is open)
        if (swipeDistance > swipeThreshold && $sidebar.hasClass('open')) {
            closeSidebar();
        }
    }

    // Initialize ARIA attributes for accessibility
    $burger.attr({
        'aria-label': 'Open menu',
        'aria-expanded': 'false',
        'aria-controls': 'sidebar'
    });

    $closeBtn.attr({
        'aria-label': 'Close menu'
    });

    $sidebar.attr({
        'aria-hidden': 'true',
        'role': 'navigation',
        'aria-label': 'Main navigation'
    });

    // Update ARIA attributes when sidebar opens/closes
    function updateAriaAttributes() {
        const isOpen = $sidebar.hasClass('open');
        $burger.attr('aria-expanded', isOpen);
        $sidebar.attr('aria-hidden', !isOpen);
        $burger.attr('aria-label', isOpen ? 'Close menu' : 'Open menu');
    }

    // Override the open/close functions to update ARIA
    const originalOpenSidebar = openSidebar;
    const originalCloseSidebar = closeSidebar;

    openSidebar = function () {
        originalOpenSidebar();
        updateAriaAttributes();
    };

    closeSidebar = function () {
        originalCloseSidebar();
        updateAriaAttributes();
    };

    const $sidebarExtras = $('.sidebar-extra-items');
    const $quoteButton = $('.get-a-quote');
    const $searchContainer = $('.project-search-container');

    // Keep track of original locations
    const $quoteOriginalParent = $quoteButton.parent();
    const $searchOriginalParent = $searchContainer.parent();

    function moveToSidebar() {
        if ($(window).width() <= 768) {
            if (!$sidebarExtras.find('.get-a-quote').length) {
                $sidebarExtras.append($quoteButton);
            }
            if (!$sidebarExtras.find('.project-search-container').length) {
                $sidebarExtras.append($searchContainer);
            }
        } else {
            if (!$quoteOriginalParent.find('.get-a-quote').length) {
                $quoteOriginalParent.append($quoteButton);
            }
            if (!$searchOriginalParent.find('.project-search-container').length) {
                $searchOriginalParent.prepend($searchContainer);
            }
        }
    }

    // Initial move on load
    moveToSidebar();

    // Move on window resize
    $(window).on('resize', moveToSidebar);
});

document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('navbar');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
});