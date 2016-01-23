<?php

namespace netrivet\milestones;

/**
 * Get the cache key for a repository
 *
 * @param Repository $repo
 * @return string
 */
function cache_key(Repository $repo) {
    return "ms_" . md5($repo->user . $repo->name);
}

/**
 * Cache repo data
 *
 * @param array $data
 * @param Repository $repo
 * @return bool
 */
function cache_result(array $data, Repository $repo) {
    $key = cache_key($repo);
    return set_transient($key, json_encode($data), DAY_IN_SECONDS);
}

/**
 * Try to pull the cache for a repo
 *
 * @param Repository $repo
 * @return array|false
 */
function get_cache(Repository $repo) {
    $key = cache_key($repo);
    $data = get_transient($key);
    if ($data !== false) {
        return json_decode($data, true);
    }
    return false;
}
