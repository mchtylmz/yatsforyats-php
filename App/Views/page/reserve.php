<?php if (isset($header)) {
	public_view('header', $data);
}
$ziraat_enable = site_setting('pos_enable') == '1' ? true:false;
$form_data = session('form_data');
?>
<link rel="stylesheet" type="text/css" href="<?=site_url('assets/picker/dist/css/hotel-datepicker.css')?>">
<div class="container-fluid">
	<?=public_view('sidebar/main_menu', [
		'light' => 1
	]);?>
</div>

<div class="container py-3">
		<div class="col-12 d-flex flex-column align-items-center">
				<div class="check-av-title text-center"><?=read_translate('yat_kirala_sayfa_baslik')?></div>
				<div class="check-av-desc text-center"><?=read_translate('yat_kirala_sayfa_aciklama')?></div>
		</div>
</div>

<form role="form" action="<?=site_url('reserve/savenew')?>" method="post">
<div class="container-fluid selected-yatch py-5 pb-3">
		<div class="row">
				<div class="col-12">
						<div class="title text-center mb-3"><?=read_translate('secilen_yat')?></div>
				</div>
				<div class="container">
						<div class="row">
								<div class="col-12">
										<div class="row selected-yatch-detail mx-2 mx-lg-0 bg-white rounded align-items-stretch">
												<div class="col-12 col-lg-2 px-0">
														<img class="w-100" src="<?=uploads_url($Yacht['yc_image'])?>">
												</div>
												<div class="col-lg-10 col-12 py-3 px-4 d-flex flex-column justify-content-between">
														<div class="d-flex justify-content-between">
																<div style="margin-bottom: 10px;">
																		<div class="yat-adi"><?=lang_text($Yacht['yc_title_tr'], $Yacht['yc_title_en'], $Yacht['yc_title_ru'])?></div>
																		<div class="d-flex align-items-center">
																				<div class="yat-marka"><?=$Yacht['yc_builder']?></div>
																				<div class="yat-yil ml-2"><?=$Yacht['yc_built']?></div>
																		</div>
																</div>
																<div class="d-flex flex-column align-items-center">
																		<div class="day"><?=read_translate('gunluk')?></div>
																		<div class="price" style="flex-direction:column">
																			<?=$Yacht['yc_currency']?> <?=$Yacht['yc_price']?>
																			<br>
																			<small id="yat_gunluk_text"></small>
																			<input type="hidden" id="yat_gunluk_fiyat" name="yat_toplam_fiyat" value="<?=$Yacht['yc_price']?>">
																		</div>
																</div>
														</div>
														<div class="d-flex justify-content-between justify-content-lg-start mt-5 mt-lg-0">
																<div
																		class="yat-spec mr-lg-3 d-flex flex-row flex-wrap justify-content-center align-items-center">
																		<img class="pr-0 pr-lg-2" src="<?=site_url('assets')?>/dist/img/uzunluk.svg" alt="">
																		<p><?=$Yacht['yc_ft']?> <?=read_translate('ft')?></p>
																</div>
																<div
																		class="yat-spec mr-lg-3 d-flex flex-row flex-wrap justify-content-center align-items-center">
																		<img class="pr-0 pr-lg-2" src="<?=site_url('assets')?>/dist/img/yat.svg" alt="">
																		<p><?=$Yacht['yc_cabin']?> <?=read_translate('cabins')?></p>
																</div>
																<div
																		class="yat-spec mr-lg-3 d-flex flex-row flex-wrap justify-content-center align-items-center">
																		<img class="pr-0 pr-lg-2" src="<?=site_url('assets')?>/dist/img/users.svg" alt="">
																		<p><?=$Yacht['yc_guests']?> <?=read_translate('guests')?></p>
																</div>
														</div>
												</div>
										</div>
								</div>
						</div>

						<?php if (isset($form_data['status']) && $form_data['status'] == 'error'): ?>
							<div class="row mesaj-gonderildi p-2 mb--3">
									<div class="col-12 bg-danger p-2 rounded border">
											<div class="d-flex flex-column align-items-center justify-content center p-0">
													<div class="title m-2 text-white">
															<?=isset($form_data['message']) && $form_data['message'] ? $form_data['message']:read_translate('rezervasyon_formu_zorunlu_alan_uyari')?>
													</div>
											</div>
									</div>
							</div>
						<?php session_delete('form_data'); endif; ?>
						<div class="row mesaj py-5 mx-2 mx-lg-0">

								<div class="mesaj-col col-12 bg-white py-5 rounded border">
										<div class="text-center title pb-5"><?=read_translate('rezervasyon_formu_baslik')?></div>
										<div class="row px-lg-5">
												<div class="col-lg-6 col-12 mb-2">
														<div class="form-group">
																<input type="text" class="form-control" id="name" name="reserve_name" aria-describedby="name"
																		placeholder="<?=read_translate('rezervasyon_adiniz')?> *" required>
														</div>
												</div>
												<div class="col-lg-6 col-12 mb-2">
														<div class="form-group">
																<input type="text" class="form-control" id="surname" name="reserve_surname" aria-describedby="surname"
																		placeholder="<?=read_translate('rezervasyon_soyadiniz')?> *" required>
														</div>
												</div>
												<div class="col-lg-6 col-12 mb-2">
														<div class="form-group">
																<input type="email" class="form-control" id="email" name="reserve_email" aria-describedby="email"
																		placeholder="<?=read_translate('rezervasyon_email_adresiniz')?> *" required>
														</div>
												</div>
												<div class="col-lg-6 col-12 mb-2">
														<div class="form-group">
																<input type="tel" class="form-control" id="phone" name="reserve_phone" aria-describedby="phone"
																		placeholder="<?=read_translate('rezervasyon_telefon_numaraniz')?> *" required>
														</div>
												</div>
												<div class="col-lg-<?=$ziraat_enable ? '6':'12'?> col-12 mb-2">
														<div class="form-group">
																<input type="text" class="form-control" id="reservedate" name="reserve_date"
																		placeholder="<?=lang_text('Rezervasyon Tarihi Seçiniz', 'Select Reservation Date')?> *" autocomplete="off" required>
																<input type="hidden" name="reserve_start" id="reserve_start">
																<input type="hidden" name="reserve_end" id="reserve_end">
																<input type="hidden" name="reserve_days" id="reserve_days">
														</div>
												</div>
												<?php if ($ziraat_enable): ?>
													<div class="col-lg-6 col-12 mb-2">
															<div class="form-group">
																	<select class="form-control" name="payment_type" style="height: 56px; outline: none; border: 1px solid #EBF2FA;" required>
																		<option value="" hidden><?=lang_text('Ödeme Tipi', 'Payment Type', 'Способ оплаты')?></option>
																		<option value="Online Kredi Kartı"><?=lang_text('Kredi Kartı', 'Credit Card', 'Кредитная карта')?></option>
																		<option value="Nakit"><?=read_translate('odeme_tipi_kredi_kart_yok')?></option>
																	</select>
															</div>
													</div>
												<?php else: ?>
													<input type="hidden" name="payment_type" value="Nakit">
												<?php endif; ?>

												<div class="col-12">
														<div class="form-group">
																<textarea style="resize:none;" class="form-control" name="reserve_message"
																		placeholder="<?=read_translate('rezervasyon_gondermek_istediginiz_mesaj')?>" id="textarea"
																		rows="5"></textarea>
														</div>
												</div>
												<div class="col-12">
													<input type="hidden" name="yacht_id" value="<?=$Yacht['yc_id']?>">
												  <button type="submit" class="btn btn-info py-3 w-100 mesaj-gonder"><?=read_translate('rezervasyon_yap')?></button>
												</div>
										</div>
								</div>

						</div>
				</div>
		</div>

		<!-- İletişim Bilgileri -->
		<?=public_view('widgets/index_contact_info', $data);?>
		<!-- İletişim Bilgileri -->
</div>
</form>

<?php if (isset($footer)) {
	$data['border_top'] = 1;
	public_view('footer', $data);
} ?>
<script type="text/javascript">
$( "form" ).submit(function( event ) {
  $('button[type=submit]').text('<?=read_translate('lutfen_bekleyiniz')?>').attr('disabled', 'disabled');
});
</script>
<script src="<?=site_url('assets/picker/fecha.min.js')?>" charset="utf-8"></script>
<script type="text/javascript" src="<?=site_url('assets/picker/dist/js/hotel-datepicker.js')?>"></script>
<?php if (get_language() == 'tr'): ?>
<script type="text/javascript">
	window.i18n = {
		selected: 'Rezervasyon:',
		night: 'Gün',
		nights: 'Gün',
		button: 'Kapat',
		'checkin-disabled': 'Uygun Değil',
		'checkout-disabled': 'Uygun Değil',
		'day-names-short': ['Paz', 'Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt'],
		'day-names': ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
		'month-names-short': ['Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Eki', 'Kas', 'Ara'],
		'month-names': ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
		'error-more': 'Tarih aralığı 1 günden fazla olmamalıdır',
		'error-more-plural': 'Tarih aralığı %d günden fazla olmamalıdır',
		'error-less': 'Tarih aralığı 1 günden az olmamalıdır ',
		'error-less-plural': 'Tarih aralığı %d günden az olmamalıdır',
		'info-more': 'Lütfen en az 1 günlük bir tarih aralığı seçin',
		'info-more-plural': 'Lütfen en az %d günlük bir tarih aralığı seçin',
		'info-range': 'Lütfen %d ile %d gün arasında bir tarih aralığı seçin',
		'info-default': 'Lütfen bir tarih aralığı seçin'
	};
</script>
<?php else: ?>
<script type="text/javascript">
	window.i18n = {
		selected: 'Reservation:',
		night: 'Day',
		nights: 'Days',
		button: 'Close',
		'checkin-disabled': 'Not available!',
		'checkout-disabled': 'Not available!',
		'day-names-short': ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
		'day-names': ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
		'month-names-short': ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
		'month-names': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
		'error-more': 'Date range should not be more than 1 day',
		'error-more-plural': 'Date range should not be more than %d days',
		'error-less': 'Date range should not be less than 1 day',
		'error-less-plural': 'Date range should not be less than %d day',
		'info-more': 'Please select a date range of at least 1 day',
		'info-more-plural': 'Please select a date range of at least %d day',
		'info-range': 'Please select a date range between %d and %d days',
		'info-default': 'Please select a date range'
	};
</script>
<?php endif; ?>
<?php
	$dates = [];
	if ($ReserveDates) {
		foreach ($ReserveDates as $key => $reserve) {
			$dates[] = $reserve['date'];
		}
	}
?>
<script type="text/javascript">
	(function() {
		var ReserveData = <?php echo json_encode($dates ?? [], JSON_PRETTY_PRINT) ?>;
		console.log(ReserveData);
		var reservedate = new HotelDatepicker(document.getElementById('reservedate'), {
			format: 'D MMM YYYY',
			startOfWeek: 'monday',
			i18n: i18n,
			autoClose: false,
			disabledDates: ReserveData,
			onSelectRange: function() {
				var choose_date = $('#reservedate').val();
				var dates = choose_date.split("-");
				console.log(dates);
				if (dates[0] != undefined) {
					console.log(dates[0].trim());
					$('#reserve_start').val(moment(dates[0].trim(), 'D MMM YYYY').format('YYYY-MM-DD'));
				}
				if (dates[1] != undefined) {
					$('#reserve_end').val(moment(dates[1].trim(), 'D MMM YYYY').format('YYYY-MM-DD'));
				}
				if (dates[0] != undefined && dates[1] != undefined) {
					var start_res = moment(dates[0].trim(), 'D MMM YYYY');
					var end_res = moment(dates[1].trim(), 'D MMM YYYY');
					var kac_gun = end_res.diff(start_res, 'days');
					$('#reserve_days').val(kac_gun);
					var yat_fiyat = parseFloat($('#yat_gunluk_fiyat').val());
					$('#yat_gunluk_fiyat').val(yat_fiyat * kac_gun)
					// $('#yat_gunluk_text').text(yat_fiyat * kac_gun);
					$('#yat_gunluk_text').text('x ' + kac_gun + ' <?=lang_text('Gün', 'Day', 'День')?>');
				}
			}
		});
	})();
</script>
