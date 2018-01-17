<?php

require_once __DIR__ . '/../../src/view/view.php';

/**
 * Shortcode
 */
add_shortcode('milestones', 'downshift\milestones\shortcode');

/**
 * CSS
 */
add_action('milestones_shortcode', function () {
    $css = plugin_dir_url(__FILE__) . 'css/list_milestones.css';
    $url = apply_filters('milestones_list_milestones_css', $css);
    wp_enqueue_style('milestones_list_milestones', $url, array(), '1.0.0');
});
