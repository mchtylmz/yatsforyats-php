<?php if (isset($Yacht) && $Yacht): ?>
	<style media="screen">
		.yat-detay-slider .item .yat-item-detaylar {
			background: linear-gradient(181.06deg,rgba(10,17,36,0) .191%,#0A1124 200.47%);
		}
	</style>
	<div class="container px-lg-0 mt-0">
			<div class="yat-detay-header">
					<div class="d-flex justify-content-between align-items-center border-bottom py-4 px-3">
							<div class="d-flex flex-column flex-lg-row align-items-lg-center">
									<div class="yat-adi mr-2"><?=lang_text($Yacht['yc_title_tr'], $Yacht['yc_title_en'], $Yacht['yc_title_ru'])?></div>
									<div class="d-flex align-items-center">
											<!--<div class="yat-marka mr-2"><?=$Yacht['yc_builder']?></div>-->
											<div class="yat-yil"><?=$Yacht['yc_built']?></div>
									</div>
							</div>
							<div class="d-flex align-items-center">
									<div class="gunluk d-flex flex-column flex-lg-row align-items-center">
											<div class="fiyat mr-2">
													<?=$Yacht['yc_currency']?><?=$Yacht['yc_price']?>
											</div>
											<?php if ($Yacht['yc_status'] == 'rent'): ?>
												<?=read_translate('gunluk')?>
											<?php endif; ?>
									</div>

								<?php if ($Yacht['yc_status'] == 'sale'): ?>
									<a href="<?=lang_site_url(lang_text('satinal', 'buy', 'kupit') .'/yi'. $Yacht['yc_id'])?>" class="ml-4 px-5 btn btn-info kirala-btn d-none d-lg-block">
										<?=read_translate('yat_satin_al')?>
									</a>
								<?php else: ?>
									<a href="<?=lang_site_url(lang_text('rezervasyon', 'reservation', 'rezervirovaniye') .'/re'. $Yacht['yc_id'])?>" class="ml-4 px-5 btn btn-info kirala-btn d-none d-lg-block">
										<?=read_translate('yat_kirala')?>
									</a>
								<?php endif; ?>
							</div>
					</div>
					<div class="d-flex specs align-items-center justify-content-between justify-content-lg-start py-4 px-3">
							<div class="specs-item d-flex align-items-center mr-0 mr-lg-4">
								<img class="mr-3" src="<?=site_url('assets')?>/dist/img/uzunluk.svg">
								<div class="spec-info"><?=$Yacht['yc_ft']?> <?=read_translate('ft')?></div>
							</div>
							<div class="specs-item d-flex align-items-center mr-0 mr-lg-4">
									<img class="mr-3" src="<?=site_url('assets')?>/dist/img/yat.svg">
									<div class="spec-info"><?=$Yacht['yc_cabin']?> <?=read_translate('cabins')?></div>
							</div>
							<div class="specs-item d-none d-lg-flex align-items-center mr-0 mr-lg-4">
									<img class="mr-3" src="<?=site_url('assets')?>/dist/img/location.svg">
									<div class="spec-info"><?=read_translate('location')?> <?=get_region_title($Yacht['yc_region_id'])?></div>
							</div>
							<div class="specs-item d-flex align-items-center mr-0 mr-lg-4">
									<img class="mr-3" src="<?=site_url('assets')?>/dist/img/users.svg">
									<div class="spec-info"><?=$Yacht['yc_guests']?> <?=read_translate('guests')?></div>
							</div>
					</div>
					<?php if ($Yacht['yc_status'] == 'sale'): ?>
						<a href="<?=lang_site_url(lang_text('satinal', 'buy', 'kupit') .'/yi'. $Yacht['yc_id'])?>" class="d-block d-lg-none w-100 btn btn-info rounded-0 py-3 border font-weight-bold">
							<?=read_translate('yat_satin_al')?>
						</a>
					<?php else: ?>
						<a href="<?=lang_site_url(lang_text('rezervasyon', 'reservation', 'rezervirovaniye') .'/re'. $Yacht['yc_id'])?>" class="d-block d-lg-none w-100 btn btn-info rounded-0 py-3 border font-weight-bold">
							<?=read_translate('yat_kirala')?>
						</a>
					<?php endif; ?>
			</div>
	</div>
<?php endif; ?>
