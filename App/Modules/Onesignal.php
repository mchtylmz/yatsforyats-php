<?php 

namespace App\Modules;

use \App\Config;
use \App\Session;
/**
 * Example Onesignal model
 *
 * PHP version 7.0
 */
class Onesignal
{
  /**
     * Constructor
     *
     * @param string $app_id
     * @param string $rest_api_key
     *
     * NOTE:
     * This helper need curl support
     */
    protected $app_id;
    protected $rest_api_key;
    private $onesignal_api_url = "https://onesignal.com/api/v1/notifications";

    public function __construct($app_id, $rest_api_key)
    {
        $this->app_id = $app_id;
        $this->rest_api_key = $rest_api_key;
    }

    public function sendAll($message, $type = 'page', $type_value = 'welcome', $value_meta = array(), $login_required = true)
    {
      // data
      $data = array();
      if ($type == 'page') :
        $data['page'] = $type_value;
        $data['isLogin'] = $login_required;
        foreach ($value_meta as $key => $value) :
          $data[$key] = $value;
        endforeach;
      endif;
      // url
      $url = null;
      if ($type == 'url') :
        $url = $type_value;
      endif;
      // fields
      $fields = $this->setFields($message, $data, null, $url);
      // return run
      return $this->runCurl($fields);
    }

    public function sendUser($player_id, $message, $type = 'page', $type_value = 'welcome', $value_meta = array(), $login_required = true)
    {
      // data
      $data = array();
      if ($type == 'page') :
        $data['page'] = $type_value;
        $data['isLogin'] = $login_required;
        foreach ($value_meta as $key => $value) :
          $data[$key] = $value;
        endforeach;
      endif;
      // url
      $url = null;
      if ($type == 'url') :
        $url = $type_value;
      endif;
      // fields
      $fields = $this->setFields($message, $data, null, $url);
      // unset
      if (isset($fields['included_segments']) == true) {
        unset($fields['included_segments']);
      }
      $fields['include_player_ids'] = array($player_id);
      // return run
      return $this->runCurl($fields);
    }

    public function sendUsers($player_ids, $message, $type = 'page', $type_value = 'welcome', $value_meta = array(), $login_required = true)
    {
      // player ids
      if (is_array($player_ids) != true) {
        return false;
      }
      $temp_players = array();
      foreach ($player_ids as $key => $player_id) :
        $temp_players[] = "$player_id";
      endforeach;
      // data
      $data = array();
      if ($type == 'page') :
        $data['page'] = $type_value;
        $data['isLogin'] = $login_required;
        foreach ($value_meta as $key => $value) :
          $data[$key] = $value;
        endforeach;
      endif;
      // url
      $url = null;
      if ($type == 'url') :
        $url = $type_value;
      endif;
      // fields
      $fields = $this->setFields($message, $data, null, $url);
      // unset
      if (isset($fields['included_segments']) == true) {
        unset($fields['included_segments']);
      }
      // $temp_players
      if (count($temp_players) <= 0) return false;
      $fields['include_player_ids'] = $temp_players;
      // return run
      return $this->runCurl($fields);
    }

    private function setFields($message, $data = array(), $filters = nnull, $url = null)
    {
      // button
      $button_array = array();
      array_push($button_array, array(
         "id" => "view-button", "text" => "Görüntüle"
      ));
      // $data
      $data['time'] = time();
      // fields
      $fields = array(
        'app_id' => $this->app_id,
        'included_segments' => array('All'),
        'data' => $data,
        'contents' => array("en" => $message),
        'buttons' => $button_array,
        'android_accent_color' => '#01121E'
      );
      // url
      if ($filters && is_array($filters)) :
        $fields['filters'] = $filters;
      endif;
      // url
      if ($url) :
        $fields['app_url'] = $url;
      endif;
      return $fields;
    }

    private function runCurl($fields)
    {
      $fields = json_encode($fields);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $this->onesignal_api_url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic ' . $this->rest_api_key));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_HEADER, FALSE);
      curl_setopt($ch, CURLOPT_POST, TRUE);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      // response
      $response = curl_exec($ch);
      curl_close($ch);
      // return
      return $response;
    }
}
