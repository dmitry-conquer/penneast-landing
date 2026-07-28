<?php
/**
 * Digital Banking Landing assets.
 */

if (!defined('ABSPATH')) {
    exit;
}

function penneast_enqueue_digital_banking_assets()
{
    if (is_admin() || !is_page_template('templates/digital-banking-landing.php')) {
        return;
    }

    $theme_directory = get_template_directory();
    $theme_uri = get_template_directory_uri();

    $style_relative_path = '/assets/css/style.css';
    $script_relative_path = '/assets/js/script.js';

    $style_path = $theme_directory . $style_relative_path;
    $script_path = $theme_directory . $script_relative_path;

    if (file_exists($style_path)) {
        wp_enqueue_style(
            'digital-banking-landing',
            $theme_uri . $style_relative_path,
            [],
            (string) filemtime($style_path)
        );
    }

    if (file_exists($script_path)) {
        wp_enqueue_script(
            'digital-banking-landing',
            $theme_uri . $script_relative_path,
            [],
            (string) filemtime($script_path),
            true
        );
    }

    $allowed_style_handles = [
        'digital-banking-landing',
    ];

    if (is_admin_bar_showing()) {
        $allowed_style_handles[] = 'admin-bar';
        $allowed_style_handles[] = 'dashicons';
    }

    $wp_styles = wp_styles();

    foreach ((array) $wp_styles->queue as $style_handle) {
        if (!in_array($style_handle, $allowed_style_handles, true)) {
            wp_dequeue_style($style_handle);
        }
    }
}
add_action('wp_enqueue_scripts', 'penneast_enqueue_digital_banking_assets', 9999);
