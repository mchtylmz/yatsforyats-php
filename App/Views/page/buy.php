<?php if (isset($header)) {
	public_view('header', $data);
}
$form_data = session('form_data');
?>

<div class="container-fluid">
	<?=public_view('sidebar/main_menu', [
		'light' => 1
	]);?>
</div>

<div class="container py-3">
		<div class="col-12 d-flex flex-column align-items-center">
				<div class="check-av-title text-center"><?=read_translate('satinal_sayfa_baslik')?></div>
				<div class="check-av-desc text-center"><?=read_translate('satinal_sayfa_aciklama')?></div>
		</div>
</div>

<form role="form" action="<?=site_url('buy/savenew')?>" method="post">
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
																		<div class="price" style="flex-direction:column">
																			<?=$Yacht['yc_currency']?> <?=$Yacht['yc_price']?>
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
															<?=isset($form_data['message']) && $form_data['message'] ? $form_data['message']:read_translate('satinal_formu_zorunlu_alan_uyari')?>
													</div>
											</div>
									</div>
							</div>
						<?php session_delete('form_data'); endif; ?>
						<div class="row mesaj py-5 mx-2 mx-lg-0">

								<div class="mesaj-col col-12 bg-white py-5 rounded border">
										<div class="text-center title pb-5"><?=read_translate('satinal_formu_baslik')?></div>
										<div class="row px-lg-5">
												<div class="col-lg-6 col-12 mb-2">
														<div class="form-group">
																<input type="text" class="form-control" id="name" name="buy_name" aria-describedby="name"
																		placeholder="<?=read_translate('satinal_adiniz')?> *" required>
														</div>
												</div>
												<div class="col-lg-6 col-12 mb-2">
														<div class="form-group">
																<input type="text" class="form-control" id="surname" name="buy_surname" aria-describedby="surname"
																		placeholder="<?=read_translate('satinal_soyadiniz')?> *" required>
														</div>
												</div>
												<div class="col-lg-6 col-12 mb-2">
														<div class="form-group">
																<input type="email" class="form-control" id="email" name="buy_email" aria-describedby="email"
																		placeholder="<?=read_translate('satinal_email_adresiniz')?> *" required>
														</div>
												</div>
												<div class="col-lg-6 col-12 mb-2">
														<div class="form-group">
																<input type="tel" class="form-control" id="phone" name="buy_phone" aria-describedby="phone"
																		placeholder="<?=read_translate('satinal_telefon_numaraniz')?> *" required>
														</div>
												</div>

												<div class="col-12">
														<div class="form-group">
																<textarea style="resize:none;" class="form-control" name="buy_message"
																		placeholder="<?=read_translate('satinal_gondermek_istediginiz_mesaj')?>" id="textarea"
																		rows="5"></textarea>
														</div>
												</div>
												<div class="col-12">
													<input type="hidden" name="yacht_id" value="<?=$Yacht['yc_id']?>">
												  <button type="submit" class="btn btn-info py-3 w-100 mesaj-gonder"><?=read_translate('satinal_yap')?></button>
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
