<?php
declare(strict_types=1);
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

/* ORIGINAL (buggy):
function count_pending(array $requests): int
{
    $total = 0;
    for ($i = 1; $i < count($requests); $i++) {          // bug 1
        $status = $requests[$i]['Status'];                // bug 2
        if ($status = 'Submitted' || $status === 'Under review') { // bug 3
            $total + 1;                                   // bug 4
        }
    }                                                     // bug 5: no return
}
*/

function count_pending(array $requests): int
{
    $total = 0;
    for ($i = 0; $i < count($requests); $i++) {      // 1: start at 0, not 1
        $status = $requests[$i]['status'];           // 2: key is 'status' (lower-case)
        if ($status === 'Submitted' || $status === 'Under review') { // 3: === not =
            $total++;                                // 4: actually change $total
        }
    }
    return $total;                                   // 5: return the result
}

echo count_pending($requests) . "\n"; // 5

/* BUG LOG
1. Symptom: Request #1 was never counted (answer too low), no error.
   Cause: loop started at $i = 1, but arrays start at index 0.
   Fix: for ($i = 0; ...).
2. Symptom: Warning "Undefined array key 'Status'".
   Cause: keys are case-sensitive; the key is 'status'.
   Fix: $requests[$i]['status'].
3. Symptom: every request counted (or wrong answer), no error.
   Cause: = assigns; and `$status = 'Submitted' || ...` stores true in $status.
   Fix: use === for comparing.
4. Symptom: $total stays 0.
   Cause: `$total + 1;` calculates a value but throws it away.
   Fix: $total++; or $total += 1;
5. Symptom: TypeError "Return value must be of type int, none returned".
   Cause: the function never returns anything.
   Fix: return $total;
*/