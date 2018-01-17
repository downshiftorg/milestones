<?php

namespace downshift\milestones;

require_once __DIR__ . '/../github/github.php';

/**
 * Render milestones after filtering shortcode attributes
 *
 * @param array|string $atts - short code attributes
 * @return string
 */
function shortcode($atts) {
	$attributes = shortcode_atts([
		'user' => 'downshift',
		'repository' => 'prophoto-issues'
	], $atts);

	$repository = new Repository($attributes['user'], $attributes['repository']);
	$client = authenticated_client();

	$data = apply_filters('milestones_request', array(), $client, $repository);
	do_action('milestones_shortcode');

	return render($data);
}

/**
 * Render milestones
 *
 * @param array $data
 * @return string
 */
function render($data = array()) {
    $view = view('layout');
	$template = apply_filters('milestones_template', $view);
	ob_start();
	require $template;
	return ob_get_clean();
}

/**
 * Return the path to a view file. Path will be searched
 * relative to the views directory defined by MILESTONES_VIEW_DIR
 *
 * @param string $shortname - the filename without extension.
 * @return string
 */
function view($shortname) {
    $path = MILESTONES_VIEW_DIR . "/$shortname.php";
    return $path;
}
