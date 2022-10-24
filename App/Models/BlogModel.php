<?php
namespace App\Models;

use \Core\Model;
use \App\Config;
use \App\Session;

// \App\Models\LogsModel
/**
 * Example BlogModel
 *
 * PHP version 7.1
 */
class BlogModel
{
  // columns
  private static $columns = '*';

  // all
  public static function all($limit = null)
  {
    $all = Model::blog(self::$columns)->orderby('b_added', 'DESC');
    if ($limit) {
      $all->limit(0, intval($limit));
    }
    $result = $all->resultArray();
    return $result;
  }

  public static function filter($limit = null)
  {
    if (intval(get('page')) > 0) {
      $page = intval(get('page'));
    } elseif (intval(get('sayfa')) > 0) {
      $page = intval(get('sayfa'));
    } else {
      $page = 1;
    }
    $limit = $limit ?? 12;
    if ($limit == 150) $page = 1;

    $all = Model::blog()->where('b_added', '<=', date('Y-m-d H:i:s'))->orderby('b_added', 'DESC');

    $totalCount = Model::query($all->getSqlSelect()['query'], $all->getSqlSelect()['value'], 5);

    // return
    return [
      'blogs' => $all->limit(($page - 1) * $limit, intval($limit))->resultArray(),
      'total'  => is_array($totalCount) ? count($totalCount):$totalCount,
      'limit'  => $limit ?? 9,
      'page'   => $page
    ];
  }

  // get
  public static function get($column, $value)
  {
    return Model::blog(self::$columns)->where($column, $value);
  }

  // get_by_id
  public static function get_by_id($blog_id)
  {
    return self::get('b_id', $blog_id)->getArray();
  }

  // search
  public static function search($word, $id = 0)
  {
    // all
    $region = Model::blog('*')->like('b_title_tr', $word)->orLike('b_title_en', $word);
    if ($id) {
      $region->where('b_id', '!=', intval($id));
    }
    // return
    return $results = $region->resultArray();
  }

  // exists
  public static function exists($column, $value)
  {
    return self::get($column, $value)->getArray();
  }

  public static function count()
  {
    // table_name
    $table_name = Model::blog('table_name');
    return Model::blog('query')->count('b_id')->from($table_name)->getArray();
  }

  public static function count_where($column, $value)
  {
    // table_name
    $table_name = Model::blog('table_name');
    return Model::blog('query')->count('b_id')->from($table_name)->where($column, $value)->getArray();
  }

  // logs
  private static function logs($content, $meta_id = 0)
  {
    $insertArray = array(
      'table_name' => Model::blog('table_name'),
      'content'    => $content,
      'meta_id'    => $meta_id
    );
    \App\Models\LogsModel::add($insertArray);
  }
}
