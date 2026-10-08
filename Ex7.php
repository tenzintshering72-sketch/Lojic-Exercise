<?php
declare(strict_types=1);
require_once __DIR__ . '/data.php';
require_once __DIR__ . '/helpers.php';

// 1. Group request ids by CID
$groups = [];
foreach ($requests as $r) {
    $groups[$r['cid']][] = $r['id'];
}

// 2. Print only CIDs used by more than one request
foreach ($groups as $cid => $ids) {
    if (count($ids) > 1) {
        echo "Duplicate $cid: requests " . implode(', ', $ids) . "\n";
    }
}

// 3. List invalid CIDs
foreach ($requests as $r) {
    if (!is_valid_cid($r['cid'])) {
        echo "Invalid CID in request {$r['id']}: {$r['cid']}\n";
    }
}

// Think about: a duplicate is not always an error. The same person may submit
// two requests (e.g. one per field). But requests 1 and 4 have different names
// on the same CID, so Karma should check the records, contact the applicants or
// the source documents, and fix whichever one has the wrong CID.