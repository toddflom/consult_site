<?php


// Include necessary files
include_once 'sys/core/init.inc.php';

// Load the admin object

$obj = new Admin($dbo);

// Load a hash of the word test and output it
$hash1 = $obj->testSaltedHash("ClyncH13!");
echo "Hash 1 without a salt:
", $hash1, "

";

// Pause execution for a second to get a different timestamp
sleep(1);

// Load a second hash of the word test
$hash2 = $obj->testSaltedHash("ClyncH13!");
echo "Hash 2 without a salt:
", $hash2, "

";

// Pause execution for a second to get a different timestamp
sleep(1);

// Rehash the word test with the existing salt
$hash3 = $obj->testSaltedHash("ClyncH13!", $hash2);
echo "Hash 3 with the salt from hash 2:
", $hash3;

?>