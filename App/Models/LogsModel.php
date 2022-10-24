<?php

namespace App\Models;

use \Core\Model;
use \App\Config;
use \App\Session;

/**
 * LogsModel
 *
 * PHP version 7.0
 */
class LogsModel
{
  // columns
  private static $columns = '*';

  // add logs
  public static function add($log = [])
  {
    // log info
    $insertArray = [
      'log_table'     =>  $log['table_name'] ?? '-',
      'log_message'   =>  $log['content'] ?? '',
      'user_id'       =>  isset($log['user_id']) ? intval($log['user_id']):intval(Session::user('id')),
      'meta_id'       =>  isset($log['meta_id']) ? intval($log['meta_id']) : 0,
      'log_ipaddress' =>  get_ip_address()
    ];
    // insert log
    return Model::logs('insert')->insert(Model::logs('table_name'), $insertArray);
  }
}
