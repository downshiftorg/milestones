<?php

namespace downshift\milestones;

/**
 * @param array $data
 * @return array
 */
function calculate_issue_totals(array $data) {
    foreach ($data as $id => $milestone) {
        $open = $milestone['open_issues'];
        $closed = $milestone['closed_issues'];
        $data[$id]['total_issues'] = $open + $closed;
    }
    return $data;
}

/**
 * @param array $data
 * @return array
 */
function calculate_percentage_complete(array $data) {
    foreach ($data as $id => $milestone) {
        $total = $milestone['total_issues'];

        if ($total === 0) {
            continue;
        }

        $closed = $milestone['closed_issues'];
        $percent = ($closed / $total) * 100;
        $data[$id]['percent_complete'] = round($percent);
    }
    return $data;
}
