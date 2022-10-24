<?php

namespace Core;

use IS\QueryBuilder\Database\PDOClient;
require_once __DIR__ . "/vendor/autoload.php";

/**
 * Base Model
 *
 * PHP version 7.1
 */
class Model
{
  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function buy($columns = '*')
  {
    $table_name = 'sales';
    $primary_id = 'id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function reserve($columns = '*')
  {
    $table_name = 'reserve';
    $primary_id = 'id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function payment($columns = '*')
  {
    $table_name = 'online_payment';
    $primary_id = 'id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }


  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function yacht($columns = '*')
  {
    $table_name = 'yachts';
    $primary_id = 'yc_id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function yacht_type($columns = '*')
  {
    $table_name = 'yacht_type';
    $primary_id = 'type_id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function yacht_extra($columns = '*')
  {
    $table_name = 'yacht_extra';
    $primary_id = 'ex_id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function yacht_feature($columns = '*')
  {
    $table_name = 'yacht_feature';
    $primary_id = 'feature_id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function yacht_gallery($columns = '*')
  {
    $table_name = 'yacht_gallery';
    $primary_id = 'gallery_id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function organization($columns = '*')
  {
    $table_name = 'organization';
    $primary_id = 'id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function regions($columns = '*')
  {
    $table_name = 'regions';
    $primary_id = 'id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function blog($columns = '*')
  {
    $table_name = 'blog';
    $primary_id = 'b_id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function contact($columns = '*')
  {
    $table_name = 'contact';
    $primary_id = 'id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function users($columns = '*')
  {
    $table_name = 'users';
    $primary_id = 'id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function files($columns = '*')
  {
    $table_name = 'files';
    $primary_id = 'file_id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function settings($columns = '*')
  {
    $table_name = 'settings';
    $primary_id = 'id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $columns = '*'
   * @return Database::connect()->select()->from()
   */
  public static function logs($columns = '*')
  {
    $table_name = 'logs';
    $primary_id = 'log_id';
    // Database->connect
    return self::table($table_name, $primary_id, $columns);
  }

  /**
   * Parameters $query
   * @return Database::connect()->table()
   */
  public static function table($table, $primary_id = 'id', $columns = '*')
  {
    // table_name
    if ($columns == 'table_name') return $table;
    // $primary_id
    if ($columns == 'primary_id') return $primary_id;
    // insert, delete, query
    if ($columns == 'insert' || $columns == 'update' || $columns == 'delete' || $columns == 'query') {
      return self::connect();
    }
    // Database->connect
    return self::connect()->select($columns)->from($table);
  }

  /**
   * Parameters $query
   * @return Database::connect()->query()
   */
  public static function query($query, $value = [], $type = 2)
  {
    /*
     * @param sql sorgusu
     * @param sql sorgu değerleri
     * @param dönüş türü
     * 0 => DEFAULT true
     * 1 => fetchAll ( Object )
     * 2 => fetchAll ( Array )
     * 3 => fetch ( Object )
     * 4 => fetch ( Array )
     * 5 => rowcount ( int )
     * 6 => lastInsertId ( int )
     */
     // type
     if(intval($type) < 0 || intval($type) > 6) $type = 2;
     // ! is_array
     if (!is_array($value)) $value = [];
     // return query
    return self::connect()->query($query, $value, 2);
  }

  /**
   * @param object $db
   * @return count
   */
  public static function count($query)
  {
    // is object
    if(!is_object($query)) return 0;
    // sqldata
    $sqlData = $query->getSqlSelect();
    // query
    if(isset($sqlData['query']) != true || isset($sqlData['value']) != true) return 0;
    // explode
    $exp_query = explode('FROM', $sqlData['query']);
    // false
    if(count($exp_query) != 2 || isset($exp_query[1]) != true) return 0;
    // count
    $count = self::query("SELECT COUNT('*') as Total FROM " . $exp_query[1], $sqlData['value'], 5);
    if($count) return $count[0]['Total'];
    // default
    return 0;
  }

  /**
   * @return Database::connect()
   */
  public static function db()
  {
    return self::connect();
  }

  /**
   * Parameters from the matched route
   * @return Database::connect
   */
  private static function connect()
  {
    return new PDOClient(array(
    	// Server Ip Default: localhost
    	'ip'        => \App\Config::DB_HOST,
    	// Database Name
    	'database'  => \App\Config::DB_NAME,
    	// Database Engine Name oracle,mysql ...
    	'dbengine'  => 'mysql',
    	// Database Username
    	'username'  => \App\Config::DB_USER,
    	// Database Password
    	'password'  => \App\Config::DB_PASS,
    	// Database Charset Default: utf8
    	'charset'   => \App\Config::DB_CHAR,
    	// Database table prefix Default: null
    	'prefix'    => null,
    	// Database exception Default: on
    	'exception' => true,
    	// Database persistent connection timeout Default: false
    	'persistent' => 30,
    	// Database query log Default: off
    	'querylog'  => false,
    ));
  }
}
