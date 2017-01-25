<?php

namespace Boka10;

/**
 * Booka's database class
 *
 * This is a singleton class that makes an AdoDB object available. Call it via
 * <code>$database = \Boka10\Database::getInstance();</code> in any class and use
 * appropriate. Documentation for AdoDB can be found at
 * <a href="http://phplens.com/lens/adodb/docs-adodb.htm">
 * http://phplens.com/lens/adodb/docs-adodb.htm</a>
 *
 * @category Core
 * @package  Boka
 * @author   Patrick Kollitsch <patrick@davids-neighbour.com>
 * @license  GPL-3.0
 * @link     https://davids-neighbour.com
 * @since    6.1.0
 */
class Database {

    /**
     * Database connection instance
     */
    static private $instance = null;

    /**
     * Returns instance of database connection
     *
     * AdoDB compatible instance of database connection.
     * <code>$database = \Boka10\Database::getInstance();</code>
     *
     * @return mixed instance of the database connection
     */
    public static function getInstance() {

        if (self::$instance === null) {
            self::$instance = ADONewConnection(DBTYPE);
            self::$instance->Connect(
                    DBHOST, DBUSER, DBPASS, DBNAME
            );
            if (!self::$instance) {
                die(
                        'Error, could not connect to the database - missing rights'
                );
            }
            self::$instance->SetFetchMode(ADODB_FETCH_ASSOC);
            if (defined('DEBUG') && DEBUG === true) {
                self::$instance->Debug = true;
            }
            self::$instance->Execute("SET NAMES 'utf8';");
            self::$instance->Execute("SET time_zone = '+7:00';");
            self::$instance->cacheSecs = 30;
        }
        return self::$instance;
    }

}
