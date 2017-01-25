<?php

/**
 * scans the given directory and returns the content in an array
 *
 * @param string $dir which directory to scan
 * @param bool $folders return folders in the scanned folder too
 * @return array files (if $folders = true folders are also returned) in the folder
 */
function dirIndex($dir, $folders = false) {

    if (is_dir($dir)) {

        $output = array();
        $handle = opendir($dir);

        if (!$handle) {

            return false;
        }

        while ($file = readdir($handle)) {

            if ($file <> "." && $file <> ".." && $file <> ".svn" && $file <> "CVS") {

                if (!is_dir($file)) {

                    $output[] = $file;
                } elseif (is_dir($file) && $folders == true) {

                    $output[] = $file;
                }
            }
        }

        closedir($handle);
        if (is_array($output)) {

            sort($output);
        }
        return $output;
    }

    return false;
}

/**
 * @constant SERVERNAME contains hostname of current server
 */
define('SERVERNAME', (!empty($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : ((!empty($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : 'localhost'));

/** load config * */
try {
    include_once(ROOTDIR . '/setup.php');
} catch (Exception $exc) {
    die('no configuration found. run setup first.');
}

/**
 * activating error reporting
 */
require_once(ROOTDIR . '/vendor/autoload.php');
require_once(ROOTDIR . '/Database.php');

if (ISLOCAL === true) {
    error_reporting(-1);
    Kint::enabled(true);
    Kint::$theme = 'solarized-dark';
} else {
    Kint::enabled(false);
}

/** database connection * */
$db = \Boka10\Database::getInstance();
if (!$db) {
    die('Error, could not connect to the database - missing rights');
}
