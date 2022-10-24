<?php
namespace App\Models;

use \Core\Model;
use \App\Config;
use \App\Session;
// \App\Models\LogsModel
/**
 * Example BuyModel
 *
 * PHP version 7.1
 */
class BuyModel
{
  // columns
  private static $columns = '*';

  // all
  public static function all($limit = null)
  {
    $all = Model::buy(self::$columns)->orderby('id', 'DESC');
    if ($limit) {
      $all->limit(0, intval($limit));
    }
    $result = $all->resultArray();
    return $result;
  }

  // get
  public static function get($column, $value)
  {
    return Model::buy(self::$columns)->where($column, $value);
  }

  // get_by_id
  public static function get_by_id($reserve_id)
  {
    return self::get('id', $reserve_id)->getArray();
  }

  // get_by_id
  public static function get_by_row_id($id)
  {
    return self::get('row_id', $id)->getArray();
  }

  // get_by_id
  public static function get_by_yacht_id($id)
  {
    return self::get('yacht_id', $id)->getArray();
  }

  // exists
  public static function exists($column, $value)
  {
    return self::get($column, $value)->getArray();
  }

  // add
  public static function add($insertArray = [])
  {
    // table_name
    $table_name = Model::buy('table_name');
    // reserve
    $insert_id = Model::buy('insert')->insert($table_name, $insertArray);
    // response
    if ($insert_id)
      self::logs('Yeni satış eklendi. ( Satış Yapılan Yat: ' . $insertArray['yacht_title'] . ')', $insert_id);
    return $insert_id ? true:false;
  }

  // update
  public static function update_by_row_id($row_id, $updateArray = [])
  {
    // table_name
    $table_name = Model::buy('table_name');
    // update
    $db_response = Model::buy('update');
    if (is_array($updateArray)) :
      foreach ($updateArray as $key => $value)
        $db_response->set($key, $value);
    endif;
    $db_response->where('row_id', $row_id)->update($table_name);
    // response
    if ($db_response)
      self::logs($row_id . ' satış bilgileri güncellendi.', $row_id);
    return $db_response ? true:false;
  }

  // update
  public static function update($reserve_id, $updateArray = [])
  {
    // table_name
    $table_name = Model::buy('table_name');
    // update
    $db_response = Model::buy('update');
    if (is_array($updateArray)) :
      foreach ($updateArray as $key => $value)
        $db_response->set($key, $value);
    endif;
    $db_response->where('id', $reserve_id)->update($table_name);
    // response
    if ($db_response)
      self::logs(($updateArray['yacht_title'] ?? $reserve_id) . ' satış bilgileri güncellendi.', $reserve_id);
    return $db_response ? true:false;
  }

  public static function count()
  {
    // table_name
    $table_name = Model::buy('table_name');
    return Model::buy('query')->count('id')->from($table_name)->getArray();
  }

  // delete
  public static function delete($reserve_id)
  {
    // table_name
    $table_name = Model::buy('table_name');
    // delete
    $delete = Model::buy('delete')->where('id', intval($reserve_id))->delete($table_name);
    if ($delete)
      self::logs("ID: $reserve_id olan satış silindi", $reserve_id);
    return $delete ? true:false;
  }

  // logs
  private static function logs($content, $meta_id = 0)
  {
    $insertArray = array(
      'table_name' => Model::buy('table_name'),
      'content'    => $content,
      'meta_id'    => $meta_id
    );
    \App\Models\LogsModel::add($insertArray);
  }
}
