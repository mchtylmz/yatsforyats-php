<?php
namespace App\Models;

use \Core\Model;
use \App\Config;
use \App\Session;
// \App\Models\LogsModel
/**
 * Example RegionModel
 *
 * PHP version 7.1
 */
class RegionModel
{
  // columns
  private static $columns = '*';

  // all
  public static function all($limit = null)
  {
    $yacht_table = Model::yacht('table_name');
    $all = Model::regions(self::$columns . ', (SELECT COUNT(*) FROM '.$yacht_table.' WHERE yc_region_id = regions.id) AS yacht_count')->orderby('yacht_count', 'DESC');
    if ($limit) {
      $all->limit(0, intval($limit));
    }
    $result = $all->resultArray();
    return $result;
  }

  // get
  public static function get($column, $value)
  {
    return Model::regions(self::$columns)->where($column, $value);
  }

  // get_by_id
  public static function get_by_id($region_id)
  {
    return self::get('id', $region_id)->getArray();
  }

  // search
  public static function search($word, $id = 0)
  {
    // all
    $region = Model::regions('*')->like('tr_title', $word)->orLike('en_title', $word);
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
    $table_name = Model::regions('table_name');
    // region
    $insert_id = Model::regions('insert')->insert($table_name, $insertArray);
    // response
    if ($insert_id)
      self::logs('Yeni bölge eklendi. (' . $insertArray['tr_title'] . ')', $insert_id);
    return $insert_id ? true:false;
  }

  // update
  public static function update($region_id, $updateArray = [])
  {
    // table_name
    $table_name = Model::regions('table_name');
    // update
    $db_response = Model::regions('update');
    if (is_array($updateArray)) :
      foreach ($updateArray as $key => $value)
        $db_response->set($key, $value);
    endif;
    $db_response->where('id', $region_id)->update($table_name);
    // response
    if ($db_response)
      self::logs(($updateArray['tr_title'] ?? $region_id) . ' bölge bilgileri güncellendi.', $region_id);
    return $db_response ? true:false;
  }

  public static function count()
  {
    // table_name
    $table_name = Model::regions('table_name');
    return Model::regions('query')->count('id')->from($table_name)->getArray();
  }

  // delete
  public static function delete($region_id)
  {
    // table_name
    $table_name = Model::regions('table_name');
    // delete
    $delete = Model::regions('delete')->where('id', intval($region_id))->delete($table_name);
    if ($delete)
      self::logs("ID: $region_id olan bölge silindi", $region_id);
    return $delete ? true:false;
  }

  // logs
  private static function logs($content, $meta_id = 0)
  {
    $insertArray = array(
      'table_name' => Model::regions('table_name'),
      'content'    => $content,
      'meta_id'    => $meta_id
    );
    \App\Models\LogsModel::add($insertArray);
  }
}
