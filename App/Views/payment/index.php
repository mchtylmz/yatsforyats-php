<?php if (isset($header)) {
	$data['body_id'] = 'odeme-page';
	public_view('header', $data);
}
$pos_inputs = ziraat_input_settings([
	// Payment
	'pay_id'       => $Payment['id'],
	'pay_row_id'   => $Payment['reserve_id'],
	'pay_currency' => $Payment['currency'],
	'amount'       => $Payment['amount'],
	'created_at'   => $Payment['create_at'],
	// Reserve
	'reserve_fullname' => $Reserve['first_name'] .' '. $Reserve['last_name'],
	'reserve_phone'    => $Reserve['phone'],
	'reserve_email'    => $Reserve['email'],
]);
?>
<style media="screen">
.card-number {
	background-image: url('<?=site_url()?>assets/card.png');
	background-size: auto 75%;
	background-position: right;
	background-repeat: no-repeat;
}
.form-group.has-error input, input.has-error {
	border: dotted 1px red;
	box-sizing: border-box;
	color: red;
}
.form-group.has-success input, input.has-success {
	border: dotted 1px green;
	box-sizing: border-box;
	color: #494949;
}
.form-group.has-success input + medium {
	display: none;
}
.visa {
	background-image: url('<?=site_url()?>assets/card_visa.png') !important;
}
.mastercard {
	background-image: url('<?=site_url()?>assets/card_mastercard.png') !important;
}
.amex {
	background-image: url('<?=site_url()?>assets/card_amex.png') !important;
}
.online-payment {
	display: flex;
	flex-wrap: wrap;
	max-width: 100%;
	align-items: center;
	justify-content: center;
	margin: 15px 0 0 0;
}
.online-payment .card-logo  {
  height: 24px;
  margin: 5px 5px;
}
</style>
  <div class="container odeme">
      <div class="row">
          <div class="col-12 d-flex justify-content-center py-4 py-lg-5">
              <img src="<?=uploads_url(site_setting('site_logo_beyaz'))?>" alt="<?=site_config('title')?>" style="height: 48px">
          </div>
      </div>
      <div class="row">
          <div class="col-12 col-lg-10 offset-lg-1">
              <div
                  class="bg-white rounded p-4 border d-flex flex-column flex-lg-row justify-content-between align-items-center">
                  <div class="d-flex flex-column flex-lg-row align-items-center">
                      <img class="yat-img" src="<?=uploads_url($Yacht['yc_image'])?>" alt="<?=lang_text($Yacht['yc_title_tr'], $Yacht['yc_title_en'], $Yacht['yc_title_ru'])?>">
                      <div class="ml-0 ml-lg-3 flex-column my-3 my-lg-0">
                          <div class="yat-adi text-center text-lg-left mb-1">
														<?=lang_text($Yacht['yc_title_tr'], $Yacht['yc_title_en'], $Yacht['yc_title_ru'])?>
													</div>
                          <div class="tarih text-center text-lg-left mb-1">
														<?=read_translate('rezervasyon_tarih')?>
														<?=turkish_long_date('j F', $Reserve['start_date'])?> - <?=turkish_long_date('j F Y', $Reserve['end_date'])?>
													</div>
                          <div class="rez-no text-center text-lg-left">
														<?=read_translate('rezervasyon_no')?> <?=$Payment['reserve_id']?>
													</div>
                      </div>
                  </div>
                  <div class="btn btn-info py-2 py-lg-4 px-5">
                      <div><?=read_translate('toplam_ucret')?></div>
                      <div>
												<?php
												switch ($Payment['currency']) {
													case '949': echo '₺'; break;
													case '840': echo '$'; break;
													case '978': echo '€'; break;
													default: echo '€'; break;
												}
												echo $Payment['amount'];
												?>
											</div>
                  </div>
              </div>
          </div>

					<form class="" action="<?php echo $pos_inputs['pos_url']; unset($pos_inputs['pos_url']); ?>" method="post">
          <div class="col-12 col-lg-10 offset-lg-1 mt-3 mt-lg-4">
              <div class="bg-white rounded border p-4 px-lg-5 creditCardForm">
                  <div class="title text-center mb-4 payment"><?=read_translate('odeme_bilgileriniz')?></div>
                  <div class="row pt-4 pb-4">
                      <div class="col-12 mb-2">
                          <div class="form-group">
                              <input type="text" class="form-control p-4" name="owner" id="owner" autocomplete="off"
                                placeholder="<?=read_translate('kartin_uzerindeki_isim')?>" required>
                          </div>
                      </div>
                      <div class="col-12 mb-2">
                          <div class="form-group" id="card-number-field">
                              <input type="text" class="form-control p-4 card-number" maxlength="19" name="pan" id="cardNumber" autocomplete="off"
                                 placeholder="<?=read_translate('kart_numarasi')?>" required>
															<medium id="cardWrong" style="display:none; color:red">
																<?=lang_text('Kart Numarası hatalı/eksik!.', 'Card Number Invalid!.', 'Номер карты недействителен')?>
															</medium>
                          </div>
                      </div>
                      <div class="col-12 col-lg-8 mb-2">
                          <div class="row align-items-center">
                          	<div class="col-lg-6">
															<div class="form-group">
																<select class="form-control" name="Ecom_Payment_Card_ExpDate_Month" autocomplete="off" style="height: 50px; outline: none; border: 1px solid #ced4da" required>
																	<option value="" hidden><?=lang_text('AY', 'MONTH', 'МЕСЯЦ')?></option>
																	<option value="01">01</option>
																	<option value="02">02</option>
																	<option value="03">03</option>
																	<option value="04">04</option>
																	<option value="05">05</option>
																	<option value="06">06</option>
																	<option value="07">07</option>
																	<option value="08">08</option>
																	<option value="09">09</option>
																	<option value="10">10</option>
																	<option value="11">11</option>
																	<option value="12">12</option>
																</select>
		                          </div>
                          	</div>
														<div class="col-lg-6">
															<div class="form-group">
																<select class="form-control" name="Ecom_Payment_Card_ExpDate_Year" autocomplete="off" style="height: 50px; outline: none; border: 1px solid #ced4da" required>
																	<option value="" hidden><?=lang_text('YIL', 'YEAR', 'ГОД')?></option>
																	<?php for ($i = 0; $i < 25; $i++) {
																		echo '<option value="'.date('y', strtotime('+'.$i.' years')).'">'.date('Y', strtotime('+'.$i.' years')).'</option>';
																	} ?>
																</select>
		                          </div>
                          	</div>
                          </div>
                      </div>
                      <div class="col-12 col-lg-4 mb-2">
                          <div class="form-group">
                              <input type="text" class="form-control p-4" name="cv2" maxlength="4" id="cvv" autocomplete="off"
															placeholder="<?=read_translate('guvenlik_kodu')?>" required>
                          </div>
                      </div>

                      <div class="col-12">
												<div class="form-group" id="credit_cards" style="display:none">
													 <select class="form-control auth-form-input minimal" id="cardType" name="cardType">
														 <option value="1" selected="">Visa</option>
														 <option value="2">MasterCard</option>
													 </select>
												</div>
												<div class="form-group mt-3" id="pay-now">
													<button type="submit" id="confirm-button" class="btn btn-info w-100 py-3"><?=read_translate('odeme_yap')?></button>
												</div>
                      </div>
                  </div>
									<br>
                  <div class="text-center online-payment">
                    <img src="<?php echo site_url(); ?>assets/card_visa.png" alt="visa" class="lazyload card-logo">
                    <img src="<?php echo site_url(); ?>assets/card_mastercard.png" alt="mastercard" class="lazyload card-logo">
                    <img src="<?php echo site_url(); ?>assets/ziraat_bankasi.png" alt="ziraat_bankasi" class="lazyload card-logo">
                  </div>
              </div>
          </div>


					<input type="hidden" name="clientid" value="<?=$pos_inputs['client_id']?>">
					<input type="hidden" name="amount" value="<?=$pos_inputs['amount']?>">
					<input type="hidden" name="oid" value="<?=$pos_inputs['siparis_no']?>">
					<input type="hidden" name="okUrl" value="<?=$pos_inputs['success_url']?>">
					<input type="hidden" name="failUrl" value="<?=$pos_inputs['error_url']?>">
					<input type="hidden" name="rnd" value="<?=$pos_inputs['rnd']?>">
					<input type="hidden" name="hash" value="<?=$pos_inputs['hash']?>">
					<?php /*
          <input type="hidden" name="islemtipi" value="<?=$pos_inputs['islem_tipi']?>">
					<input type="hidden" name="taksit" value="<?=$pos_inputs['taksit']?>">
          */ ?>
					<input type="hidden" name="storetype" value="<?=$pos_inputs['store_type']?>">

					<input type="hidden" name="lang" value="<?=$pos_inputs['lang']?>">
					<input type="hidden" name="currency" value="<?=$pos_inputs['currency']?>">
					<input type="hidden" name="firmaadi" value="<?=$pos_inputs['firma_adi']?>">
					<input type="hidden" name="Fismi" value="<?=$pos_inputs['f_isim']?>">
					<input type="hidden" name="faturaFirma" value="<?=$pos_inputs['firma_adi']?>">
					<input type="hidden" name="Fadres" value="<?=$pos_inputs['f_adres']?>">
					<input type="hidden" name="Fadres2" value="">
					<input type="hidden" name="Fil" value="<?=$pos_inputs['f_il']?>">
					<input type="hidden" name="Filce" value="<?=$pos_inputs['f_ilce']?>">
					<input type="hidden" name="Fpostakodu" value="<?=$pos_inputs['f_posta_kodu']?>">
					<input type="hidden" name="tel" value="<?=$pos_inputs['telefon']?>">
					<input type="hidden" name="email" value="<?=$pos_inputs['email']?>">
					<input type="hidden" name="fulkekod" value="<?=$pos_inputs['f_ulke']?>">
					<input type="hidden" name="nakliyeFirma" value="<?=$pos_inputs['f_nakliye']?>">
					<input type="hidden" name="tismi" value="<?=$pos_inputs['t_isim']?>">
					<input type="hidden" name="tadres" value="<?=$pos_inputs['t_adres']?>">
					<input type="hidden" name="tadres2" value="">
					<input type="hidden" name="til" value="<?=$pos_inputs['t_il']?>">
					<input type="hidden" name="tilce" value="<?=$pos_inputs['t_ilce']?>">
					<input type="hidden" name="tpostakodu" value="<?=$pos_inputs['t_posta_kodu']?>">
					<input type="hidden" name="tulkekod" value="<?=$pos_inputs['t_ulke']?>">
					<input type="hidden" name="itemnumber1" value="<?=$pos_inputs['item_number']?>">
					<input type="hidden" name="productcode1" value="<?=$pos_inputs['product_code']?>">
					<input type="hidden" name="qty1" value="<?=$pos_inputs['qty']?>">
					<input type="hidden" name="desc1" value="<?=$pos_inputs['desc']?>">
					<input type="hidden" name="id1" value="<?=$pos_inputs['id']?>">
					<input type="hidden" name="price1" value="<?=$pos_inputs['price']?>">
					<input type="hidden" name="total1" value="<?=$pos_inputs['total']?>">
					<input type="hidden" name="row_id" value="<?=$pos_inputs['row_id']?>">
					<input type="hidden" name="is_active" value="<?=$pos_inputs['is_active']?>">
					<input type="hidden" name="user_active" value="<?=$pos_inputs['user_active']?>">
					<input type="hidden" name="ucode" value="<?=$pos_inputs['customer_code']?>">
					<input type="hidden" name="tcode" value="<?=$pos_inputs['item_number']?>">
					<input type="hidden" name="eid" value="<?=$pos_inputs['id'] * 149261?>">
				</form>

          <div class="col-12 col-lg-10 offset-lg-1 mt-3 mt-lg-4">
              <div class="bg-white p-4 rounded border">

                  <div class="row align-items-center havale">
                      <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                          <div class="title text-center text-lg-left mb-3"><?=read_translate('banka_transferi_odeme')?></div>
                          <div class="text-center text-lg-left"><?=read_translate('banka_transferi_odeme_aciklama')?></div>
                      </div>
                      <div class="col-12 col-lg-6">
                          <div class="blue-bg p-4 ml-0 ml-lg-4">
                              <div class="my-1"><strong><?=read_translate('banka_adi')?></strong> <?=site_setting('banka_adi')?></div>
                              <div class="my-1"><strong><?=read_translate('sube_kodu')?></strong> <?=site_setting('sube_kodu')?></div>
                              <div class="my-1"><strong><?=read_translate('sube_adi')?></strong> <?=site_setting('sube_adi')?></div>
                              <div class="my-1"><strong><?=read_translate('hesap_no')?></strong> <?=site_setting('hesap_no')?></div>
                              <div class="my-1"><strong><?=read_translate('iban')?></strong> <?=site_setting('banka_iban')?></div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-12">
              <a href="<?=lang_site_url()?>">
                  <div class="my-5 text-center w-100 text-black"><?=read_translate('anasayfa_don')?></div>
              </a>
          </div>
      </div>
  </div>

  <script src="<?=site_url('assets')?>/dist/js/jquery-3.5.1.min.js"></script>
  <script src="<?=site_url('assets')?>/dist/js/popper.min.js"></script>
  <script src="<?=site_url('assets')?>/dist/js/bootstrap.min.js"></script>
  <script src="<?=site_url('assets')?>/dist/js/main.prod.js"></script>
  <script src="<?=site_url('assets')?>/dist/libs/slick/slick.min.js"></script>
	<script src="https://demo.tutorialzine.com/2016/11/simple-credit-card-validation-form/assets/js/jquery.payform.min.js" charset="utf-8"></script>
	<script type="text/javascript">
	$( "form" ).submit(function( event ) {
		$('button[type=submit]')
		.text('<?=read_translate('lutfen_bekleyiniz')?>')
		.attr('disabled', 'disabled');
		$('input[name=taksit]').val('');
	});
	var owner = $('#owner'),
    cardNumber = $('#cardNumber'),
    cardNumberField = $('#card-number-field'),
    CVV = $("#cvv"),
    confirmButton = $('#confirm-button'),
    cardType = $("#cardType");
    cardNumber.payform('formatCardNumber');
    CVV.payform('formatCardCVC');

  cardNumber.keyup(function() {
    cardNumber.removeClass('visa mastercard amex');

    if ($.payform.validateCardNumber(cardNumber.val()) == false) {
        cardNumberField.removeClass('has-success');
        cardNumberField.addClass('has-error');
    } else {
        cardNumberField.removeClass('has-error');
        cardNumberField.addClass('has-success');
    }

    if ($.payform.parseCardType(cardNumber.val()) == 'visa') {
        cardNumber.addClass('visa');
        cardType.val('1').trigger('change');
    } else if ($.payform.parseCardType(cardNumber.val()) == 'amex') {
        cardNumber.addClass('amex');
        cardType.val('1').trigger('change');
    } else if ($.payform.parseCardType(cardNumber.val()) == 'mastercard') {
        cardNumber.addClass('mastercard');
        cardType.val('2').trigger('change');
    } else {
       cardType.val('1').trigger('change');
    }
  });
  owner.keyup(function() {
    if(owner.val().length < 5){
      owner.removeClass('has-success');
      owner.addClass('has-error');
    } else {
      owner.removeClass('has-error');
      owner.addClass('has-success');
    }
  });
  CVV.keyup(function() {
    var isCvvValid = $.payform.validateCardCVC(CVV.val());
    if(!isCvvValid){
      CVV.removeClass('has-success');
      CVV.addClass('has-error');
    } else {
      CVV.removeClass('has-error');
      CVV.addClass('has-success');
    }
  });

  confirmButton.click(function(e) {
    $('#cardWrong').hide();
    owner.removeClass('has-error');
    cardNumber.removeClass('has-error');
    CVV.removeClass('has-error');
    var _return = false;
    var isCardValid = $.payform.validateCardNumber(cardNumber.val());
    var isCvvValid = $.payform.validateCardCVC(CVV.val());

    if(owner.val().length < 5){
        owner.addClass('has-error');
        e.preventDefault();
        _return = true;
    }
    if (!isCardValid) {
        cardNumber.addClass('has-error');
        $('#cardWrong').show();
        e.preventDefault();
        _return = true;
    }
    if (!isCvvValid) {
        CVV.addClass('has-error');
        e.preventDefault();
        _return = true;
    }
    if (_return) {
      e.preventDefault();
      return false;
    }
    checkPoint();
  });
  function checkPoint() {
		$.get("<?=site_url().'payment/checkpointbeforebank'?>?id=<?=$Payment['id']?>", function(data, status){

	  });
  }
	</script>
</body>
</html>
