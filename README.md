# ThaiQuakes

A simple parser and historical data collection for the Thai Weather Department's quirky quake XML feed.

## Why

The [Thai Meterological Department](https://www.tmd.go.th/en/) offers a XML feed of recent earth quakes in the region. You can find this feed at [http://www.tmd.go.th/en/xml/earthquake_eng.php]. The problem with this feed is, that the main information is inside of items encoded as HTML inside of a CDATA tag, Latitude and Longitude encoded as degree, minutes, second, time in no standardized way, etc. - which makes it impossible to parse the data useful and fast.

The scripts provided in this repository are parsing the data into an array and save it as JSON.

## How To

To be written...

This is work in progress. For a working PHP version check the [old PHP version](https://github.com/davidsneighbour/thaiquakes/tree/php/old).

## Features

- :heavy_check_mark: Parsing and saving data
- :x: Github workflows to automatically collect data
- :x: graphic display on a map

## History

This project originated in [a PHP version](https://github.com/davidsneighbour/thaiquakes/tree/php/old) that I wrote in 2015 and that run since then un-monitored on my server. It worked, but didn't really collect data and was also outdated, which is why I started working on this new Node based version.
