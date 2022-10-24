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

<!-- breadcrumb -->
<?=public_view('widgets/breadcrumb', [
	'title' => read_translate('bize_ulasin')
]);?>
<!-- breadcrumb -->

<!-- Mesajınız -->
<div class="container-fluid selected-yatch py-2 py-lg-5 pb-3">
		<form action="<?=site_url('contact/add')?>" method="post">
		<div class="row mx-2 mx-lg-0">
				<div class="container">
						<?php if (isset($form_data['status']) && $form_data['status'] == 'error'): ?>
							<div class="row mesaj-gonderildi p-2 mb--3">
									<div class="col-12 bg-danger p-2 rounded border">
											<div class="d-flex flex-column align-items-center justify-content center p-0">
													<div class="title m-2 text-white">
															<?=isset($form_data['message']) && $form_data['message'] ? $form_data['message']:read_translate('mesaj_gonderimi_basarisiz')?>
													</div>
											</div>
									</div>
							</div>
						<?php session_delete('form_data'); endif; ?>
						<div class="row mesaj py-3 py-lg-5">
								<div class="mesaj-col col-12 bg-white py-5 rounded border">
										<div class="text-center title pb-5"><?=read_translate('mesajiniz')?></div>
										<div class="row px-lg-5">
												<div class="col-lg-6 col-12 mb-2">
														<div class="form-group">
																<input type="text" class="form-control" id="name" name="name" aria-describedby="name"
																		placeholder="<?=read_translate('adiniz')?> *" value="<?=$form_data['first_name'] ?? ''?>" autocomplete="off" required>
														</div>
												</div>
												<div class="col-lg-6 col-12 mb-2">
														<div class="form-group">
																<input type="text" class="form-control" id="surname" name="surname" aria-describedby="surname"
																		placeholder="<?=read_translate('soyadiniz')?> *" value="<?=$form_data['last_name'] ?? ''?>" autocomplete="off" required>
														</div>
												</div>
												<div class="col-lg-6 col-12 mb-2">
														<div class="form-group">
																<input type="email" class="form-control" id="email" name="email" aria-describedby="email"
																		placeholder="<?=read_translate('email_adresiniz')?> *" value="<?=$form_data['email'] ?? ''?>" autocomplete="off" required>
														</div>
												</div>
												<div class="col-lg-6 col-12 mb-2">
														<div class="form-group">
																<input type="tel" class="form-control" id="phone" name="phone" maxlength="15" aria-describedby="phone"
																		placeholder="<?=read_translate('telefon_numaraniz')?> *" value="<?=$form_data['phone'] ?? ''?>" autocomplete="off" required>
														</div>
												</div>
												<div class="col-12">
														<div class="form-group">
																<textarea style="resize:none;" class="form-control" name="message"
																		placeholder="<?=read_translate('gondermek_istenilen_mesaj')?>" id="textarea"
																		rows="5" required><?=$form_data['message'] ?? ''?></textarea>
														</div>
												</div>
												<div class="col-12">
														<button type="submit" class="btn btn-info py-3 w-100 mesaj-gonder"><?=read_translate('mesaj_gonder')?></button>
												</div>
										</div>
								</div>
						</div>


				</div>
		</div>
		</form>
		<!-- İletişim Bilgileri -->
		<?=public_view('widgets/index_contact_info', $data);?>
		<!-- İletişim Bilgileri -->
</div>

<?php if (isset($footer)) {
	$data['border_top'] = 1;
	public_view('footer', $data);
} ?>
<script type="text/javascript">
$( "form" ).submit(function( event ) {
  $('button[type=submit]').text('<?=read_translate('lutfen_bekleyiniz')?>').attr('disabled', 'disabled');
});
</script>
