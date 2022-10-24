<?php if ($all_yachts = all_home_yachts()): ?>
<div class="container-fluid py-5 en-luks-yatlar-container position-relative">
		<div class="dumen">
				<img src="<?=site_url('assets')?>/dist/img/dumen.png" alt="">
		</div>
		<div class="container px-0">
				<div class="text-center centered-title pt-0 pt-lg-5"><?=read_translate('en_luks_yatlar')?></div>
				<div class="d-flex justify-content-center">
						<img class="my-2" src="<?=site_url('assets')?>/dist/img/yatay-s.svg">
				</div>
				<div class="text-center centered-description"><?=read_translate('en_luks_yatlar_aciklama')?></div>
				<div class="en-luks-yatlar mt-5">
						<?php foreach ($all_yachts as $key => $yacht): ?>
						<div class="en-luks-yatlar-item">
								<div class="row px-2 mx-0 mx-0">
										<a href="<?=lang_site_url(generate_permalink(lang_text($yacht['yc_title_tr'], $yacht['yc_title_en'], $yacht['yc_title_ru'])) .'/'. $yacht['yc_id'])?>">
												<div class="col-12 mb-4 px-0">
														<div class="yat-card card border-0 shadow-sm">
																<img class="card-img-top rimage" src="<?=uploads_url($yacht['yc_image'])?>">
																<div class="card-body p-1 p-lg-3">
																		<div class="d-flex justify-content-between px-2 px-lg-0 mt-1 mt-lg-0">
																				<div>
																						<div class="yat-adi"><?=lang_text($yacht['yc_title_tr'], $yacht['yc_title_en'], $yacht['yc_title_ru'])?></div>
																						<div class="yat-marka-yil"><!--<?=$yacht['yc_builder']?>--> <span><?=$yacht['yc_built']?></span></div>
																				</div>
																				<div>
																						<div class="yat-day"><?=read_translate('gunluk')?></div>
																						<div class="gunluk-fiyat"><?=$yacht['yc_currency']?><?=$yacht['yc_price']?></div>
																				</div>
																		</div>

																		<div class="d-flex justify-content-between mt-3 mt-lg-5">
																				<div
																						class="yat-spec d-flex flex-column flex-lg-row flex-wrap justify-content-center align-items-center">
																						<img class="pr-0 pr-lg-2 mr-2" src="<?=site_url('assets')?>/dist/img/uzunluk.svg" alt="">
																						<p><?=$yacht['yc_ft']?> <?=read_translate('ft')?></p>
																				</div>
																				<div
																						class="yat-spec d-flex flex-column flex-lg-row flex-wrap justify-content-center align-items-center">
																						<img class="pr-0 pr-lg-2 mr-2" src="<?=site_url('assets')?>/dist/img/yat.svg" alt="">
																						<p><?=$yacht['yc_cabin']?> <?=read_translate('cabins')?></p>
																				</div>
																				<div
																						class="yat-spec d-flex flex-column flex-lg-row flex-wrap justify-content-center align-items-center">
																						<img class="pr-0 pr-lg-2 mr-2" src="<?=site_url('assets')?>/dist/img/users.svg" alt="">
																						<p><?=$yacht['yc_guests']?> <?=read_translate('guests')?></p>
																				</div>
																		</div>

																</div>
														</div>
												</div>
										</a>
								</div>
						</div>
					<?php endforeach; ?>
				</div>
		</div>
</div>
<?php endif; ?>
