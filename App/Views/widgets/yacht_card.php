<div class="col-xl-4 col-lg-6 col-md-6 col-12 mb-4">
		<a href="<?=lang_site_url(generate_permalink(lang_text($yacht['yc_title_tr'], $yacht['yc_title_en'], $yacht['yc_title_ru'])) .'/'. $yacht['yc_id'])?>">
				<div class="yat-card card border rounded-none">
						<img class="card-img-top w-100 yimage" src="<?=uploads_url($yacht['yc_image'])?>"
								 alt="<?=lang_text($yacht['yc_title_tr'], $yacht['yc_title_en'])?>">
						<div class="card-body p-0">
								<div class="d-flex justify-content-between align-items-center px-2 px-lg-2 pt-2 mt-1 mt-lg-0 pb-lg-3">
										<div>
												<div class="yat-adi">
													<?=lang_text($yacht['yc_title_tr'], $yacht['yc_title_en'], $yacht['yc_title_ru'])?>
												</div>
												<div class="yat-marka-yil">
													<!--<?=$yacht['yc_builder']?> --><span><?=$yacht['yc_built']?></span>
												</div>
										</div>
										<div class="d-flex flex-column justify-content-center">
												<div class="yat-day">
													<?=read_translate('gunluk')?>
												</div>
												<div class="gunluk-fiyat">
													<?=$yacht['yc_currency']?><?=$yacht['yc_price']?>
												</div>
										</div>
								</div>
								<div class="d-flex justify-content-between mt-3 mt-lg-0 py-lg-3 p-2 py-3 border-top">
										<div class="yat-spec d-flex flex-row flex-lg-row flex-wrap justify-content-center align-items-center">
												<img class="pr-2 pr-lg-0 mr-2" src="<?=site_url('assets')?>/dist/img/uzunluk.svg">
												<p><?=$yacht['yc_ft']?> <?=read_translate('ft')?></p>
										</div>
										<div class="yat-spec d-flex flex-row flex-lg-row flex-wrap justify-content-center align-items-center">
												<img class="pr-2 pr-lg-0 mr-2" src="<?=site_url('assets')?>/dist/img/yat.svg">
												<p><?=$yacht['yc_cabin']?> <?=read_translate('cabins')?></p>
										</div>
										<div class="yat-spec d-flex flex-row flex-lg-row flex-wrap justify-content-center align-items-center">
												<img class="pr-2 pr-lg-0 mr-2" src="<?=site_url('assets')?>/dist/img/users.svg">
												<p><?=$yacht['yc_guests']?> <?=read_translate('guests')?></p>
										</div>
								</div>
						</div>
				</div>
		</a>
</div>
