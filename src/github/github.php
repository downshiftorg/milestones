<?php

namespace netrivet\milestones;

use Github\Client;

require 'client.php';
require 'repository.php';

/**
 * @param Client $client
 * @param Repository $repo
 * @return array
 */
function get_milestones(Client $client, Repository $repo) {
    $milestones = $client->api('issue')->milestones()->all($repo->user, $repo->name, array(
        'state' => 'open',
        'sort' => 'due_on',
        'direction' => 'asc'
    ));
    return array_filter($milestones, 'netrivet\milestones\milestone_is_open');
}

/**
 * @param array $milestone
 * @return bool
 */
function milestone_is_open(array $milestone) {
    $openIssues = $milestone['open_issues'];
    $closedIssues = $milestone['closed_issues'];
    return !($openIssues === 0 && $closedIssues === 0);
}

/**
 * Get only issues containing milestones
 *
 * @param Client $client
 * @param Repository $repo
 * @return array
 */
function get_all_issues(Client $client, Repository $repo) {
    $page = 1;
    $milestoneIssues = array();
    $issues = get_issues($client, $repo, $page);

    while (!empty($issues)) {
        foreach ($issues as $issue) {
            if (isset($issue['milestone'])) {
                $milestoneIssues[] = $issue;
            }
        }
        $issues = get_issues($client, $repo, ++$page);
    }

    return $milestoneIssues;
}

/**
 * @param Client $client
 * @param Repository $repo
 * @return mixed
 */
function get_issues(Client $client, Repository $repo, $page = 1)
{
    $issues = $client->api('issue')->all($repo->user, $repo->name, array(
        'state' => 'all',
        'page' => $page
    ));
    return $issues;
}

/**
 * Return a collection of milestones with issues on them
 *
 * @param array $milestones
 * @param array $issues
 * @return array
 */
function merge_milestone_issues(array $milestones, array $issues) {
    $keyed = array();
    foreach ($milestones as $milestone) {
        $milestone['issues'] = array();
        $keyed[$milestone['id']] = $milestone;
    }

    foreach ($issues as $issue) {
        $keyed[$issue['milestone']['id']]['issues'][] = $issue;
    }

    return apply_filters('milestones_merged', $keyed);
}
