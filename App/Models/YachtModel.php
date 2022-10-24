<?php
namespace App\Models;

use \Core\Model;
use \App\Config;
use \App\Session;

// \App\Models\LogsModel
/**
 * Example YachtModel
 *
 * PHP version 7.1
 */
class YachtModel
{
  // columns
  private static $columns = '*';

  public static function all_buy_yachts()
  {
    if (intval(get('page')) > 0) {
      $page = intval(get('page'));
    } elseif (intval(get('sayfa')) > 0) {
      $page = intval(get('sayfa'));
    } else {
      $page = 1;
    }
    $limit = $limit ?? 9;
    if ($limit == 150) $page = 1;

    $all = Model::yacht()->where('yc_status', 'sale')->where('yc_bought', '0')->orderby('yc_order', 'DESC')->orderby('yc_id', 'DESC');
    $totalCount = Model::query($all->getSqlSelect()['query'], $all->getSqlSelect()['value'], 5);

    return [
      'yachts' => $all->limit(($page - 1) * $limit, intval($limit))->resultArray(),
      'total'  => is_array($totalCount) ? count($totalCount):$totalCount,
      'limit'  => $limit ?? 9,
      'page'   => $page
    ];
  }
  // all
  public static function all($limit = null, $status = 'rent')
  {
    $all = Model::yacht(self::$columns)->orderby('yc_order', 'DESC')->orderby('yc_id', 'DESC');
    if ($status) {
      $all->where('yc_status', $status);
    }
    if ($limit) {
      $all->limit(0, intval($limit));
    }
    $result = $all->resultArray();
    return $result;
  }

  // all
  public static function all_home($limit = null, $status = 'rent')
  {
    $all = Model::yacht(self::$columns)->where('yc_home', '1')->orderby('yc_order', 'DESC')->orderby('yc_id', 'DESC');
    if ($status) {
      $all->where('yc_status', $status);
    }
    if ($limit) {
      $all->limit(0, intval($limit));
    }
    $result = $all->resultArray();
    return $result;
  }

  public static function filter($region = null, $person = null, $type = null, $limit = null, $status = 'rent')
  {
    if (intval(get('page')) > 0) {
      $page = intval(get('page'));
    } elseif (intval(get('sayfa')) > 0) {
      $page = intval(get('sayfa'));
    } else {
      $page = 1;
    }
    $limit = $limit ?? 9;
    if ($limit == 150) $page = 1;

    $all = Model::yacht();
    if ($status) {
      $all->where('yc_status', $status);
    }
    if ($region) {
      $all->where('yc_region_id', intval($region ?? 0));
    }
    if ($person) {
      $all->where('yc_guests', '>=', intval($person ?? 0));
    }
    if ($type) {
      $all->where('yc_type_id', intval($type ?? 0));
    }
    $all->orderby('yc_order', 'DESC')->orderby('yc_id', 'DESC');

    $totalCount = Model::query($all->getSqlSelect()['query'], $all->getSqlSelect()['value'], 5);

    // return
    return [
      'yachts' => $all->limit(($page - 1) * $limit, intval($limit))->resultArray(),
      'total'  => is_array($totalCount) ? count($totalCount):$totalCount,
      'limit'  => $limit ?? 9,
      'page'   => $page
    ];
  }

  // all
  public static function all_type($limit = null)
  {
    /*
    $all = Model::yacht_type('*')->orderby('type_id', 'DESC');
    $result = $all->resultArray();
    */
    $results = Model::query(
      "SELECT yacht_type.* FROM `yacht_type` INNER JOIN yachts ON yachts.yc_type_id = yacht_type.type_id GROUP BY yacht_type.type_id"
    );
    return $results;
  }

  // all
  public static function all_extra($limit = null)
  {
    $all = Model::yacht_extra('*')->orderby('ex_id', 'DESC');
    $result = $all->resultArray();
    return $result;
  }

  // get
  public static function get($column, $value)
  {
    return Model::yacht(self::$columns)->where($column, $value);
  }

  // get_by_id
  public static function get_by_id($yacht_id)
  {
    return self::get('yc_id', $yacht_id)->getArray();
  }

  // get_by_id
  public static function get_by_yacht_id($yacht_id)
  {
    $all = Model::yacht_extra('*')->where('yacht_id', $yacht_id);
    $result = $all->getArray();
    return $result;
  }

  // get_by_id
  public static function get_extras_by_yacht_id($yacht_id)
  {
    $all = Model::yacht_extra('*')->where('yacht_id', $yacht_id);
    $result = $all->getArray();
    return $result;
  }

  // get_by_id
  public static function get_type_by_id($id)
  {
    $all = Model::yacht_type('*')->where('type_id', $id);
    $result = $all->getArray();
    return $result;
  }

  // get_by_id
  public static function get_gallery_by_id($id)
  {
    $all = Model::yacht_gallery('*')->where('gallery_id', $id);
    $result = $all->getArray();
    return $result;
  }

  // get_by_id
  public static function get_gallery_by_yacht_id($yacht_id)
  {
    $all = Model::yacht_gallery('*')->where('yacht_id', $yacht_id);
    $result = $all->resultArray();
    return $result;
  }

  // get_by_id
  public static function get_feature_by_yacht_id($yacht_id)
  {
    $all = Model::yacht_feature('*')->where('yacht_id', $yacht_id);
    $result = $all->resultArray();
    return $result;
  }

  // search
  public static function search($word, $id = 0, $status = 'rent')
  {
    // all
    $region = Model::yacht('*')->like('yc_title_tr', $word)->orLike('yc_title_en', $word);
    if ($id) {
      $region->where('yc_id', '!=', intval($id));
    }
    if ($status) {
      $region->where('yc_status', $status);
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
    $table_name = Model::yacht('table_name');
    // region
    $insert_id = Model::yacht('insert')->insert($table_name, $insertArray);
    // response
    if ($insert_id)
      self::logs('Yeni yat eklendi. (' . $insertArray['yc_title_tr'] . ')', $insert_id);
    return intval($insert_id ?? 0);
  }

  // add
  public static function add_type($insertArray = [])
  {
    // table_name
    $table_name = Model::yacht_type('table_name');
    // region
    $insert_id = Model::yacht_type('insert')->insert($table_name, $insertArray);
    // response
    if ($insert_id)
      self::logs('Yeni yat türü eklendi. (' . $insertArray['type_title_tr'] . ')', $insert_id);
    return intval($insert_id ?? 0);
  }

  // add
  public static function add_extra($insertArray = [])
  {
    // table_name
    $table_name = Model::yacht_extra('table_name');
    // region
    $insert_id = Model::yacht_extra('insert')->insert($table_name, $insertArray);
    // response
    if ($insert_id)
      self::logs('Yeni yat ek özelliği eklendi.', $insert_id);
    return intval($insert_id ?? 0);
  }

  // add
  public static function add_gallery($insertArray = [])
  {
    // table_name
    $table_name = Model::yacht_gallery('table_name');
    // region
    $insert_id = Model::yacht_gallery('insert')->insert($table_name, $insertArray);
    // response
    if ($insert_id)
      self::logs('Yeni yat ek resim eklendi. (' . $insertArray['gallery_file'] . ')', $insert_id);
    return intval($insert_id ?? 0);
  }

  // add
  public static function add_feature($insertArray = [])
  {
    // table_name
    $table_name = Model::yacht_feature('table_name');
    // region
    $insert_id = Model::yacht_feature('insert')->insert($table_name, $insertArray);
    // response
    if ($insert_id)
      self::logs('Yeni yat öne çıkan özellik eklendi. (' . $insertArray['feature_title_tr'] . ')', $insert_id);
    return intval($insert_id ?? 0);
  }

  // update
  public static function update($yacht_id, $updateArray = [])
  {
    // table_name
    $table_name = Model::yacht('table_name');
    // update
    $db_response = Model::yacht('update');
    if (is_array($updateArray)) :
      foreach ($updateArray as $key => $value)
        $db_response->set($key, $value);
    endif;
    $db_response->where('yc_id', $yacht_id)->update($table_name);
    // response
    if ($db_response)
      self::logs(($updateArray['yc_title_tr'] ?? $yacht_id) . ' yat bilgileri güncellendi.', $yacht_id);
    return $db_response ? true:false;
  }

  // update
  public static function update_extra($yacht_id, $updateArray = [])
  {
    // table_name
    $table_name = Model::yacht_extra('table_name');
    // update
    $db_response = Model::yacht_extra('update');
    if (is_array($updateArray)) :
      foreach ($updateArray as $key => $value)
        $db_response->set($key, $value);
    endif;
    $db_response->where('yacht_id', $yacht_id)->update($table_name);
    // response
    if ($db_response)
      self::logs(($updateArray['yacht_id'] ?? $yacht_id) . ' yat ek özellik bilgileri güncellendi.', $yacht_id);
    return $db_response ? true:false;
  }

  // update
  public static function update_feature($id, $updateArray = [])
  {
    // table_name
    $table_name = Model::yacht_feature('table_name');
    // update
    $db_response = Model::yacht_feature('update');
    if (is_array($updateArray)) :
      foreach ($updateArray as $key => $value)
        $db_response->set($key, $value);
    endif;
    $db_response->where('feature_id', $id)->update($table_name);
    // response
    if ($db_response)
      self::logs(($updateArray['feature_title_tr'] ?? $id) . ' ek özellik bilgileri güncellendi.', $id);
    return $db_response ? true:false;
  }

  // update
  public static function update_type($id, $tr_title, $en_title)
  {
    // table_name
    $table_name = Model::yacht_type('table_name');
    // update
    $db_response = Model::yacht_type('update');
    $db_response->set('type_title_tr', $tr_title);
    $db_response->set('type_title_en', $en_title);
    $db_response->where('type_id', $id)->update($table_name);
    // response
    if ($db_response)
      self::logs(($updateArray['type_title_tr'] ?? $id) . ' yat türü bilgileri güncellendi.', $id);
    return $db_response ? true:false;
  }

  public static function count($status = 'rent')
  {
    // table_name
    $table_name = Model::yacht('table_name');
    $query = Model::yacht('query')->count('yc_id')->from($table_name);
    if ($status) {
      $query->where('yc_status', $status);
    }
    return $query->getArray();
  }

  public static function count_where($column, $value, $status = 'rent')
  {
    // table_name
    $table_name = Model::yacht('table_name');
    $query = Model::yacht('query')->count('yc_id')->from($table_name)->where($column, $value);
    if ($status) {
      $query->where('yc_status', $status);
    }
    return $query->getArray();
  }

  // delete
  public static function delete($yacht_id)
  {
    // table_name
    $table_name = Model::yacht('table_name');
    // delete
    $delete = Model::yacht('delete')->where('yc_id', intval($yacht_id))->delete($table_name);
    if ($delete)
      self::logs("ID: $yacht_id olan yat silindi", $yacht_id);
    return $delete ? true:false;
  }

  // delete
  public static function delete_type($id)
  {
    // table_name
    $table_name = Model::yacht_type('table_name');
    // delete
    $delete = Model::yacht_type('delete')->where('type_id', intval($id))->delete($table_name);
    if ($delete)
      self::logs("ID: $id olan yat türü silindi", $id);
    return $delete ? true:false;
  }

  // delete
  public static function delete_extra($yacht_id)
  {
    // table_name
    $table_name = Model::yacht_extra('table_name');
    // delete
    $delete = Model::yacht_extra('delete')->where('yacht_id', intval($yacht_id))->delete($table_name);
    if ($delete)
      self::logs("ID: $yacht_id olan ek yat özelliği silindi", $yacht_id);
    return $delete ? true:false;
  }

  // delete
  public static function delete_gallery($id)
  {
    $gallery = self::get_gallery_by_id($id);
    // table_name
    $table_name = Model::yacht_gallery('table_name');
    // delete
    $delete = Model::yacht_gallery('delete')->where('gallery_id', intval($id))->delete($table_name);
    if ($delete) {
      if ($gallery) {
        $filename = Config::UPLOAD_PATH . $gallery['gallery_file'];
        if (file_exists($filename)) {
          @unlink($filename);
        }
      }
      self::logs("ID: $id olan ek resim silindi", $id);
    }
    return $delete ? true:false;
  }

  // delete
  public static function delete_feature($id)
  {
    // table_name
    $table_name = Model::yacht_feature('table_name');
    // delete
    $delete = Model::yacht_feature('delete')->where('feature_id', intval($id))->delete($table_name);
    if ($delete)
      self::logs("ID: $id olan ek öne çıkan özellik silindi", $id);
    return $delete ? true:false;
  }

  // logs
  private static function logs($content, $meta_id = 0)
  {
    $insertArray = array(
      'table_name' => Model::yacht('table_name'),
      'content'    => $content,
      'meta_id'    => $meta_id
    );
    \App\Models\LogsModel::add($insertArray);
  }
}
