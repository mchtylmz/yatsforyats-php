<?php

namespace App\Controllers;
use \Core\Model;
use \Core\View;
use \App\Config;
use \App\Session;

/**
 * Contact controller
 *
 * PHP version 7.0
 */
class Contact extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function index()
    {
      // detect_language
      detect_language($this->route_params);
      // Page
      $data['PageTitle'] = read_translate('menu_iletisim');

      // Header and Footer
      $data['header'] = true;
      $data['footer'] = true;

      View::render('page/contact', $data);
    }

    /**
     * en_index
     *
     * @return void
     */
    public function en_index()
    {
      $this->index();
    }

    /**
     * tr_index
     *
     * @return void
     */
    public function tr_index()
    {
      $this->index();
    }

    public function ru_index()
    {
      $this->index();
    }


    public function add()
    {
      if (allow_method('POST') != true || !post('name') || !post('surname') || !post('email') || !post('phone') || !post('message')) {
        Session::set('form_data', [
          'status' => 'error',
          'message' => read_translate('iletisim_formu_zorunlu_alan_uyari'),
        ]);
        return redirect(lang_site_url(lang_text('iletisim', 'contact')));
      }
      // table_name
      $table_name = Model::contact('table_name');
      // data
      $insertData = [
        'first_name' => post('name'),
        'last_name'  => post('surname'),
        'email'      => post('email'),
        'phone'      => post('phone'),
        'message'    => post('message'),
        'ip_address' => get_ip_address()
      ];
      // contact
      $insert_id = Model::contact('insert')->insert($table_name, $insertData);
      // response
      if ($insert_id) {
        self::logs('Yeni iletişim mesajı eklendi.', $insert_id);
        $insertData['status'] = 'success';
        Session::set('form_data', $insertData);
        redirect(lang_site_url(lang_text('basarili', 'success')));
      }
      $insertData['status'] = 'error';
      Session::set('form_data', $insertData);
      redirect(lang_site_url(lang_text('iletisim', 'contact')));
    }


    // logs
    private static function logs($content, $meta_id = 0)
    {
      $insertArray = array(
        'table_name' => Model::contact('table_name'),
        'content'    => $content,
        'meta_id'    => $meta_id
      );
      \App\Models\LogsModel::add($insertArray);
    }
}
