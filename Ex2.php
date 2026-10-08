<?php
declare(strict_types=1);
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

// Loop 1: count pending requests per (tidied) Dzongkhag
$counts = [];
foreach ($requests as $r) {
    if ($r['status'] === 'Submitted' || $r['status'] === 'Under review') {
        $place = tidy_name($r['dzongkhag']);
        $counts[$place] = ($counts[$place] ?? 0) + 1;
    }
}

// Loop 2: find the highest count (no max())
$highest = 0;
foreach ($counts as $count) {
    if ($count > $highest) {
        $highest = $count;
    }
}

// Loop 3: collect every Dzongkhag that has the highest count (handles ties)
$winners = [];
foreach ($counts as $place => $count) {
    if ($count === $highest) {
        $winners[] = $place;
    }
}

echo 'Busiest: ' . implode(', ', $winners) . " ($highest pending)\n";

// Think about: without tidying, 'paro' and 'Paro' are different array keys,
// so each gets 1 pending. Every Dzongkhag then ties on 1 and the program
// prints all of them. The counts are split, so the real winner is hidden.