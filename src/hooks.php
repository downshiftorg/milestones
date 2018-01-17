<?php

namespace downshift\milestones;

use Github\Client;

require_once 'cache.php';

/**
 * Helper for queuing up a filter for the milestones request
 *
 * @param $callback
 * @param int $priority
 */
function request($callback, $priority = 10) {
    add_filter('milestones_request', function (array $request, Client $client, Repository $repo) use ($callback) {
        if ($data = get_cache($repo)) {
            return $data;
        }
        return $callback($request, $client, $repo);
    }, $priority, 3);
}
