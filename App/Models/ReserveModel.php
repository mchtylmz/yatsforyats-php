<?php
namespace App\Models;

use \Core\Model;
use \App\Config;
use \App\Session;
// \App\Models\LogsModel
/**
 * Example ReserveModel
 *
 * PHP version 7.1
 */
class ReserveModel
{
  // columns
  private static $columns = '*';

  // all
  public static function all($limit = null)
  {
    $all = Model::reserve(self::$columns)->orderby('id', 'DESC');
    if ($limit) {
      $all->limit(0, intval($limit));
    }
    $result = $all->resultArray();
    return $result;
  }

  // get
  public static function get($column, $value)
  {
    return Model::reserve(self::$columns)->where($column, $value);
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

  // get_by_id
  public static function get_reserve_date_by_yacht_id($id)
  {
    $tarihler = [];
    $all = Model::reserve('start_date, end_date')
    ->where('yacht_id', intval($id))
    ->where('status', '!=', 'iptal_edildi')
    ->where('status', '!=', 'musteri_vazgecti')
    ->where('start_date', '>=', date('Y-m-d 00:00:00'))
    ->orderby('id', 'DESC');
    $result = $all->resultArray();
    if ($result) {
      foreach ($result as $key => $row) {
        $Baslangic_TRH = strtotime($row['start_date']); // başlangıç tarihi
        $Bitis_TRH   = strtotime($row['end_date']);	// bitiş tarihi
        for ($i = $Baslangic_TRH; $i <= $Bitis_TRH; $i = $i + 86400) {
            $tarihler[] = [
              'date' => date('Y-m-d', $i),
              'badge' => false,
              'classname' => 'rezervasyon_var'
            ];
        } // for
      } // foreach
    } // if
    return $tarihler;
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
    $table_name = Model::reserve('table_name');
    // reserve
    $insert_id = Model::reserve('insert')->insert($table_name, $insertArray);
    // response
    if ($insert_id)
      self::logs('Yeni rezervasyon eklendi. ( Rezervasyon: ' . $insertArray['yacht_title'] . ')', $insert_id);
    return $insert_id ? true:false;
  }

  // update
  public static function update_by_row_id($row_id, $updateArray = [])
  {
    // table_name
    $table_name = Model::reserve('table_name');
    // update
    $db_response = Model::reserve('update');
    if (is_array($updateArray)) :
      foreach ($updateArray as $key => $value)
        $db_response->set($key, $value);
    endif;
    $db_response->where('row_id', $row_id)->update($table_name);
    // response
    if ($db_response)
      self::logs($row_id . ' rezervasyon bilgileri güncellendi.', $row_id);
    return $db_response ? true:false;
  }

  // update
  public static function update($reserve_id, $updateArray = [])
  {
    // table_name
    $table_name = Model::reserve('table_name');
    // update
    $db_response = Model::reserve('update');
    if (is_array($updateArray)) :
      foreach ($updateArray as $key => $value)
        $db_response->set($key, $value);
    endif;
    $db_response->where('id', $reserve_id)->update($table_name);
    // response
    if ($db_response)
      self::logs(($updateArray['yacht_title'] ?? $reserve_id) . ' rezervasyon bilgileri güncellendi.', $reserve_id);
    return $db_response ? true:false;
  }

  public static function count()
  {
    // table_name
    $table_name = Model::reserve('table_name');
    return Model::reserve('query')->count('id')->from($table_name)->getArray();
  }

  // delete
  public static function delete($reserve_id)
  {
    // table_name
    $table_name = Model::reserve('table_name');
    // delete
    $delete = Model::reserve('delete')->where('id', intval($reserve_id))->delete($table_name);
    if ($delete)
      self::logs("ID: $reserve_id olan rezervasyon silindi", $reserve_id);
    return $delete ? true:false;
  }

  // logs
  private static function logs($content, $meta_id = 0)
  {
    $insertArray = array(
      'table_name' => Model::reserve('table_name'),
      'content'    => $content,
      'meta_id'    => $meta_id
    );
    \App\Models\LogsModel::add($insertArray);
  }
}
