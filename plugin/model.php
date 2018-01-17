<?php

require_once __DIR__ . '/../src/model.php';

/**
 * Model
 */
add_filter('milestones_merged', 'downshift\milestones\calculate_issue_totals');
add_filter('milestones_merged', 'downshift\milestones\calculate_percentage_complete');
