<?php

use \App\Config;

/** ----------------------------------------------- **/
/** ------------- SECURITY FUNCTIONS -------------- **/
/** ----------------------------------------------- **/

if ( ! function_exists('do_hash'))
{
	/**
	 * Hash encode a string
	 *
	 * @param	string	$str
	 * @return	string
	 */
	function do_hash($str)
	{
		return md5(sha1(md5($str . Config::HASH_CODE)));
	}
}

if ( ! function_exists('encode_php_tags'))
{
	/**
	 * Convert PHP tags to entities
	 *
	 * @param	string
	 * @return	string
	 */
	function encode_php_tags($str)
	{
		return str_replace(array('<?', '?>'), array('&lt;?', '?&gt;'), $str);
	}
}


if ( ! function_exists('remove_many_space')) {
	function remove_many_space($string)
	{
		$string = preg_replace("/\s+/", " ", $string);
		if (is_array($string)) {
			return $string;
		}
		$string = trim($string);
		return $string;
	}
}

if ( ! function_exists('xss_clean')) {
	/*
 * XSS filter
 *
 * This was built from numerous sources
 * (thanks all, sorry I didn't track to credit you)
 *
 * It was tested against *most* exploits here: http://ha.ckers.org/xss.html
 * WARNING: Some weren't tested!!!
 * Those include the Actionscript and SSI samples, or any newer than Jan 2011
 *
 *
 * TO-DO: compare to SymphonyCMS filter:
 * https://github.com/symphonycms/xssfilter/blob/master/extension.driver.php
 * (Symphony's is probably faster than my hack)
 */

	function xss_clean($data)
	{
		  // Fix &entity\n;
		  $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
		  $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
		  $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
		  $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

		  // Remove any attribute starting with "on" or xmlns
		  $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

		  // Remove javascript: and vbscript: protocols
		  $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
		  $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
		  $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

		  // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		  $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		  $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		  $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

		  // Remove namespaced elements (we do not need them)
		  $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

		  do
		  {
          // Remove really unwanted tags
          $old_data = $data;
          $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
		  }
		  while ($old_data !== $data);

		  // we are done...
		  return $data;
	 }
}

if ( ! function_exists('input_values')) {
	function input_values($name, $subname = null)
	{
		// values
		$value = request($name, $subname);
		// remove_many_space
		$value = remove_many_space($value);
		// encode_php_tags
		$value = encode_php_tags($value);
		// xss_clean
		$value = xss_clean($value);
		// return
		return $value;
	}
}

if ( ! function_exists('clean_text')) {
	function clean_text($text)
	{
		// remove_many_space
		$text = remove_many_space($text);
		// encode_php_tags
		$text = encode_php_tags($text);
		// xss_clean
		$text = xss_clean($text);
		// return
		return strval($text);
	}
}


if ( ! function_exists('verify_tc_number')) {
	/*
	http://www.mehmetfasil.com/php-tc-kimlik-numarasi-dogrulama-fonksiyonu/
	adresindeki fonksiyonun biraz daha değiştirilmiş halidir.
	En başa rakamlardan oluşma şartı eklendi.
	$all değişkeni başlangıçta sıfır olacak şekilde değiştirildi.
	*/

	function verify_tc_number($tc)
	{
	    if (!ctype_digit($tc)) {
	        return false;
	    }
	    if (strlen($tc) < 11) {
	        return false;
	    }
	    if ($tc[0] == '0') {
	        return false;
	    }
	    $plus = ($tc[0] + $tc[2] + $tc[4] + $tc[6] + $tc[8]) * 7;
	    $minus = $plus - ($tc[1] + $tc[3] + $tc[5] + $tc[7]);
	    $mod = $minus % 10;
	    if ($mod != $tc[9]) {
	        return false;
	    }
	    $all = 0;
	    for ($i = 0; $i < 10; $i++) {
	        $all += $tc[$i];
	    }
	    if ($all % 10 != $tc[10]) {
	        return false;
	    }

	    return true;
	}
}

?>
