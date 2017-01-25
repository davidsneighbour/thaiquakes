<?php

/**
 * Import script for the old json format to database.
 * Create a database first, then run this script.
 */
require_once('../setup.php');
require_once('../initialize.php');

$results = json_decode(file_get_contents(__DIR__ . '/../data.json'));

if (count($results) > 0) {
    foreach ($results as $key => $value) {
        $value = (array) $value;
        $db->AutoExecute('quakes', $value, 'INSERT');
    }
}

echo "imported $counter items";
