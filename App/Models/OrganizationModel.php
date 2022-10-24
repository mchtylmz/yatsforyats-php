<?php
namespace App\Models;

use \Core\Model;
use \App\Config;
use \App\Session;
// \App\Models\LogsModel
/**
 * Example OrganizationModel
 *
 * PHP version 7.1
 */
class OrganizationModel
{
  // columns
  private static $columns = '*';

  // all
  public static function all($limit = null)
  {
    $all = Model::organization(self::$columns)->orderby('id', 'DESC');
    if ($limit) {
      $all->limit(0, intval($limit));
    }
    $result = $all->resultArray();
    return $result;
  }

  // get
  public static function get($column, $value)
  {
    return Model::organization(self::$columns)->where($column, $value);
  }

  // get_by_id
  public static function get_by_id($organization_id)
  {
    return self::get('id', $organization_id)->getArray();
  }

  // search
  public static function search($word, $id = 0)
  {
    // all
    $region = Model::organization('*')->like('tr_title', $word)->orLike('en_title', $word);
    if ($id) {
      $region->where('id', '!=', intval($id));
    }
    // return
    return $results = $region->resultArray();
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
    $table_name = Model::organization('table_name');
    // region
    $insert_id = Model::organization('insert')->insert($table_name, $insertArray);
    // response
    if ($insert_id)
      self::logs('Yeni organizasyon eklendi. (' . $insertArray['tr_title'] . ')', $insert_id);
    return $insert_id ? true:false;
  }

  // update
  public static function update($organization_id, $updateArray = [])
  {
    // table_name
    $table_name = Model::organization('table_name');
    // update
    $db_response = Model::organization('update');
    if (is_array($updateArray)) :
      foreach ($updateArray as $key => $value)
        $db_response->set($key, $value);
    endif;
    $db_response->where('id', $organization_id)->update($table_name);
    // response
    if ($db_response)
      self::logs(($updateArray['tr_title'] ?? $organization_id) . ' organizasyon bilgileri güncellendi.', $organization_id);
    return $db_response ? true:false;
  }

  public static function count()
  {
    // table_name
    $table_name = Model::organization('table_name');
    return Model::organization('query')->count('id')->from($table_name)->getArray();
  }

  // delete
  public static function delete($organization_id)
  {
    // table_name
    $table_name = Model::organization('table_name');
    // delete
    $delete = Model::organization('delete')->where('id', intval($organization_id))->delete($table_name);
    if ($delete)
      self::logs("ID: $organization_id olan organizasyon silindi", $organization_id);
    return $delete ? true:false;
  }

  // logs
  private static function logs($content, $meta_id = 0)
  {
    $insertArray = array(
      'table_name' => Model::organization('table_name'),
      'content'    => $content,
      'meta_id'    => $meta_id
    );
    \App\Models\LogsModel::add($insertArray);
  }
}
