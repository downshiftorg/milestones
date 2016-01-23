<?php

namespace netrivet\milestones;

require 'cache.php';

use Github\Client;
use Github\HttpClient\CachedHttpClient;

/**
 * Get a GitHub client. The GitHub client will be set to cache
 * responses via transients
 *
 * @return Client
 */
function github_client() {
    $cached = new CachedHttpClient();
    $cached->setCache(new TransientCache());
    return new Client($cached);
}

/**
 * Authenticate a client using a token
 *
 * @param Client $client
 * @param $token
 * @return Client
 */
function authenticate_client(Client $client, $token) {
    $client->authenticate($token, null, Client::AUTH_HTTP_TOKEN);
    return $client;
}
