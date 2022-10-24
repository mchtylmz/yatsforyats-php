<?php

namespace App;
use App\Config;
/**
 * Application Session
 *
 * PHP version 7.0
 */
class Session
{
  // Private
  private static $path  = 'site_app';
  private static $token = 'site_token';
  private static $user  = 'site_user';
  private static $sdir  = 'site';

  /*
	@ session regenerate id
	*/
	private static function regenerate()
	{
		@session_regenerate_id();
	}

  // Public
  /*
  @return true or false
  */
  public static function start()
  {
		self::$sdir = generate_permalink($_SERVER['HTTP_HOST']);
    return self::$sdir != 'site';
  }

  /*
  * Session is exists
  * @param session name
  * @param session path \ default path \ path and token
  * @return true or false
  */
  public static function status($name, $path = '')
  {
    /* Path name */
    if ($path == self::$token)
      $path = self::$token;
    else
      $path = self::$path;
    /* Return true or false */
    return isset($_SESSION[self::$sdir][$path][$name]);
  }

  /*
  * Session set value
  * @param session name *required
  * @param session value
  * @param session id change | default false
  * @return session value
  */
  public static function set($name, $value = '', $change = false)
  {
    // @param session id change | default false
    if ($change) self::regenerate();
    /*
    * @param session name
    * @param session value
    */
    return $_SESSION[self::$sdir][self::$path][$name] = $value;
  }

  /*
  * Session get value
  * @param session name *required
  * @return session value
  */
  public static function get($name)
  {
    return self::status($name) ? $_SESSION[self::$sdir][self::$path][$name]:false;
  }

  /*
  * Session set csrf token
  * @param session token name *required
  * @param session id change | default false
  * @return session token value
  */
  public static function set_token($change = false)
  {
    // @param session id change | default false
    if ($change == true) self::regenerate();
    /*
    * @param session name
    */
    $_SESSION[self::$sdir][self::$token]['time'] = time();
    $Token = sha1(md5(sha1(time() .'*' . Config::HASH . '*'. time())));
    return $_SESSION[self::$sdir][self::$token][Config::CSRF] = $Token;
  }

  /*
  * Session get token value
  * @param session name *required
  * @return session token value
  */
  public static function get_token()
  {
    return self::status(Config::CSRF, self::$token) ? $_SESSION[self::$sdir][self::$token][Config::CSRF]:null;
  }

  /*
  * Session check post token
  * @return true | false
  */
  public static function check_token()
  {
    // isset
    if(isset($_POST[Config::CSRF]) != true)
      return false;
    // return
    return self::get_token() == $_POST[Config::CSRF];
  }

  /*
  * Session delete token
  * @param session token name
  * @return true or false
  */
  public static function delete_token()
  {
    $_SESSION[self::$sdir][self::$token][Config::CSRF] = false;
	  unset($_SESSION[self::$sdir][self::$token][Config::CSRF]);
    return self::status(Config::CSRF, self::$token);
  }

  /*
  * Session delete
  * @param session name
  * @return true or false
  */
  public static function delete($name)
  {
    $_SESSION[self::$sdir][self::$path][$name] = false;
	  unset($_SESSION[self::$sdir][self::$path][$name]);
    return self::status($name);
  }

  /*
  * Session clear
  * @return true or false
  */
  public static function destroy()
  {
    error_reporting(0);
		unset($_SESSION[self::$sdir][self::$path]);
		unset($_SESSION[self::$sdir][self::$token]);
		$_SESSION[self::$sdir] = false;
		$_SESSION[self::$sdir] = array();
		unset($_SESSION[self::$sdir]);
    @session_unset();
		@session_destroy();
 		$_SESSION = array();
 		self::regenerate();
  }

  /*
  * Session check login
  * @param redirect true or false | default false
  * @return true or false
  */
  public static function check_login($redirect = false)
  {
    $check_login = self::status(self::$user);
    if ($redirect) {
      $url = $check_login ? Config::HOME_URL:Config::AUTH_URL . '/login';
      return redirect($url);
    }
    return $check_login;
  }

  /*
  * Session user permission
  * @return true or false
  */
  public static function permission($name, $primary = '', $secondary = '')
  {
    // role_type
    if (self::user('role_type') == '99') return '4';
    // empty $name
    if(!$name) return false;
    // permission exists
    if ($permissions = self::get(self::$user)['permissions']) :
      // $primary and $secondary not empty
      if ($primary) {
        // $secondary
        if ($secondary) {
          return isset($permissions[$name][$primary][$secondary]) ? intval($permissions[$name][$primary][$secondary]):false;
        } // $secondary
        return isset($permissions[$name][$primary]) ? intval($permissions[$name][$primary]):false;
      } // $primary
      return isset($permissions[$name]) ? intval($permissions[$name]):false;
    endif;
    // nothing
    return false;
  }

  /*
  * Session user info
  * @param name user info name
  * @param subname user info subname
  * @return user info string | array | int
  */
  public static function user($name = '', $subname = '')
  {
    // session name empty, return session name
    if($name == '')
     return self::$user;
    // user info
    $user = self::get(self::$user);
    // session subname empty, return session name value
    if($subname == '')
     return isset($user[$name]) ? $user[$name]:false;
    // session subname value
    return isset($user[$name][$subname]) ? $user[$name][$subname]:false;
  }

  /*
  * Session alert
  * @param type string
  * @param message string
  * @param link url \ string
  * @return alert redirect link
  */
  public static function alert($type = 'default', $message = '', $link = '')
  {
    // link
    if (substr($link, 0, 1) == '/') $link = Config::admin_url . Config::PATH_URL . $link;
    // Session set alert
    $_SESSION['alert']['type'] = strval($type);
		$_SESSION['alert']['message'] = strval($message);
		return $_SESSION['alert']['link'] = $link;
  }
}
