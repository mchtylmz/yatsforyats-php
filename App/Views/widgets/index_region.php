<?php if ($all_regions = all_regions(8)): ?>
<div class="container my-5">
	<div class="text-center centered-title"><?=read_translate('gidilecek_yerler')?></div>
	<div class="d-flex justify-content-center">
			<img class="my-2" src="<?=site_url('assets')?>/dist/img/yatay-s.svg">
	</div>
	<div class="text-center centered-description"><?=read_translate('gidilecek_yerler_aciklama')?></div>
	<div class="gidilecek-yerler mt-5">
	<?php foreach ($all_regions as $key => $region): ?>
		<div class="gidilecek-yer-item">
			<div class="row px-1 mx-0 mx-0">
				<a href="<?=lang_site_url(lang_text('yatlar', 'yachts', 'yakhty'))?>?region=<?=$region['id']?>">
					<div class="col-12 mb-2 px-0">
						<img class="w-100" src="<?=uploads_url(lang_text($region['tr_image'], $region['en_image'], $region['ru_image']))?>" alt="">
						<div class="details">
							<div class="bolge"><?=lang_text($region['tr_title'], $region['en_title'], $region['ru_title'])?></div>
							<div class="yat-sayisi"><?=yachts_count('yc_region_id', $region['id'])?> <?=read_translate('yat')?></div>
							<div class="description">
								<img class="my-2" src="<?=site_url('assets')?>/dist/img/yatay-s.svg" alt="">
								<p class="text-center mb-0">
									<?=lang_text($region['tr_brief'], $region['en_brief'], $region['ru_brief'])?>
								</p>
							</div>
						</div>
						<div class="overlay"></div>
					</div>
				</a>
			</div>
		</div>
	<?php endforeach; ?>
	</div>
</div>
<br>
<?php endif; ?>
