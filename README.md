# quakes
A simple xml parser for the Thai Weather Departments quirky quake xml feed.

# why
The Thai Meterological Department offers a xml feed of recent earth quakes in the region. You can find this feed at http://www.tmd.go.th/en/xml/earthquake_eng.php. Problem with this feed is, that the main information is inside of items encoded as HTML inside of a CDATA tag, Latitude and Longitude encoded as degree, minutes, second, time in no standardized way, aso. - which makes it basically impossible to use the feed in any automatic processes.

The script provided in this repository is parsing the data into an array and saving it as JSON. It's provided as is. Improvements are welcome.

# how to
run `php xml-parser.php`, it will create a file data.json with the data. if the file data.json already exists it will be included on future runs - thus creating a big long json file with quake data. i guess it would make sense to run this script as a cronjob, the original file seems to hold only three recent items.