<?php
declare(strict_types=1);
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

// Snippet A
// Prediction: none | 0
// Reason: ?: treats 0 as "empty" (falsy) so it picks 'none'.
//         ?? only replaces null or unset, and 0 is neither, so it keeps 0.
$x = 0;
$label = $x ?: 'none';
$size = $x ?? 'none';
echo "A: $label | $size\n";

// Snippet B
// Prediction: 19
// Reason: adds 1,2,4,5,7 (=19). 3 and 6 are skipped by continue.
//         At 8 the break stops the loop before adding.
$total = 0;
for ($i = 1; $i <= 10; $i++) {
    if ($i % 3 === 0) {
        continue;
    }
    if ($i > 7) {
        break;
    }
    $total += $i;
}
echo "B: $total\n";

// Snippet C
// Prediction: BaC
// Reason: values above 1 (b=2, c=3) have their key turned to capitals.
$m = ['b' => 2, 'a' => 1, 'c' => 3];
$out = '';
foreach ($m as $k => $v) {
    $up = $v > 1;
    $out .= $up ? strtoupper($k) : $k;
}
echo "C: $out\n";

// Snippet D
// Prediction: 4ro
// Reason: trim removes the spaces so strlen is 4; substr('Paro', -2) is the last 2 letters, 'ro'.
$n = strlen(trim('  Paro  '));
echo "D: " . $n . substr('Paro', -2) . "\n";