<?php

namespace App\Models;

use \Core\Model;

/**
 * Example Settings model
 *
 * PHP version 7.1
 */
class SettingsModel
{
  // columns
  private static $columns = 'id, name, value';

  // Google reCAPTCHA
  public static function reCAPTCHA()
  {
    return array(
      'status'      => self::get_single('recaptcha_status', 'off'),
      'site_key'    => self::get_single('recaptcha_site_key'),
      'site_secret' => self::get_single('recaptcha_site_secret'),
    );
  }

  // get_cache
  public static function get_cache($name)
  {
    // cache
    if (isset($_SESSION['settings'][$name]) == true)
      return $_SESSION['settings'][$name];
    // db where
    return $_SESSION['settings'][$name] = self::get($name);
  }

  // save
  public static function save($name, $value = '')
  {
    // table_name
    $table_name = Model::settings('table_name');
    // exists
    $is_setting = self::get_row($name);
    if ($is_setting) {
      // update
      $setting_id = Model::settings('update')->set('value', $value)
      ->where('id', $is_setting['id'])
      ->where('name', $name)
      ->update($table_name);
    } else {
      // insert
      $setting_id = Model::settings('insert')->insert($table_name, [
        'name'  => $name,
        'value' => $value
      ]);
    } // not exists setting
    if ($setting_id)
      self::logs('Ayarlarda değişiklik yapıldı. (' . $name . ' => ' . $value . ')');
    // unset session
    if(isset($_SESSION['settings']) == true)
      unset($_SESSION['settings']);
    return $setting_id ? true:false;
  }

  // get
  public static function get($name, $default = null)
  {
    return self::get_single($name, $default);
  }

  // get setting single data
  private static function get_single($name, $default = null)
  {
    $setting = self::get_row($name);
    return $setting ? $setting['value']:$default;
  }

  // get settings row
  private static function get_row($name, $default = [])
  {
    $settings = Model::settings(self::$columns)->where('name', $name)->getArray();
    return $settings ? $settings:$default;
  }

  // logs
  private static function logs($content)
  {
    $insertArray = array(
      'table_name' => Model::settings('table_name'),
      'content'    => $content
    );
    return \App\Models\LogsModel::add($insertArray);
  }
}
