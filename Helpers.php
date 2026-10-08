<?php
declare(strict_types=1);

// Trim spaces and fix capitalisation: ' sonam ' -> 'Sonam', 'paro' -> 'Paro'
function tidy_name(string $text): string
{
    return ucfirst(strtolower(trim($text)));
}

// A valid CID is exactly 11 digits.
function is_valid_cid(string $cid): bool
{
    return strlen($cid) === 11 && ctype_digit($cid);
}

// Exercise 3: PAR-2026-0002
function make_reference(int $id, string $dzongkhag, string $submitted): string
{
    $place = strtoupper(substr(trim($dzongkhag), 0, 3)); // part 1
    $year  = substr($submitted, 0, 4);                   // part 2
    // Decision: sprintf pads to AT LEAST 4 digits and never cuts digits off,
    // so id 12345 becomes "12345". That is acceptable: a longer reference is
    // better than a wrong one. Truncating would create duplicate references.
    $number = sprintf('%04d', $id);                      // part 3
    return $place . '-' . $year . '-' . $number;
}

// Exercise 4
function wait_band(int $days): string
{
    if ($days < 0) {
        return 'Check date';
    } elseif ($days <= 7) {
        return 'On time';
    } elseif ($days <= 14) {
        return 'Follow up';
    }
    return 'Overdue';
}

// Exercise 5: the rules live in data, not in if/elseif.
const STATUS_RULES = [
    'Submitted'    => ['Under review'],
    'Under review' => ['Approved', 'Rejected'],
    'Rejected'     => ['Submitted'],
    'Approved'     => [],
];

const ROLE_TARGETS = [
    'officer'   => ['Under review'],
    'approver'  => ['Approved', 'Rejected'],
    'requester' => ['Submitted'],
];

function can_move(string $from, string $to): bool
{
    // ?? [] stops "Undefined array key" for unknown statuses like 'Closed'
    return in_array($to, STATUS_RULES[$from] ?? [], true);
}

function can_move_as(string $role, string $from, string $to): bool
{
    return can_move($from, $to) && in_array($to, ROLE_TARGETS[$role] ?? [], true);
}