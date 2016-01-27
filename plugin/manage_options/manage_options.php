<?php

namespace netrivet\milestones;

require_once __DIR__ . '/../../src/cache.php';

/**
 * Render the options form
 */
function options_page() {
    $repositories = get_repository_key_cache();
    require_once __DIR__ . '/options-form.php';
}

/**
 * Adds the Milestones options page
 */
function admin_menu() {
    add_options_page(
        'Milestones Settings',
        'Milestones',
        'manage_options',
        'milestones',
        'netrivet\milestones\options_page'
    );
}

/**
 * Ouput the input used to collect the access token
 */
function github_token_input() {
    echo sprintf(
        '<input name="ms_github_access_token" id="ms_github_access_token" type="text" value="%s" /> <a target="_blank" href="https://github.com/blog/1509-personal-api-tokens">What Is This?</a>',
        esc_attr(get_option('ms_github_access_token'))
    );
}

/**
 * Register settings with the WordPress settings API
 */
function register_settings() {
    add_settings_section(
        'ms_github_settings_section',
        'GitHub settings',
        function () {
            echo '<p>Manage GitHub API integration</p>';
        },
        'milestones'
    );

    add_settings_field(
        'ms_github_access_token',
        'GitHub API Access Token',
        'netrivet\milestones\github_token_input',
        'milestones',
        'ms_github_settings_section',
        ['label_for' => 'ms_github_token']
    );

    register_setting(
        'milestones',
        'ms_github_access_token'
    );
}

/**
 * Delete the cache if a cache clear has been requested
 */
function handle_clear_cache() {
    if (! isset($_POST['ms_clear_cache'])) {
        return;
    }
    clear_cache();
}

add_action('admin_menu', 'netrivet\milestones\admin_menu');
add_action('admin_init', 'netrivet\milestones\register_settings');
add_action('admin_init', 'netrivet\milestones\handle_clear_cache');
