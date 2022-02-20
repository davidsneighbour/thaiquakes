<?php

/**
 * @constant SERVERNAME contains hostname of current server
 */
define(
    'SERVERNAME',
    (!empty($_SERVER['SERVER_NAME']))
        ? $_SERVER['SERVER_NAME']
        : (
            (!empty($_SERVER['HTTP_HOST']))
                ? $_SERVER['HTTP_HOST']
                : 'localhost'
    )
);

/** load config and classes **/
try {
    include_once(__DIR__ . '/setup.php');
} catch (Exception $exc) {
    die('no configuration found. run setup first.');
}
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/Database.php');

/** database connection * */
$db = \Boka10\Database::getInstance();
if (!$db) {
    die('Error, could not connect to the database - missing rights');
}
