<style media="screen">
	.yardim-btn:hover {
		background-color: white !important;
		color: black !important;
	}
</style>
<div class="container-fluid yardim-container py-5">
	<div class="container">
			<div class="row">
					<div class="col-lg-8 col-12 d-flex flex-column align-items-center align-items-lg-start">
							<div class="yardim-title text-center text-lg-left">
								<?=html_entity_decode(read_translate('footer_yardima_ihtiyac'))?>
							</div>
							<div class="yardim-desc my-2 mt-3 mt-lg-2 mb-5 text-center text-lg-left">
								<?=read_translate('footer_yardima_ihtiyac_aciklama')?>
							</div>
							<a href="<?=lang_site_url(lang_text('iletisim', 'contact', 'kkntakt'))?>">
								<div class="yardim-btn py-2 btn">
									<b><?=read_translate('buton_iletisime_gec')?></b>
								</div>
							</a>
					</div>
					<div class="col-lg-4 d-none d-lg-flex justify-content-center align-items-center position-relative">
							<img class="h-50" src="<?=site_url('assets')?>/dist/img/logo-white.png" alt="">
							<div class="help-woman">
									<img src="<?=site_url('assets')?>/dist/img/help-woman.png" alt="">
							</div>
					</div>
			</div>
	</div>
</div>
