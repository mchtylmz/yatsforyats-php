<?php

namespace App\Controllers;
use \Core\Model;
use \Core\View;
use \App\Config;
use \App\Session;

/**
 * Reserve controller
 *
 * PHP version 7.0
 */
class Reserve extends \Core\Controller
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
      $data['PageTitle'] = read_translate('rezervasyon_sayfa_basligi');
      // $Yacht yachtid
      $Yacht = \App\Models\YachtModel::get_by_id(intval($this->route_params['yachtid'] ?? 0));
      if (!$Yacht) {
         throw new \Exception("Sayfa Bulunamadı!..", 404);
      }
      $data['Yacht'] = $Yacht;
      $data['ReserveDates'] = \App\Models\ReserveModel::get_reserve_date_by_yacht_id($Yacht['yc_id']);
      // Header and Footer
      $data['header'] = true;
      $data['footer'] = true;

      View::render('page/reserve', $data);
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
      if (allow_method('POST') != true || !post('yacht_id') || !post('reserve_name') || !post('reserve_email') || !post('reserve_phone')) {
        Session::set('form_data', [
          'status' => 'error',
          'message' => read_translate('rezervasyon_formu_zorunlu_alan_uyari'),
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
      // table_name
      $table_name = Model::reserve('table_name');
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
        'first_name'     => post('reserve_name'),
        'last_name'      => post('reserve_surname'),
        'email'          => post('reserve_email'),
        'phone'          => post('reserve_phone'),
        'message'        => post('reserve_message') . ' Rezervasyon Tarihleri:' . post('reserve_date'),
        'start_date'     => date('Y-m-d', strtotime(post('reserve_start'))),
        'end_date'       => date('Y-m-d', strtotime(post('reserve_end'))),
        'yacht_id'       => $Yacht['yc_id'],
        'yacht_title'    => $Yacht['yc_title_tr'],
        'yacht_price'    => $Yacht['yc_price'],
        'total_price'    => intval(post('yat_toplam_fiyat') ?? $Yacht['yc_price']),
        'price_currency' => $price_currency,
      ];
      // contact
      $insert_id = Model::reserve('insert')->insert($table_name, $insertData);
      // response
      if ($insert_id) {
        self::logs('Yeni rezervasyon mesajı eklendi.', $insert_id);
        $insertData['status'] = 'success';
        Session::set('result_message', read_translate('rezervasyon_basarili'));
        Session::set('result_description', read_translate('rezervasyon_basarili_aciklama'));

        $reserve_row = \App\Models\ReserveModel::get_by_id($insert_id);
        if ($reserve_row) {
          Session::set('reserve_no', $reserve_row['row_id']);
          // Ödeme Oluştur
          if (post('payment_type') == 'Online Kredi Kartı') {
            $slug = date('ymdhi');
            $pay_id = \App\Models\PaymentModel::add([
              'reserve_id'      => $reserve_row['row_id'],
              'amount'          => $reserve_row['total_price'],
              'currency'        => $reserve_row['price_currency'],
              'status'          => 'waiting',
              'status_text'     => 'Ödeme Oluşturuldu (' . date('Y-m-d H:i') . ')',
              'pay_type'        => 'Online Kredi Kartı',
              'slug'            => $slug,
              'edit_user'       => 0
            ]);
            if ($pay_id) {
              Session::set('payment_slug', $slug . '/OE' . $reserve_row['row_id']);
              Session::set('form_data', $insertData);
              return redirect(lang_site_url(lang_text('odeme', 'payment')) .'/'. $slug . '/OE' . $reserve_row['row_id']);
            } // insert
          } // Ödeme Oluştur
          // Ödeme Oluştur
        }

        Session::set('form_data', $insertData);
        return redirect(lang_site_url(lang_text('basarili', 'success')));
      }
      $insertData['status'] = 'error';
      Session::set('result_message', read_translate('rezervasyon_basarisiz'));
      Session::set('result_description', read_translate('rezervasyon_basarisiz_aciklama'));
      Session::set('form_data', $insertData);
      return redirect(lang_site_url(lang_text('basarisiz', 'error')));
    }


    // logs
    private static function logs($content, $meta_id = 0)
    {
      $insertArray = array(
        'table_name' => Model::reserve('table_name'),
        'content'    => $content,
        'meta_id'    => $meta_id
      );
      \App\Models\LogsModel::add($insertArray);
    }
}
