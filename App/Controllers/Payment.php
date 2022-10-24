<?php

namespace App\Controllers;
use \Core\Model;
use \Core\View;
use \App\Config;
use \App\Session;
use \App\Models\PaymentModel;

/**
 * Payment controller
 *
 * PHP version 7.0
 */
class Payment extends \Core\Controller
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
      // is id
      if (isset($this->route_params['reserveid']) == true && isset($this->route_params['slugid']) == true) {
        // reserveid
        $reserve_id = $this->route_params['reserveid'];
        // slugid
        $slug_id = $this->route_params['slugid'];
        // payment
        $Payment = PaymentModel::get_by_slug_id_and_id($slug_id, $reserve_id);
        if (!$Payment) {
          throw new \Exception("Sayfa Bulunamadı!..", 404);
        }
        if ($Payment['status'] != 'waiting') {
          return redirect(site_url(lang_text('odeme-sonucu', 'payment-result') .'/'. $Payment['id']));
        }
        $data['Payment'] = $Payment;

        $Reserve = \App\Models\ReserveModel::get_by_row_id($reserve_id);
        if (!$Reserve) {
          throw new \Exception("Sayfa Bulunamadı!..", 404);
        }
        $data['Reserve'] = $Reserve;

        $Yacht = \App\Models\YachtModel::get_by_id($Reserve['yacht_id']);
        if (!$Yacht) {
          throw new \Exception("Sayfa Bulunamadı!..", 404);
        }
        $data['Yacht'] = $Yacht;

      } else {
        throw new \Exception("Sayfa Bulunamadı!..", 404);
      }
      // Page
      $data['PageTitle'] = read_translate('menu_odeme');

      // Header and Footer
      $data['header'] = true;
      $data['footer'] = true;

      View::render('payment/index', $data);
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

    public function ziraatbank_response()
    {
      if (allow_method('POST') != true) {
        return redirect(site_url());
      }
      // detect_language
      // site_language(site_setting('default_language'));
      // is id
      if (isset($this->route_params['pay_id']) == true && isset($this->route_params['pay_row_id']) == true) {
        // pay_id
        $pay_id = $this->route_params['pay_id'];
        // pay_row_id
        $pay_row_id = $this->route_params['pay_row_id'];
        // payment
        $Payment = PaymentModel::get_by_id($pay_id);
        if (!$Payment) {
          throw new \Exception("Sayfa Bulunamadı!..", 404);
        }
        $data['Payment'] = $Payment;

        $Reserve = \App\Models\ReserveModel::get_by_row_id($pay_row_id);
        $data['Reserve'] = $Reserve;

        $Yacht = \App\Models\YachtModel::get_by_id($Reserve['yacht_id']);
        $data['Yacht'] = $Yacht;
      } else {
        throw new \Exception("Sayfa Bulunamadı!..", 404);
      }
      ////////////////// ZİRAAT BANK İŞLEMLERİ
      $hatalar = [];
      ///////// Banka Sisteminde Gelme Kontrol
      if (isset($_SERVER['HTTP_REFERER'])) {
        if (strpos($_SERVER['HTTP_REFERER'], 'ziraatbank.com.tr') !== false) {
          // Bankadan Geldi
        } else {
          // Banka harici bir yerden geldi
          // error
          Session::set('result_message', read_translate('odeme_basarisiz'));
          Session::set('result_description', read_translate('odeme_basarisiz_aciklama'));
          return redirect(lang_site_url(lang_text('basarisiz', 'error')));
        }
      }
      ///////// Banka Sisteminde Gelme Kontrol
      ///////// Bankdan gelen sonuç bilgisni güncelle
      \App\Models\PaymentModel::update($pay_id, [
        'bank_response' => @json_encode($_POST),
        'referrer'      => $_SERVER['HTTP_REFERER'] ?? '',
        'client_ip'     => post('clientIp') ?? get_ip_address(),
        'status_text'   => 'Ödeme Kontrol Sayfası ('.date('Y-m-d H:i:s').')'
      ]);
      ///////// Bankdan gelen sonuç bilgisni güncelle
      ///////// Bankadan gelen tutar ile sitedeki tutar karşılaştır
      $bank_amount = post('amount') ? floatval(post('amount')):intval(post('amount'));
      if ($Payment && floatval($Payment['amount']) == floatval($bank_amount)) {
        // Bankaya gönderilen taksit miktarı ile dönen taksit miktarı eşit
        // Bankaya gönderilen taksit miktarı ile dönen taksit miktarı eşit
      } else {
        $hatalar[] = [
          'kod' => 'E09',
          'mesaj' => lang_text('Bankadan gelen ödeme miktarı ile ödenmesi gereken taksit tutarı eşit değil!. Ödeme bilgisi bankadan gelen ödene miktarıyla güncellendi.', 'The amount of the payment from the bank and the installment amount to be paid do not equal !. Payment information has been updated with the amount received from the bank.')
        ];
      }
      ///////// Bankadan gelen tutar ile sitedeki tutar karşılaştır
      ///////// Güvenlik Kodu Kontrol
      $hashparams = post('HASHPARAMS');
    	$hashparamsval = post('HASHPARAMSVAL');
	    $hashparam = post('HASH');
      $storekey = site_setting('pos_store_key');
      $paramsval = "";
      $index1 = 0;
      $index2 = 0;
      while($index1 < strlen($hashparams))
      {
          $index2 = strpos($hashparams,":",$index1);
          $vl = $_POST[substr($hashparams,$index1,$index2- $index1)];
          if($vl == null)
          $vl = "";
          $paramsval = $paramsval . $vl;
          $index1 = $index2 + 1;
      }
      $storekey = site_setting('pos_store_key');
      $hashval = $paramsval.$storekey;
      $hash = base64_encode(pack('H*',sha1($hashval)));
      if ($paramsval != $hashparamsval || $hashparam != $hash) {
        // error
        Session::set('result_message', lang_text('Güvenlik Kodu Hatalı!.', 'Security Code Error!.'));
        Session::set('result_description', lang_text('Güvenlik Kodu Hatalı!.', 'Security Code Error!.'));
        return redirect(lang_site_url(lang_text('basarisiz', 'error')));
      }
      ///////// 3D Model Curl İşlemi Film/Api
      $name = "yachtsadmin"; //is yeri kullanic adi
      $password = "TYVC6482";    		//Is yeri sifresi
      $clientid = $_POST["clientid"] ?? site_setting('pos_client_id');  		//Is yeri numarasi

      $mode = "P";                            //P olursa gerçek islem, T olursa test islemi yapar
      $type = "Auth";   			//Auth: Satýþ PreAuth: Ön Otorizasyon
      $expires = post('Ecom_Payment_Card_ExpDate_Month')."/".post('Ecom_Payment_Card_ExpDate_Year'); //Kredi Karti son kullanim tarihi mm/yy formatindan olmali
      $cv2 = post('cv2');                     //Kart guvenlik kodu
      $tutar = $bank_amount ?? post('amount');                // Islem tutari
      $taksit = "";           			//Taksit sayisi Pesin satislarda bos gonderilmelidir, "0" gecerli sayilmaz.
      $oid= post('oid');			//Siparis numarasy her islem icin farkli olmalidir ,
                                              //bos gonderilirse sistem bir siparis numarasi üretir.
      $lip = get_ip_address();  	//Son kullanici IP adresi
      $email = $Reserve['email'];  				//Email

                                          //Provizyon alinamadigi durumda taksit sayisi degistirilirse sipari numarasininda
                                          //degistirilmesi gerekir.
      $mdStatus = post('mdStatus');       // 3d Secure iþleminin sonucu mdStatus 1,2,3,4 ise baþarýlý 5,6,7,8,9,0 baþarýsýzdýr
                                          // 3d Decure iþleminin sonucu baþarýsýz ise iþlemi provizyona göndermeyiniz (XML göndermeyiniz).
      $xid = post('xid');                 // 3d Secure özel alani PayerTxnId
      $eci = post('eci');                 // 3d Secure özel alani PayerSecurityLevel
      $cavv = post('cavv');               // 3d Secure özel alani PayerAuthenticationCode
      $md = post('md');

      if ($mdStatus =="1" || $mdStatus == "2" || $mdStatus == "3" || $mdStatus == "4") {
        // XML request sablonu
        $request = "DATA=<?xml version=\"1.0\" encoding=\"ISO-8859-9\"?>".
        "<CC5Request>".
        "<Name>{NAME}</Name>".
        "<Password>{PASSWORD}</Password>".
        "<ClientId>{CLIENTID}</ClientId>".
        "<IPAddress>{IP}</IPAddress>".
        "<Email>{EMAIL}</Email>".
        "<Mode>P</Mode>".
        "<OrderId>{OID}</OrderId>".
        "<GroupId></GroupId>".
        "<TransId></TransId>".
        "<UserId></UserId>".
        "<Type>{TYPE}</Type>".
        "<Number>{MD}</Number>".
        "<Expires></Expires>".
        "<Cvv2Val></Cvv2Val>".
        "<Total>{TUTAR}</Total>".
        "<Currency>{CURRENCY}</Currency>".
        "<Taksit>{TAKSIT}</Taksit>".
        "<PayerTxnId>{XID}</PayerTxnId>".
        "<PayerSecurityLevel>{ECI}</PayerSecurityLevel>".
        "<PayerAuthenticationCode>{CAVV}</PayerAuthenticationCode>".
        "<CardholderPresentCode>13</CardholderPresentCode>".
        "<BillTo>".
        "<Name>{NAME}</Name>".
        "<Street1></Street1>".
        "<Street2></Street2>".
        "<Street3></Street3>".
        "<City></City>".
        "<StateProv></StateProv>".
        "<PostalCode></PostalCode>".
        "<Country></Country>".
        "<Company></Company>".
        "<TelVoice></TelVoice>".
        "</BillTo>".
        "<ShipTo>".
        "<Name></Name>".
        "<Street1></Street1>".
        "<Street2></Street2>".
        "<Street3></Street3>".
        "<City></City>".
        "<StateProv></StateProv>".
        "<PostalCode></PostalCode>".
        "<Country></Country>".
        "</ShipTo>".
        "<Extra></Extra>".
        "</CC5Request>";


        $request = str_replace("{NAME}", $name, $request);
        $request = str_replace("{PASSWORD}", $password, $request);
        $request = str_replace("{CLIENTID}", $clientid, $request);
        $request = str_replace("{IP}", $lip, $request);
        $request = str_replace("{OID}", $oid, $request);
        $request = str_replace("{TYPE}", $type, $request);
        $request = str_replace("{XID}", $xid, $request);
        $request = str_replace("{ECI}", $eci, $request);
        $request = str_replace("{CAVV}", $cavv, $request);
        $request = str_replace("{MD}", $md, $request);
        $request = str_replace("{TUTAR}", $tutar, $request);
        $request = str_replace("{TAKSIT}", '', $request);
        $request = str_replace("{EMAIL}", $Reserve['email'] ?? '', $request);
        $request = str_replace("{CURRENCY}", $Payment['currency'] ?? '949', $request);

        // Sanal pos adresine baglanti kurulmasi

        $url = "https://sanalpos2.ziraatbank.com.tr/fim/api";  //TEST
        $ch = curl_init();    // initialize curl handle
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSLVERSION, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 90); // times out after 90s
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request); // add POST fields
        // Buraya mdStatusa göre bir kontrol koymalisiniz.
        // 3d Secure iþleminin sonucu mdStatus 1,2,3,4 ise baþarýlý 5,6,7,8,9,0 baþarýsýzdýr
        // 3d Decure iþleminin sonucu baþarýsýz ise iþlemi provizyona göndermeyiniz (XML göndermeyiniz).
        $result = curl_exec($ch); // run the whole process
        if (curl_errno($ch)) {
            // error
            Session::set('result_message', lang_text('Bilinmeyen hata oluştu!.', 'Unknown error occured!.'));
            Session::set('result_description', lang_text('Bilinmeyen hata oluştu, lütfen yazılım ekibiyle görüşünüz!.', 'Unknown error occured, please contact the software team!.'));
            return redirect(lang_site_url(lang_text('basarisiz', 'error')));
        } else {
            curl_close($ch);
        }
        ///////// Bankdan gelen sonuç bilgisni güncelle
        \App\Models\PaymentModel::update($pay_id, [
          'bank_data'     => is_string($request) ? $request:@json_encode($request ?? []),
          'bank_response' => is_string($result) ? $result:@json_encode($result ?? []),
          // 'referrer'      => $_SERVER['HTTP_REFERER'] ?? '',
          // 'client_ip'     => post('clientIp') ?? get_ip_address(),
          'status_text'   => 'Ödeme Çekme Curl İşlemi ('.date('Y-m-d H:i:s').')'
        ]);
        ///////// Bankdan gelen sonuç bilgisni güncelle

        $Response ="";
        $OrderId = "";
        $AuthCode = "";
        $ProcReturnCode = "";
        $ErrMsg = "";
        $HOSTMSG = "";
        $HostRefNum = "";
        $TransId = "";

        $response_tag = "Response";
        $posf = strpos (  $result, ("<" . $response_tag . ">") );
        $posl = strpos (  $result, ("</" . $response_tag . ">") ) ;
        $posf = $posf+ strlen($response_tag) +2 ;
        $Response = substr (  $result, $posf, $posl - $posf) ;

        $response_tag = "OrderId";
        $posf = strpos (  $result, ("<" . $response_tag . ">") );
        $posl = strpos (  $result, ("</" . $response_tag . ">") ) ;
        $posf = $posf+ strlen($response_tag) +2 ;
        $OrderId = substr (  $result, $posf , $posl - $posf   ) ;

        $response_tag = "AuthCode";
        $posf = strpos (  $result, "<" . $response_tag . ">" );
        $posl = strpos (  $result, "</" . $response_tag . ">" ) ;
        $posf = $posf+ strlen($response_tag) +2 ;
        $AuthCode = substr (  $result, $posf , $posl - $posf   ) ;

        $response_tag = "ProcReturnCode";
        $posf = strpos (  $result, "<" . $response_tag . ">" );
        $posl = strpos (  $result, "</" . $response_tag . ">" ) ;
        $posf = $posf+ strlen($response_tag) +2 ;
        $ProcReturnCode = substr (  $result, $posf , $posl - $posf   ) ;

        $response_tag = "ErrMsg";
        $posf = strpos (  $result, "<" . $response_tag . ">" );
        $posl = strpos (  $result, "</" . $response_tag . ">" ) ;
        $posf = $posf+ strlen($response_tag) +2 ;
        $ErrMsg = substr (  $result, $posf , $posl - $posf   ) ;

        $response_tag = "HostRefNum";
        $posf = strpos (  $result, "<" . $response_tag . ">" );
        $posl = strpos (  $result, "</" . $response_tag . ">" ) ;
        $posf = $posf+ strlen($response_tag) +2 ;
        $HostRefNum = substr (  $result, $posf , $posl - $posf   ) ;

        $response_tag = "TransId";
        $posf = strpos (  $result, "<" . $response_tag . ">" );
        $posl = strpos (  $result, "</" . $response_tag . ">" ) ;
        $posf = $posf+ strlen($response_tag) +2 ;
        $$TransId = substr (  $result, $posf , $posl - $posf   ) ;
      } // mdStatus
      ///////// 3D Model Curl İşlemi Film/Api
      ///////// RESPONSE
      $Payment_Response = $Response ?? 'Declined';
      // $Payment_mdStatus = intval(post('mdStatus') ?? 0);
      if ($Payment_Response == 'Approved') {
        // RESPONSE APPROVED
        $data['provizyon'] = $AuthCode ?? '0';
        try {
          if ($Payment['status'] != 'success') {
            // update
            $data['provizyon'] = $banka_provizyon = $AuthCode;
            \App\Models\PaymentModel::update($pay_id, [
              'bank_provizyon' => $banka_provizyon,
              'bank_amount'    => floatval($bank_amount ?? 0),
              'action_date'    => date('Y-m-d H:i:s'),
              'status'         => 'success',
              'status_text'    => 'Ödeme Başarılı ('.date('Y-m-d H:i:s').')'
            ]);
            // Reserve onay
            if ($Reserve) {
              \App\Models\ReserveModel::update($Reserve['id'], [
                'status' => 'onaylandı'
              ]);
            } else {
              \App\Models\ReserveModel::update_by_row_id($pay_row_id, [
                'status' => 'onaylandı'
              ]);
            }
            // Reserve onay
          } // != success
        } catch (\Exception $e) {
          $hatalar[] = [
            'kod' => 'E182',
            'mesaj' => lang_text('Ödeme işlemi onaylandı, ödeme işlemi kayıt edilemedi!..', 'Payment transaction is confirmed, payment transaction could not be saved!..')
          ];
        }
        // try catch
        // success
        $data['status'] = $payment_status = 'success';
        // RESPONSE APPROVED
      } else {
        // RESPONSE ERROR
        // veritabanına bilgi verildi
        try {
          \App\Models\PaymentModel::update($pay_id, [
            'bank_provizyon' => null,
            'bank_amount'    => floatval($bank_amount ?? 0),
            'action_date'    => date('Y-m-d H:i:s'),
            'status'         => 'error',
            'status_text'    => 'Ödeme Başarısız ('.date('Y-m-d H:i:s').')'
          ]);
        } catch (\Exception $e) {
          $hatalar[] = [
            'kod' => 'E172',
            'mesaj' => lang_text('Ödeme işleminde hata oluştu, işlem onaylanmadı ve işlem kayıt edilemedi!. İşlem No: ', 'There was an error in the payment transaction, the transaction was not confirmed and the transaction could not be recorded !. Transaction No:') . $pay_row_id
          ];
        }
        // error
        $data['status'] = $payment_status = 'error';
      } // RESPONSE ERROR
      ///////// RESPONSE
      ///////////// Banka Hata
      $data['banka_hata'] = [
        'cod' => $ProcReturnCode ?? post('eci'),
        'msg' => $ErrMsg ?? post('mdErrorMsg'),
      ];
      $data['hata'] = $hatalar;

      // Ödeme sonucu sayfası
      \App\Models\PaymentModel::update($pay_id, [
        'odeme_sonucu' => @json_encode($data),
      ]);

      ///////////// Ödeme sonucu sayfası
      if ($payment_status == 'success') {
        // success
        Session::set('result_message', read_translate('odeme_basarili'));
        Session::set('result_description', read_translate('odeme_basarili_aciklama'));
      } else {
        // error
        Session::set('result_message', read_translate('odeme_basarisiz'));
        Session::set('result_description', read_translate('odeme_basarisiz_aciklama'));
      }
      return redirect(site_url(lang_text('odeme-sonucu', 'payment-result') .'/'. $pay_id));
      // error
      ////////////////// ZİRAAT BANK İŞLEMLERİ
    }

    public function payment_result()
    {
      // detect_language
      detect_language($this->route_params);
      // is id
      if (isset($this->route_params['pay_id']) == true) {
        // pay_id
        $pay_id = $this->route_params['pay_id'];
        // payment
        $Payment = PaymentModel::get_by_id($pay_id);
        if (!$Payment) {
          throw new \Exception("Sayfa Bulunamadı!..", 404);
        }
        $data['Payment'] = $Payment;
      } else {
        throw new \Exception("Sayfa Bulunamadı!..", 404);
      }
      // Page
      $data['PageTitle'] = $Payment['status'] == 'success' ? read_translate('odeme_basarili'):read_translate('odeme_basarisiz');
      // Ödeme sonucu sayfası
      \App\Models\PaymentModel::update($pay_id, [
        'status_text'  => 'Ödeme Sonucu Sayfası ('.date('Y-m-d H:i:s').')'
      ]);
      // Ödeme Sonucu
      $data['odeme_sonucu'] = @json_decode($Payment['odeme_sonucu'], true);
      // Ödeme Sonucu
      // Header and Footer
      $data['header'] = true;
      $data['footer'] = true;

      View::render('payment/' . ($Payment['status'] == 'success' ? 'success':'error'), $data);
    }

    public function checkpointbeforebank()
    {
      $pay_id = get('id');
      if ($pay_id) {
        \App\Models\PaymentModel::update($pay_id, [
          'status_text'   => 'Ziraat Bank Ödeme Sayfası ('.date('Y-m-d H:i:s').')'
        ]);
        $status = 'success';
      }

      echo json_encode([
        'status'   => $status ?? 'error'
      ]);
    }

    // logs
    private function logs($content, $meta_id = 0)
    {
      $insertArray = array(
        'table_name' => Model::payment('table_name'),
        'content'    => $content,
        'meta_id'    => $meta_id
      );
      \App\Models\LogsModel::add($insertArray);
    }
}
