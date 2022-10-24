<!-- Organizasyonlar -->
<?php if ($all_organizations = all_organizations(4)): ?>
<style media="screen">
	.iletisime_gec:hover {
		background-color: white !important;
		color: black !important;
	}
</style>
<div class="container mt-5 organizasyonlar">
		<div class="text-center centered-title mt-5"><?=read_translate('organizasyonlar')?></div>
		<div class="d-flex justify-content-center">
				<img class="my-2" src="<?=site_url('assets')?>/dist/img/yatay-s.svg">
		</div>
		<div class="text-center centered-description"><?=read_translate('organizasyonlar_aciklama')?></div>
		<div class="organizasyon-slider my-5 pb-5">
			<?php foreach ($all_organizations as $key => $org): ?>
			<div class="mb-2 mb-lg-5 pr-2">
					<div class="organizasyon-item position-relative shadow-lg">
							<img class="w-100" src="<?=uploads_url($org['image'])?>" alt="">
							<div class="organizasyon-left-overlay p-4">
									<div class="organizasyon-title"><?=lang_text($org['tr_title'], $org['en_title'], $org['ru_title'])?></div>
									<div class="organizasyon-desc my-4"><?=lang_text($org['tr_brief'], $org['en_brief'], $org['ru_brief'])?></div>
									<a class="" href="<?=lang_site_url(lang_text('iletisim', 'contact', 'kkntakt'))?>">
											<div class="btn organizasyon-btn px-4 py-2 iletisime_gec"><?=read_translate('buton_iletisime_gec')?></div>
									</a>
							</div>
					</div>
			</div>
			<?php endforeach; ?>
		</div>
</div>
<?php endif; ?>
