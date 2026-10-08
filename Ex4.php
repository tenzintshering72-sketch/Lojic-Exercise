<?php
declare(strict_types=1);
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

date_default_timezone_set('UTC'); // same result everywhere
$today = '2026-10-07';

$overdue = 0;
$followUp = 0;
$onTime = 0;

foreach ($requests as $r) {
    if ($r['status'] !== 'Submitted' && $r['status'] !== 'Under review') {
        continue; // only pending requests
    }

    $days = intdiv(strtotime($today) - strtotime($r['submitted']), 86400);
    $band = wait_band($days);
    $name = tidy_name($r['first']) . ' ' . tidy_name($r['last']);

    echo "#{$r['id']} $name — $days days — $band\n";

    if ($band === 'Overdue') {
        $overdue++;
    } elseif ($band === 'Follow up') {
        $followUp++;
    } elseif ($band === 'On time') {
        $onTime++;
    }
}

echo "\n$overdue overdue · $followUp follow up · $onTime on time\n";

// Edge tests
echo "\nEdge tests\n";
foreach ([-1, 0, 7, 8, 14, 15] as $d) {
    echo "wait_band($d) = " . wait_band($d) . "\n";
}
// Expected: Check date, On time, On time, Follow up, Follow up, Overdue