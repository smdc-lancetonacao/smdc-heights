<?php

function menu_option() {
    register_nav_menu('primary', 'Primary Menu');
    register_nav_menu('secondary', 'Secondary Menu');
    register_nav_menu('tertiary', 'Tertiary Menu');
    
}

add_action('after_setup_theme', 'menu_option');