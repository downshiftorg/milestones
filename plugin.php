<?php
/**
 * Main plugin/application file for milestones
 */

namespace netrivet\milestones;

/**
 * Authenticate with a GitHub token
 *
 * @link https://github.com/blog/1509-personal-api-tokens
 */
update_option('milestones_github_token', 'REPLACE ME', true);

require_once 'plugin/api.php';
require_once 'plugin/model.php';
require_once 'plugin/list_milestones/list_milestones.php';

