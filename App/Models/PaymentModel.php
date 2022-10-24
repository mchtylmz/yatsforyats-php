<?php
namespace App\Models;

use \Core\Model;
use \App\Config;
use \App\Session;
// \App\Models\LogsModel
/**
 * Example PaymentModel
 *
 * PHP version 7.1
 */
class PaymentModel
{
  // columns
  private static $columns = '*';

  // all
  public static function all($limit = null)
  {
    $all = Model::payment(self::$columns)->orderby('id', 'DESC');
    if ($limit) {
      $all->limit(0, intval($limit));
    }
    $result = $all->resultArray();
    return $result;
  }

  // get
  public static function get($column, $value)
  {
    return Model::payment(self::$columns)->where($column, $value);
  }

  // get_by_slug_id_and_id
  public static function get_by_slug_id_and_id($slug_id, $reserve_id)
  {
    $payment = Model::payment()
    ->where('slug', $slug_id)
    ->where('reserve_id', $reserve_id)
    // ->where('status', 'waiting')
    ->getArray();
    return $payment;
  }

  // get_by_id
  public static function get_by_id($payment_id)
  {
    return self::get('id', $payment_id)->getArray();
  }

  // get_by_id
  public static function get_by_reserve_id($row_id)
  {
    return self::get('reserve_id', $row_id)->getArray();
  }

  // get_by_id
  public static function all_by_reserve_id($row_id)
  {
    return self::get('reserve_id', $row_id)->resultArray();
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
    $table_name = Model::payment('table_name');
    // payment
    $insert_id = Model::payment('insert')->insert($table_name, $insertArray);
    // response
    if ($insert_id)
      self::logs('Yeni ödeme eklendi. ( Rezervasyon: ' . $insertArray['reserve_id'] . ')', $insert_id);
    return $insert_id ? true:false;
  }

  // update
  public static function update($payment_id, $updateArray = [])
  {
    // table_name
    $table_name = Model::payment('table_name');
    // update
    $db_response = Model::payment('update');
    if (is_array($updateArray)) :
      foreach ($updateArray as $key => $value)
        $db_response->set($key, $value);
    endif;
    $db_response->where('id', $payment_id)->update($table_name);
    // response
    if ($db_response)
      self::logs(($updateArray['reserve_id'] ?? $payment_id) . ' rezervasyon için ödeme bilgileri güncellendi.', $payment_id);
    return $db_response ? true:false;
  }

  // update
  public static function update_by_reserve_id($reserve_id, $updateArray = [])
  {
    // table_name
    $table_name = Model::payment('table_name');
    // update
    $db_response = Model::payment('update');
    if (is_array($updateArray)) :
      foreach ($updateArray as $key => $value)
        $db_response->set($key, $value);
    endif;
    $db_response->where('reserve_id', $reserve_id)->update($table_name);
    // response
    if ($db_response)
      self::logs(($updateArray['reserve_id'] ?? $reserve_id) . ' rezervasyon için ödeme bilgileri güncellendi.', $reserve_id);
    return $db_response ? true:false;
  }

  public static function count()
  {
    // table_name
    $table_name = Model::payment('table_name');
    return Model::payment('query')->count('id')->from($table_name)->getArray();
  }

  // delete
  public static function delete($payment_id)
  {
    // table_name
    $table_name = Model::payment('table_name');
    // delete
    $delete = Model::payment('delete')->where('id', intval($payment_id))->delete($table_name);
    if ($delete)
      self::logs("ID: $payment_id olan ödeme silindi", $payment_id);
    return $delete ? true:false;
  }

  // logs
  private static function logs($content, $meta_id = 0)
  {
    $insertArray = array(
      'table_name' => Model::payment('table_name'),
      'content'    => $content,
      'meta_id'    => $meta_id
    );
    \App\Models\LogsModel::add($insertArray);
  }
}
