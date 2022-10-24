<?php

use \App\Session;
use \App\Config;
use App\Models\YachtModel;
use App\Models\SettingsModel;

use \WriteiniFile\WriteiniFile;
use \WriteiniFile\ReadiniFile;

/** ----------------------------------------------- **/
/** ------------- REQUEST FUNCTIONS --------------- **/
/** ----------------------------------------------- **/

/**
* Post, Get, Request basic security
* @param string $_POST
*/
// Functions
function form_filter($post)
{
  return is_array($post) ? array_map('form_filter', $post) : htmlspecialchars(str_replace("\xc2\xa0", '', trim($post)), ENT_QUOTES, 'UTF-8');
}
$_POST = array_map('form_filter', $_POST);
function post($name, $subname = null)
{
	if ($subname !== null) {
		if (isset($_POST[$name][$subname]))
	      return $_POST[$name][$subname];
	}
	if (isset($_POST[$name]))
      return $_POST[$name];
}
$_GET = array_map('form_filter', $_GET);
function get($name)
{
  if (isset($_GET[$name]))
      return $_GET[$name];
}
$_REQUEST = array_map('form_filter', $_REQUEST);
function request($name, $subname = null)
{
  if ($subname !== null) {
		if (isset($_REQUEST[$name][$subname]))
	      return $_REQUEST[$name][$subname];
	}
  if (isset($_REQUEST[$name]))
      return $_REQUEST[$name];
}

// Default site language
if ( ! function_exists('allow_method') ) {
  /**
  * allow form method
  * @param string $method post|get|put|delete
  */
  function allow_method($method = 'GET')
  {
    return strtoupper($_SERVER['REQUEST_METHOD']) == strtoupper($method);
  }
}

// Ziraat Banka Ayarlar
if ( ! function_exists('ziraat_input_settings') ) {
  /**
  * ziraat_input_settings
  */
  function ziraat_input_settings($data = [])
  {

    $data['pos_url'] = 'https://sanalpos2.ziraatbank.com.tr/fim/est3Dgate';
    $data['client_id'] = site_setting('pos_client_id');
    $data['store_type'] = site_setting('pos_store_type');
    $data['store_key'] = site_setting('pos_store_key');

    $data['amount'] = floatval($data['amount'] ?? 0);
    // $data['taksit'] = '';
    // $data['islem_tipi'] = 'Auth';
    $data['success_url'] = site_url() . 'payment/control/' . @$data['pay_id'] . '/RI' . @$data['pay_row_id'];
    $data['error_url'] = site_url() . 'payment/control/' . @$data['pay_id'] . '/RI' . @$data['pay_row_id'];
    $data['siparis_no']  = implode('#', [
      date('YmdHi', strtotime($data['created_at'] ?? date('Y-m-d H:i'))),
      $data['pay_row_id'] ?? 0
    ]);
    $data['rnd'] = microtime();
    // ZORUNLU DEĞERLER
    // hash
    /*
    $hash_str = $data['client_id'].$data['siparis_no'].$data['amount'].$data['success_url'].$data['error_url'].microtime().$data['store_key'];
    $data['hash'] = base64_encode(pack('H*', sha1($hash_str)));
    //
    $hashstr = $clientId . $oid . $amount . $okUrl . $failUrl . $rnd  . $storekey;
    */
    $hash_string = $data['client_id'] . $data['siparis_no'] . $data['amount'] . $data['success_url'] . $data['error_url'] . $data['rnd'] . $data['store_key'];
    $data['hash'] = base64_encode(pack('H*', sha1($hash_string)));
    // hash
    // İSTEĞE BAĞLI DEĞERLER
    $data['lang']         = get_language();
    $data['currency']     = $data['pay_currency'] ?? '949';
    $data['firma_adi']    = site_setting('site_title_tr');
    $data['f_isim']       = $data['reserve_fullname'] ?? '-';
    $data['f_adres']      = '';
    $data['f_il']         = '';
    $data['f_ilce']       = '';
    $data['f_ulke']       = 'TR';
    $data['f_posta_kodu'] = '34010';
    $data['f_nakliye']    = site_setting('site_title_tr');
    $data['telefon']      = $data['reserve_phone'] ?? '-';
    $data['email']        = $data['reserve_email'] ?? '-';
    $data['t_isim']       = $data['reserve_fullname'] ?? '-';
    $data['t_adres']      = '';
    $data['t_il']         = '';
    $data['t_ilce']       = '';
    $data['t_ulke']       = 'TR';
    $data['t_posta_kodu'] = '34010';
    $data['item_number']  = $data['pay_row_id'];
    $data['product_code'] = $data['pay_id'];
    $data['qty']          = 1;
    $data['desc']         = '';
    $data['price']        = floatval($data['amount'] ?? 0);
    $data['total']        = floatval($data['amount'] ?? 0) * 1;
    $data['id']           = intval($data['pay_id'] ?? 0);
    $data['row_id']       = intval($data['pay_row_id'] ?? 0);
    $data['is_active']    = 'user_offline';
    $data['user_active']  = 0;
    $data['customer_code']= $data['pay_id'];
    // İSTEĞE BAĞLI DEĞERLER
    // RETURN
    return $data;
  }
}

/** ----------------------------------------------- **/
/** ------------- LANGUAGE FUNCTIONS -------------- **/
/** ----------------------------------------------- **/
// get site language
if ( ! function_exists('get_language') ) {
  /**
  * Translate for db
  * @param string $key translate key
  */
  function get_language()
  {
    $lang = 'tr';
    if ($slang = Session::get('language')) {
      return $slang;
    }
    if ($clang = get_cookie('language')) {
      return $clang;
    }
    return $lang;
  }
}

// get site language
if ( ! function_exists('write_save_translate') ) {
  /**
  * Translate for db
  * @param string $key translate key
  */
  function write_save_translate($lang)
  {
    $file = new WriteiniFile(__DIR__ . "/Languages/words.php");
  	$file->create($lang)->write();
    return file_exists(__DIR__ . "/Languages/words.php");
  }
}

// get site language
if ( ! function_exists('read_translate') ) {
  /**
  * Translate for db
  * @param string $key translate key
  */
  function read_translate($word, $lang = null)
  {
    if (!$lang) {
      $lang = get_language();
    }
    if (file_exists(__DIR__ . "/Languages/words.php")) {
      $translates = ReadiniFile::get(__DIR__ . "/Languages/words.php");
      return $translates[$lang][$word] ?? '';
    }
    return '';
  }
}

// get site language
if ( ! function_exists('available_language') ) {
  /**
  * Translate
  */
  function available_language()
  {
    return Config::LANGUAGES;
  }
}


// Default site language
if ( ! function_exists('site_language') ) {
  /**
  * Translate for db
  * @param string $key translate key
  */
  function site_language($key = 'tr')
  {
    $lang = get_language();
    if(!$lang) {
      set_cookie('language', mb_strtolower($key));
      return Session::set('language', mb_strtolower($key));
    }
  	if ($lang != $key) {
      set_cookie('language', mb_strtolower($key));
      return Session::set('language', mb_strtolower($key));
  	}
    return $lang;
  }
}

// Default site language
if ( ! function_exists('detect_language') ) {
  /**
  * Translate for db
  * @param string $key translate key
  */
  function detect_language($route = [])
  {
    // Language
    if (isset($route['lang']) == true) {
      site_language($route['lang'] == 'en' ? 'en':($route['lang'] == 'ru' ? 'ru':'tr'));
    } elseif ($lang = get_language()) {
      site_language(get_language());
    } else {
      site_language(site_setting('default_language'));
    }
    // Language
    // rota
    $current_url = $_SERVER['QUERY_STRING'] ?? $key;
    if (strpos($current_url, 'odeme-sonucu') !== false) {
      site_language('tr');
    }
    if (strpos($current_url, 'pay-response') !== false) {
      site_language('ru');
    }
    if (strpos($current_url, 'payment-result') !== false) {
      site_language('en');
    }
  }
}

// Default site language
if ( ! function_exists('lang_text') ) {
  /**
  * Translate for db
  * @param string $key translate key
  */
  function lang_text($tr, $en, $ru = '')
  {
    // Language
    if (get_language() == 'en') {
      return $en;
    }
    if (get_language() == 'ru') {
      return $ru ? $ru:$en;
    }
    return $tr;
    // Language
  }
}

// Default site language
if ( ! function_exists('change_lang') ) {
  /**
  * Translate for db
  */
  function change_lang($key = null)
  {
    if (!$key) $key = get_language();
    if (!$_SERVER['QUERY_STRING']) return $key;
    $current_url = $_SERVER['QUERY_STRING'] ?? $key;
    // key
    if ($key == 'en') {
      if (strpos($current_url, 'anasayfa') !== false) {
        $old = 'anasayfa';
        $new = 'home';
      }
      if (strpos($current_url, 'hakkimizda') !== false) {
        $old = 'hakkimizda';
        $new = 'about';
      }
      if (strpos($current_url, 'iletisim') !== false) {
        $old = 'iletisim';
        $new = 'contact';
      }
      if (strpos($current_url, 'yatlar') !== false) {
        $old = 'yatlar';
        $new = 'yachts';
      }
      if (strpos($current_url, 'satilik/yatlar') !== false) {
        $old = 'satilik/yatlar';
        $new = 'sale/yachts';
      }
      if (strpos($current_url, 'odeme') !== false) {
        $old = 'odeme';
        $new = 'payment';
      }
      if (strpos($current_url, 'odeme-sonucu') !== false) {
        $old = 'odeme-sonucu';
        $new = 'payment-result';
      }
    } // tr
    else {
      if (strpos($current_url, 'home') !== false) {
        $old = 'home';
        $new = 'anasayfa';
      }
      if (strpos($current_url, 'about') !== false) {
        $old = 'about';
        $new = 'hakkimizda';
      }
      if (strpos($current_url, 'contact') !== false) {
        $old = 'contact';
        $new = 'iletisim';
      }
      if (strpos($current_url, 'yachts') !== false) {
        $old = 'yachts';
        $new = 'yatlar';
      }
      if (strpos($current_url, 'sale/yachts') !== false) {
        $old = 'sale/yachts';
        $new = 'satilik/yatlar';
      }
      if (strpos($current_url, 'payment') !== false) {
        $old = 'payment';
        $new = 'odeme';
      }
      if (strpos($current_url, 'payment-result') !== false) {
        $old = 'payment-result';
        $new = 'odeme-sonucu';
      }
    } // en
    // change
    $current_url = str_replace($old ?? '', $new ?? '', $current_url);
    // return
    return str_replace(get_language(), $key == 'en' ? 'en':'tr', $current_url);
  }
}


// default_language
if ( ! function_exists('default_language') ) {
  /**
  * default_language
  * @param string default_language
  */
  function default_language()
  {
    $lang = get_language();

    if (!$lang) {
      $db_lang = \App\Models\SettingsModel::get('default_language');
      $lang = $db_lang ?? 'tr';
    }

    site_language($lang);

    return $lang;
  }
}

/** ----------------------------------------------- **/
/** ------------- GENERAL FUNCTIONS --------------- **/
/** ----------------------------------------------- **/

// redirect
if ( ! function_exists('redirect') ) {
  /**
	 * Header Redirect
	 * @param	string	$uri	URL
	 * @param	string	$method	Redirect method
	 *			'auto', 'location' or 'refresh'
	 * @param	int	$code	HTTP Response status code
	 * @return	void
	 */
  function redirect($uri = '', $method = 'auto', $code = NULL)
	{
    error_reporting(0);
    @ob_start();
		if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE) {
			$method = 'refresh';
		}
		elseif ($method !== 'refresh' && (empty($code) OR ! is_numeric($code)))
		{
			if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1') {
				$code = ($_SERVER['REQUEST_METHOD'] !== 'GET') ? 303 : 307;
			}	else {
				$code = 302;
			}
		}
    // uri change
    $substr_uri = substr($uri, 0, 1);
    if ($substr_uri == '/') {
      $uri = Config::SITE_URL . $uri;
    }
    // switch
		switch ($method)
		{
			case 'refresh':
				header('Refresh:0;url='.$uri);
				break;
			default:
				header('Location: '.$uri, TRUE, $code);
				break;
		}
    @ob_end_flush();
		exit;
	}
}

//current_url
if ( ! function_exists('current_url') ) {
  /**
  * retrun current_url
  */
  function current_url()
  {
    return $_SERVER['SCRIPT_URI'] ?? lang_site_url();
  }
}

// site url
if ( ! function_exists('site_url') ) {
  /**
  * retrun is select menu true or false
  * @param string $menu_url
  */
  function site_url($url = '')
  {
    if (substr($url, 0, 1) == '/') {
      $url = substr($url, 1);
    }
    return Config::SITE_URL . Config::PATH_URL . $url;
  }
}

// site url
if ( ! function_exists('lang_site_url') ) {
  /**
  * retrun is select menu true or false
  * @param string $menu_url
  */
  function lang_site_url($url = '')
  {
    if (substr($url, 0, 1) == '/') {
      $url = substr($url, 1);
    }
    return Config::SITE_URL . Config::PATH_URL . get_language() .'/'. $url;
  }
}

// site url
if ( ! function_exists('admin_url') ) {
  /**
  * retrun is select menu true or false
  * @param string $menu_url
  */
  function admin_url($url = '')
  {
    if (substr($url, 0, 1) == '/') {
      $url = substr($url, 1);
    }
    return Config::ADMIN_SITE_URL . Config::PATH_URL . $url;
  }
}

// auth url
if ( ! function_exists('auth_url') ) {
  /**
  * retrun is select menu true or false
  * @param string $menu_url
  */
  function auth_url($url)
  {
    if (substr($url, 0, 1) == '/') {
      $url = substr($url, 1);
    }
    return Config::AUTH_URL .'/'. $url;
  }
}

// auth url
if ( ! function_exists('uploads_url') ) {
  /**
  * retrun is select menu true or false
  * @param string $menu_url
  */
  function uploads_url($url)
  {
    return admin_url('uploads/' . $url);
  }
}

// site url
if ( ! function_exists('site_config') ) {
  /**
  * retrun config
  * @param string $config
  */
  function site_config($select = '')
  {
    $configs = array(
      'Url'         => Config::SITE_URL . Config::PATH_URL,
      'Favicon'     => Config::PATH_URL . 'uploads/' . \App\Models\SettingsModel::get('site_favicon'),
      'Logo'        => Config::PATH_URL . 'uploads/' . \App\Models\SettingsModel::get('site_logo'),
      'title'       => \App\Models\SettingsModel::get('site_title_'.get_language()),
      'description' => \App\Models\SettingsModel::get('site_description_'.get_language()),
      'keywords'    => \App\Models\SettingsModel::get('site_keywords_'.get_language()),
      'Language'    => get_language(),
      'Theme'       => \App\Models\SettingsModel::get('site_theme'),
      'Version'     => Config::SHOW_ERRORS ? '0.0'.date('mdhis'):Config::VERSION
    );
    if (isset($configs[$select]) == true)
      return $configs[$select];
    return $configs['Url'];
  }
}

// site url
if ( ! function_exists('site_path') ) {
  /**
  * retrun path
  * @param string $path
  */
  function site_path($select = '')
  {
    $paths = array(
      'View' => Config::VIEW_PATH,
      'Home' => Config::HOME_URL,
      'Auth' => Config::AUTH_URL,
      'Public'  => Config::PATH_URL,
      'Modules' => Config::DIR_PATH . 'Modules',
      'Upload'  => Config::PATH_URL . 'uploads',
      'Language'=> Config::PATH_URL . 'Languages',
    );
    if (isset($paths[$select]) == true)
      return $paths[$select];
    return $paths['Public'];
  }
}

// csrf_token
if ( ! function_exists('csrf_token') ) {
  /**
  * retrun token
  */
  function csrf_token()
  {
    return 0; // Session::get_token();
  }
}

// csrf_input
if ( ! function_exists('csrf_input') ) {
  /**
  * retrun token
  */
  function csrf_input()
  {
    return ''; // '<input type="hidden" name="' . Config::CSRF . '" value="' . csrf_token() . '">';;
  }
}

// get session user information
if ( ! function_exists('session_user') ) {
  /**
  * return session user info
  * @param $name
  * @param $subname = ''
  */
  function session_user($name, $subname = '')
  {
    return Session::user($name, $subname);
  }
}

// get session user information
if ( ! function_exists('session') ) {
  /**
  * return session info
  * @param $name
  */
  function session($name)
  {
    return Session::get($name);
  }
}

// get session user information
if ( ! function_exists('session_delete') ) {
  /**
  * return session info
  * @param $name
  */
  function session_delete($name)
  {
    return Session::delete($name);
  }
}


// all_organizations
if ( ! function_exists('all_organizations') ) {
  /**
  * return all_organizations
  */
  function all_organizations($limit = null)
  {
    return \App\Models\OrganizationModel::all($limit);
  }
}

// all_yachts
if ( ! function_exists('all_yachts') ) {
  /**
  * return all_yachts
  */
  function all_yachts($limit = null)
  {
    return \App\Models\YachtModel::all($limit);
  }
}

// all_yachts
if ( ! function_exists('all_home_yachts') ) {
  /**
  * return all_home_yachts
  */
  function all_home_yachts($limit = null)
  {
    return \App\Models\YachtModel::all_home($limit);
  }
}

// yachts_count
if ( ! function_exists('yachts_count') ) {
  /**
  * return yachts_count
  */
  function yachts_count($column, $value)
  {
    $count = \App\Models\YachtModel::count_where($column, $value);
    return $count['yc_id'] ?? 0;
  }
}

// filter_yachts
if ( ! function_exists('filter_yachts') ) {
  /**
  * return filter_yachts
  */
  function filter_yachts($filter = [])
  {
    return \App\Models\YachtModel::all();
  }
}

// get get_region_title
if ( ! function_exists('all_yacht_extra') ) {
  /**
  * return all_yacht_extra
  */
  function all_yacht_extra($yacht_id)
  {
    return \App\Models\YachtModel::get_by_yacht_id($yacht_id);
  }
}

// get get_region_title
if ( ! function_exists('all_regions') ) {
  /**
  * return all_regions
  */
  function all_regions($limit = null)
  {
    return \App\Models\RegionModel::all($limit);
  }
}

// get get_region_title
if ( ! function_exists('all_yacht_types') ) {
  /**
  * return all_regions
  */
  function all_yacht_types()
  {
    return \App\Models\YachtModel::all_type();
  }
}

// get get_type_by_id
if ( ! function_exists('get_type_by_id') ) {
  /**
  * return get_type_by_id
  */
  function get_type_by_id($type_id)
  {
    return \App\Models\YachtModel::get_type_by_id($type_id);
  }
}


// get get_region_title
if ( ! function_exists('get_region_title') ) {
  /**
  * return get_region_title
  * @param $region_id
  * @param $lang
  */
  function get_region_title($region_id, $lang = 'tr')
  {
    $region = \App\Models\RegionModel::get_by_id($region_id);
    if ($region) {
      return lang_text($region['tr_title'], $region['en_title']);
    }
    return ' - ';
  }
}

// get user_fullname
if ( ! function_exists('user_fullname') ) {
  /**
  * return user_fullname
  * @param $user_id
  */
  function user_fullname($user_id)
  {
    if ($user_id == session_user('id')) {
      return session_user('fullname');
    }
    return \App\Models\UserModel::get_fullname($user_id);
  }
}

// get user_role
if ( ! function_exists('user_role') ) {
  /**
  * return user_role
  * @param $user_id
  */
  function user_role($user_id)
  {
    if ($user_id == session_user('id')) {
      return session_user('role') == '1' ? 'admin':'member';
    }
    return \App\Models\UserModel::get_role($user_id) == '1' ? 'admin':'member';
  }
}

// get session user information
if ( ! function_exists('user_image') ) {
  /**
  * return user image
  * @param $user_id = 0
  */
  function user_image($user_image = null)
  {
    // if user_id
    if (is_numeric($user_image) == true) {
      // user_id
      $user_id = intval($user_image);
      // session
      if ($user_image == 0 && Session::check_login()) {
        $user_image = session_user('image');
      } else {
        $user_image = \App\Models\UserModel::get_image($user_id);
      }
    } // if user_id

    // file_exists image
    if (file_exists(Config::UPLOAD_PATH . $user_image) != true) {
      $user_image = \App\Models\SettingsModel::get('default_user_avatar');
      // default image exists
      if(file_exists(Config::UPLOAD_PATH . $user_image) != true)
        $user_image = 'default/avatar.png';
    } // // file_exists image

    return uploads_url($user_image);
  }
}

// is_menu_url
if ( ! function_exists('is_menu_url') ) {
  /**
  * retrun true or false
  * @param string $url
  */
  function is_menu_url($url = '')
  {
    return strpos(urldecode($_SERVER['REQUEST_URI']), $url);
  }
}

// site_setting
if ( ! function_exists('site_setting') ) {
  /**
  * site_setting
  * @param string $name  - required
  */
  function site_setting($name)
  {
    $value = \App\Models\SettingsModel::get($name);
    return $value ?? '';
  }
}

// user permissions
if ( ! function_exists('check_permission') ) {
  /**
  * user permissions return
  * @param string $name  - required
  * @param string $primary  - optional
  * @param string $secondary  - optional
  */
  function check_permission($name, $primary = '', $secondary = '', $user_id = 0)
  {
    return 4;
  }
}

// user permissions
if ( ! function_exists('user_permission') ) {
  /**
  * user permissions return
  * @param string $user_id  - required
  * @param string $name  - required
  * @param string $primary  - optional
  * @param string $secondary  - optional
  */
  function user_permission($user_id, $name, $primary = '', $secondary = '')
  {
    return 4;
  }
}

// return set_cookie
if ( ! function_exists('set_cookie') ) {
  /**
  * @param
  */
  function set_cookie($name, $value = '', $time = 12)
  {
    $cookie_name = Config::COOKIE_PREFIX . $name;
    $cookie_time = intval($time) * 3600;
    @setcookie($cookie_name, htmlentities(htmlspecialchars($value)), (time() + $cookie_time), '/', '.'.@$_SERVER['HTTP_HOST'], true);
	}
  // set_cookie
}

// return get_cookie
if ( ! function_exists('get_cookie') ) {
  /**
  * @param
  */
  function get_cookie($name)
  {
    $cookie_name = Config::COOKIE_PREFIX . $name;
    return htmlentities(htmlspecialchars($_COOKIE[$cookie_name] ?? ''));
	}
  // get_cookie
}

// return destroy_cookie
if ( ! function_exists('destroy_cookie') ) {
  /**
  * @param
  */
  function destroy_cookie($name)
  {
    $cookie_name = Config::COOKIE_PREFIX . $name;
    @setcookie($cookie_name, '', (time() - 3600), '/', '.'.@$_SERVER['HTTP_HOST'], true);
	}
  // destroy_cookie
}

// view require just not login
if ( ! function_exists('public_view') ) {
  /**
  * require file
  * @param string $file
  * @param array $data
  * @param string $dir
  */
  function public_view($file, $data = [], $dir = null, $include = false, $extension = null)
  {
    // default dir
    if(!$dir) $dir = Config::VIEW_PATH;
    // data export variable
    extract($data, EXTR_SKIP);
    // view $ext
    if(!$extension) $extension = extension($file);
    // is file
    if (file_exists($dir.$file.$extension) && is_readable($dir.$file.$extension)) {
      if ($include) {
        include $dir.$file.$extension;
      } else {
        require_once $dir.$file.$extension;
      } // $include
    } // file_exists
  }
}

// view require just is login
if ( ! function_exists('private_view') ) {
  /**
  * require file
  * @param string $file
  * @param array $data
  * @param string $dir
  */
  function private_view($file, $data = [], $dir = null, $include = false, $extension = null)
  {
    if (Session::check_login() && is_menu_url(str_replace(Config::SITE_URL, '', Config::AUTH_URL)) === false) :
      // default dir
      if(!$dir) $dir = Config::VIEW_PATH;
      // data export variable
      extract($data, EXTR_SKIP);
      // view $ext
      if(!$extension) $extension = extension($file);
      // is file
      if (file_exists($dir.$file.$extension) && is_readable($dir.$file.$extension)) {
        if ($include) {
          include $dir.$file.$extension;
        } else {
          require_once $dir.$file.$extension;
        } // $include
      } // file_exists
    endif;
  }
}

// return form_element
if ( ! function_exists('form_element') ) {
  /**
  * return form_element
  */
  function form_element($file, $data = [])
  {
    return private_view('widgets/element/' . $file, $data, null, true);
  }
}

// return get_ip_address
if ( ! function_exists('get_ip_address') ) {
  /**
  * return ip address
  */
  function get_ip_address()
  {
    if(getenv("HTTP_CLIENT_IP")) {
      $ip = getenv("HTTP_CLIENT_IP");
    } elseif(getenv("HTTP_X_FORWARDED_FOR")) {
      $ip = getenv("HTTP_X_FORWARDED_FOR");
      if (strstr($ip, ',')) {
        $tmp = explode (',', $ip);
        $ip = trim($tmp[0]);
      }
    } else {
      $ip = getenv("REMOTE_ADDR");
    }
    return $ip;
  }
}


// case convert lowercase or uppercase
// return user
if ( ! function_exists('case_converter') ) {
  /**
  * @param $keyword
  */
  function case_converter($keyword, $transform = 'lowercase')
  {
		$low = array('a','b','c','ç','d','e','f','g','ğ','h','ı','i','j','k','l','m','n','o','ö','p','r','s','ş','t','u','ü','v','y','z','q','w','x');
		$upp = array('A','B','C','Ç','D','E','F','G','Ğ','H','I','İ','J','K','L','M','N','O','Ö','P','R','S','Ş','T','U','Ü','V','Y','Z','Q','W','X');
    // uppercase
		if($transform == 'uppercase' || $transform == 'u') {
			$keyword = str_replace( $low, $upp, $keyword );
			$keyword = function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $keyword ) : $keyword;
		}
     // lowercase
    elseif($transform == 'lowercase' || $transform == 'l') {
			$keyword = str_replace( $upp, $low, $keyword );
			$keyword = function_exists( 'mb_strtolower' ) ? mb_strtolower( $keyword ) : $keyword;
		}
    // return
		return $keyword;
	}
  // case_converter
}

// return turkish long date
if ( ! function_exists('turkish_long_date') ) {
  /**
  * @param $format
  * @param $datetime
  */
  function turkish_long_date($format, $datetime = 'now')
  {
    $z = date("$format", strtotime($datetime));
    $days_array = array(
        'Monday'    => 'Pazartesi',
        'Tuesday'   => 'Salı',
        'Wednesday' => 'Çarşamba',
        'Thursday'  => 'Perşembe',
        'Friday'    => 'Cuma',
        'Saturday'  => 'Cumartesi',
        'Sunday'    => 'Pazar',
        'January'   => 'Ocak',
        'February'  => 'Şubat',
        'March'     => 'Mart',
        'April'     => 'Nisan',
        'May'       => 'Mayıs',
        'June'      => 'Haziran',
        'July'      => 'Temmuz',
        'August'    => 'Ağustos',
        'September' => 'Eylül',
        'October'   => 'Ekim',
        'November'  => 'Kasım',
        'December'  => 'Aralık',
        'Mon'       => 'Pts',
        'Tue'       => 'Sal',
        'Wed'       => 'Çar',
        'Thu'       => 'Per',
        'Fri'       => 'Cum',
        'Sat'       => 'Cts',
        'Sun'       => 'Paz',
        'Jan'       => 'Oca',
        'Feb'       => 'Şub',
        'Mar'       => 'Mar',
        'Apr'       => 'Nis',
        'Jun'       => 'Haz',
        'Jul'       => 'Tem',
        'Aug'       => 'Ağu',
        'Sep'       => 'Eyl',
        'Oct'       => 'Eki',
        'Nov'       => 'Kas',
        'Dec'       => 'Ara',
    );
    foreach($days_array as $en => $tr){
        $z = str_replace($en, $tr, $z);
    }
    if(strpos($z, 'Mayıs') !== false && strpos($format, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
    return $z;
	}
  // turkish_long_date
}

// unique_multidim_array
if ( ! function_exists('unique_multidim_array') ) {

  function unique_multidim_array($array, $key)
  {
    $i = 0;
    $temp_array = [];
    $key_array = [];

    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
  }

} // unique_multidim_array


if ( ! function_exists('generate_permalink') ) {

  function generate_permalink($str, $options = array())
  {
     $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
     $defaults = array(
         'delimiter' => '-',
         'limit' => null,
         'lowercase' => true,
         'replacements' => array(),
         'transliterate' => true
     );
     $options = array_merge($defaults, $options);
     $char_map = array(
         // Latin
         'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
         'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
         'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
         'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
         'ß' => 'ss',
         'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
         'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
         'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
         'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
         'ÿ' => 'y',
         // Latin symbols
         '©' => '(c)',
         // Greek
         'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
         'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
         'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
         'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
         'Ϋ' => 'Y',
         'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
         'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
         'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
         'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
         'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
         // Turkish
         'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
         'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
         // Russian
         'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
         'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
         'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
         'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
         'Я' => 'Ya',
         'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
         'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
         'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
         'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
         'я' => 'ya',
         // Ukrainian
         'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
         'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
         // Czech
         'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
         'Ž' => 'Z',
         'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
         'ž' => 'z',
         // Polish
         'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
         'Ż' => 'Z',
         'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
         'ż' => 'z',
         // Latvian
         'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
         'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
         'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
         'š' => 's', 'ū' => 'u', 'ž' => 'z'
     );
     $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
     if ($options['transliterate']) {
         $str = str_replace(array_keys($char_map), $char_map, $str);
     }
     $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
     $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
     $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
     $str = trim($str, $options['delimiter']);
     return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
  }
}// generate_permalink


// file extension
if ( ! function_exists('extension') ) {
  /**
  * @param string $file
  */
  function extension($file)
  {
    // allow extension
    $allow = ['php', 'html', 'svg', 'jpg', 'gif', 'png', 'webp', 'txt', 'json'];
    // file extension
    $ext = explode('.', $file);
    // return
    return in_array(end($ext), $allow)  ? '':'.' . $allow[0];
  }
}

// isset variable
if ( ! function_exists('debug') ) {
  /**
  * @param string $content
  */
  function debug($content, $exit = true)
  {
    echo '<pre>';
    print_r($content);
    echo '</pre>';
    if ($exit) exit;
  }
}

?>
