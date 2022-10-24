<div class="col-xl-3 col-lg-3 col-md-4 col-12 mb-4">
		<a href="<?=lang_site_url(generate_permalink(lang_text($yacht['yc_title_tr'], $yacht['yc_title_en'], $yacht['yc_title_ru'])) .'/'. $yacht['yc_id'])?>">
				<div class="yat-card card border rounded-none">
						<img class="card-img-top w-100 byimage" src="<?=uploads_url($yacht['yc_image'])?>"
								 alt="<?=lang_text($yacht['yc_title_tr'], $yacht['yc_title_en'], $yacht['yc_title_ru'])?>">
						<div class="card-body p-0">
								<div class="d-block justify-content-between align-items-center px-3 px-lg-3 pt-3 mt-1 mt-lg-0 pb-lg-3" style="padding-left: 12px !important">
										<div>
												<div class="yat-adi" style="margin-bottom: 7.5px;">
													<?=lang_text($yacht['yc_title_tr'], $yacht['yc_title_en'], $yacht['yc_title_ru'])?>
												</div>
												<div class="yat-marka-yil" style="margin-bottom: 7.5px;">
													<?=$yacht['yc_builder']?> <span><?=$yacht['yc_built']?></span>
												</div>
										</div>
										<div class="d-flex flex-column justify-content-center">
												<div class="gunluk-fiyat" style="font-size: 25px; margin-bottom: 7.5px;">
													<?=$yacht['yc_currency']?> <?=$yacht['yc_price']?>
												</div>
										</div>
										<div>
												<div class="yat-marka-yil" style="font-size: 14px;">
													<?=get_region_title($yacht['yc_region_id'])?>
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
