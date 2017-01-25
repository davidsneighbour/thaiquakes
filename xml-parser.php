<?php

define('ROOTDIR', dirname(__FILE__));

require_once(ROOTDIR . '/setup.php');
require_once(ROOTDIR . '/initialize.php');

$data = file_get_contents('http://www.tmd.go.th/en/xml/earthquake_eng.php');
$xml = simplexml_load_string($data, null, LIBXML_NOCDATA);

foreach ($xml->channel->item as $item) {

    $items = explode('<br />', $item->description[0]);
    $output = array();

    foreach ($items as $line) {

        $line = trim($line);
        switch (substr($line, 0, 4)) {

            case "Date":
                $output['date'] = trim(str_replace('Date:', '', $line));
                break;

            case "Time":
                $output['time'] = trim(str_replace('Time:', '', str_replace('(Thailand)', '', $line)));
                $output['time'] = trim(str_replace('pm', '', str_replace('am', '', $output['time'])));
                break;

            case "Magn":
                $output['magnitude'] = trim(str_replace('Magnitude:', '', str_replace('richter', '', $line)));
                break;

            case "Orig":
                $output['origin'] = trim(str_replace('Origin:', '', $line));
                break;

            case "Lati":
                $output['lat'] = trim(str_replace('Latitude:', '', $line));
                break;

            case "Long":
                $output['long'] = trim(str_replace('Longtitude:', '', $line));
                break;

            case "Dept":
                $output['depth'] = trim(str_replace('Depth:', '', substr($line, 0, strlen($line) - 1)));
                break;
        }
    }

    $output['latitude'] = prepareStringLatLng($output['lat']);
    $output['longitude'] = prepareStringLatLng($output['long']);
    $output['timestamp'] = strtotime($output['date'] . " " . $output['time']);

    $db->AutoExecute('quakes', $output, 'INSERT');
}

function prepareStringLatLng($string) {
    $parts = explode(' ', trim($string));
    $value = DMStoDEC(intval($parts[0]), intval($parts[1]), intval($parts[2]));
    if ($parts[3] === 'South' || $parts[3] === 'West') {
        $value = 0 - $value;
    }
    return $value;
}

function DMStoDEC($deg, $min, $sec) {
    return $deg + ((($min * 60) + ($sec)) / 3600);
}

/**
 * create sendgrid setup
 * @see https://github.com/sendgrid/sendgrid-php
 */
//$from = new SendGrid\Email(null, FROMADDRESS);
//$subject = "Script executed";
//$to = new SendGrid\Email(null, TOADDRESS);
//$content = new SendGrid\Content("text/plain", "Hello, Email!");
//$mail = new SendGrid\Mail($from, $subject, $to, $content);
//$sg = new \SendGrid(SENDGRIDKEY);
//
//$response = $sg->client->mail()->send()->post($mail);
//echo "status code: " . $response->statusCode() . N;
//Kint::dump($response->headers());
//echo N . N . $response->body();
