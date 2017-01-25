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
 * @license  http://davids-neighbour.com Proprietary
 * @link     http://inkohsamui.com
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

    /**
     * Checks if the table requested has a deleted indicator.
     *
     * @param string $table tablename to check
     *
     * @return bool has the table requested a `is_deleted` column
     */
    public static function hasDeleteColumn($table) {
        return self::hasColumn($table, 'is_deleted');
    }

    /**
     * Checks if the table requested has the requested column.
     *
     * @param string $table tablename to check
     * @param string $column columnname to check
     *
     * @return bool has the table requested column with the name requested
     */
    public static function hasColumn($table, $column) {

        $database = \Boka10\Database::getInstance();
        // check if colum `is_deleted` exists
        $sql = "SHOW COLUMNS FROM `" . $table . "` LIKE '" . $column . "'";
        $column_exists = $database->GetAll($sql);

        return (count($column_exists) > 0) ? true : false;
    }

    /**
     * Returns next autoincrement id for add-forms
     *
     * @return int next autoincrement id for the current main table
     * @todo check what to do when there is no autoincrement table
     */
    public function getNextId() {
        $database = \Boka10\Database::getInstance();
        $autoincrementColumn = $database->GetOne("
            SELECT `column_name`
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE
                `table_name` = '" . static::MAINTABLE . "' AND
                `extra` = 'auto_increment'
            LIMIT 0,1
        ");
        $next = $database->GetOne("
            SELECT MAX($autoincrementColumn)+1
            FROM " . static::MAINTABLE . "
        ");
        return $next;
    }

}
