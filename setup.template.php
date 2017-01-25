<?php

/**
 * Setup Database
 *

  CREATE TABLE `quakes` (
  `timestamp` int(20) NOT NULL,
  `magnitude` float NOT NULL,
  `origin` text COLLATE utf8_general_mysql500_ci NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

  ALTER TABLE `quakes`
  ADD PRIMARY KEY (`timestamp`),
  ADD UNIQUE KEY `timestamp` (`timestamp`);

 */
define('DBNAME', '');
define('DBTYPE', 'mysqli');
define('DBUSER', '');
define('DBPASS', '');
define('DBHOST', '');
define('ISLOCAL', true);
define('FROMADDRESS', '');
define('TOADDRESS', '');
define('SENDGRIDKEY', '');
define('SENDEMAILON', 'all'); // all, error

/**
 *  no need to change any of these
 */
define('N', "\n");
