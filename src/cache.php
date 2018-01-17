<?php

namespace downshift\milestones;

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
 * Generate a cache key for the repository and return it
 *
 * @param Repository $repo
 * @return string
 */
function cache_repository_key(Repository $repo) {
    $key = cache_key($repo);
    $cached = get_repository_key_cache();
    $cached["{$repo->user}/{$repo->name}"] = $key;
    set_transient('ms_cached_repos', $cached, DAY_IN_SECONDS);
    return $key;
}

/**
 * Cache repo data
 *
 * @param array $data
 * @param Repository $repo
 * @return bool
 */
function cache_result(array $data, Repository $repo) {
    $key = cache_repository_key($repo);
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

/**
 * Get the cache keys for all repositories
 *
 * @return array|mixed
 */
function get_repository_key_cache() {
    $cached = get_transient('ms_cached_repos');

    if ($cached === false) {
        $cached = [];
    }

    return $cached;
}

/**
 * Clear cached GitHub repositories
 */
function clear_cache() {
    $cached = get_option('ms_cached_repos', array());
    foreach ($cached as $name => $key) {
        delete_transient($key);
    }
    delete_transient('ms_cached_repos');
}
