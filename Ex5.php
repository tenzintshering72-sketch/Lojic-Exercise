<?php
declare(strict_types=1);
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';
// The rules array (STATUS_RULES) and can_move() are in helpers.php.

$tests = [
    ['Submitted',    'Under review'],
    ['Submitted',    'Approved'],
    ['Under review', 'Rejected'],
    ['Approved',     'Submitted'],
    ['Rejected',     'Submitted'],
    ['Closed',       'Submitted'],
];

foreach ($tests as [$from, $to]) {
    echo "$from → $to: " . (can_move($from, $to) ? 'Allowed' : 'Blocked') . "\n";
}

// Extension
echo "\n";
$roleTests = [
    ['officer',   'Under review', 'Approved'],  // false
    ['approver',  'Under review', 'Approved'],  // true
    ['requester', 'Rejected',     'Submitted'], // true
];
foreach ($roleTests as [$role, $from, $to]) {
    echo "$role: $from → $to = " . (can_move_as($role, $from, $to) ? 'true' : 'false') . "\n";
}

// Why an array is better than if/elseif: the rules are data. To add or change a
// status you edit one line, not the logic. There is less repeated code, fewer
// places for bugs, and the same rules can be reused (can_move_as reuses can_move).