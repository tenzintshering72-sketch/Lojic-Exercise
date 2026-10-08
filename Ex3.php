<?php
declare(strict_types=1);
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

// Tests
echo make_reference(2, ' paro ', '2026-09-20') . "\n";  // PAR-2026-0002
echo make_reference(6, 'Bumthang', '2026-10-03') . "\n"; // BUM-2026-0006
echo make_reference(1, 'Thimphu', '2026-09-14') . "\n";  // THI-2026-0001
echo "---\n";

foreach ($requests as $r) {
    echo make_reference($r['id'], $r['dzongkhag'], $r['submitted']) . "\n";
}

// My decision: id 12345 gives "...-12345". sprintf never cuts digits,
// and a longer reference is better than a duplicate one.