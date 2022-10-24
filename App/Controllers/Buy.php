<?php

namespace App\Controllers;
use \Core\Model;
use \Core\View;
use \App\Config;
use \App\Session;

/**
 * Buy controller
 *
 * PHP version 7.0
 */
class Buy extends \Core\Controller
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
      $data['PageTitle'] = read_translate('satinal_sayfa_basligi');
      // $Yacht yachtid
      $Yacht = \App\Models\YachtModel::get_by_id(intval($this->route_params['yachtid'] ?? 0));
      if (!$Yacht) {
         throw new \Exception("Sayfa Bulunamadı!..", 404);
      }
      if ($Yacht['yc_status'] != 'sale' || $Yacht['yc_bought'] != '0') {
         throw new \Exception("Sayfa Bulunamadı!..", 404);
      }
      $data['Yacht'] = $Yacht;
      // $data['ReserveDates'] = \App\Models\ReserveModel::get_buy_date_by_yacht_id($Yacht['yc_id']);
      // Header and Footer
      $data['header'] = true;
      $data['footer'] = true;

      View::render('page/buy', $data);
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


    public function savenew()
    {
      if (allow_method('POST') != true || !post('yacht_id') || !post('buy_name') || !post('buy_email') || !post('buy_phone')) {
        Session::set('form_data', [
          'status' => 'error',
          'message' => read_translate('satinal_formu_zorunlu_alan_uyari'),
        ]);
        return redirect($_SERVER['HTTP_REFERER'] ?? site_url());
      }
      // $Yacht
      $Yacht = \App\Models\YachtModel::get_by_id(intval(post('yacht_id')));
      if (!$Yacht) {
        Session::set('form_data', [
          'status' => 'error',
          'message' => read_translate('yat_bilgisi_bulunamadi'),
        ]);
        Session::set('result_message', read_translate('yat_bilgisi_bulunamadi'));
        Session::set('result_description', read_translate('yat_bilgisi_bulunamadi'));
        return redirect($_SERVER['HTTP_REFERER'] ?? site_url());
      }
      if ($Yacht['yc_status'] != 'sale' || $Yacht['yc_bought'] != '0') {
        Session::set('form_data', [
          'status' => 'error',
          'message' => read_translate('yat_bilgisi_bulunamadi'),
        ]);
        Session::set('result_message', read_translate('yat_bilgisi_bulunamadi'));
        Session::set('result_description', read_translate('yat_bilgisi_bulunamadi'));
        return redirect($_SERVER['HTTP_REFERER'] ?? site_url());
      }
      // table_name
      $table_name = Model::buy('table_name');
      // price_currency
      $price_currency = 978;
      if ($Yacht['yc_currency'] == '$') {
        $price_currency = 840;
      }
      if ($Yacht['yc_currency'] == '₺') {
        $price_currency = 949;
      }
      if ($Yacht['yc_currency'] == '€') {
        $price_currency = 978;
      }
      // data
      $insertData = [
        'first_name'     => post('buy_name'),
        'last_name'      => post('buy_surname'),
        'email'          => post('buy_email'),
        'phone'          => post('buy_phone'),
        'message'        => post('buy_message'),
        'yacht_id'       => $Yacht['yc_id'],
        'yacht_title'    => $Yacht['yc_title_tr'],
        'yacht_price'    => $Yacht['yc_price'],
        'price_currency' => $price_currency,
      ];
      // contact
      $insert_id = Model::buy('insert')->insert($table_name, $insertData);
      // response
      if ($insert_id) {
        self::logs('Yeni satın alma mesajı eklendi.', $insert_id);
        $insertData['status'] = 'success';
        Session::set('result_message', read_translate('satinal_basarili'));
        Session::set('result_description', read_translate('satinal_basarili_aciklama'));
        Session::set('form_data', $insertData);
        return redirect(lang_site_url(lang_text('basarili', 'success')));
      }
      $insertData['status'] = 'error';
      Session::set('result_message', read_translate('satinal_basarisiz'));
      Session::set('result_description', read_translate('satinal_basarisiz_aciklama'));
      Session::set('form_data', $insertData);
      return redirect(lang_site_url(lang_text('basarisiz', 'error')));
    }


    // logs
    private static function logs($content, $meta_id = 0)
    {
      $insertArray = array(
        'table_name' => Model::buy('table_name'),
        'content'    => $content,
        'meta_id'    => $meta_id
      );
      \App\Models\LogsModel::add($insertArray);
    }
}
