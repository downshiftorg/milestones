<?php

namespace netrivet\milestones;

use Github\Client;

require_once __DIR__ . '/../src/hooks.php';
require_once __DIR__ . '/../src/github/github.php';

request(function(array $request, Client $client, Repository $repo) {
    $request['milestones'] = get_milestones($client, $repo);
    return $request;
});

request(function(array $request, Client $client, Repository $repo) {
    $request['issues'] = get_all_issues($client, $repo);
    return $request;
});

request(function(array $request) {
    return merge_milestone_issues($request['milestones'], $request['issues']);
});

request(function(array $request, Client $client, Repository $repository) {
    cache_result($request, $repository);
    return $request;
});
