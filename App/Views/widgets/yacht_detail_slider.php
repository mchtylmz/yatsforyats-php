<?php if (isset($Yacht) && $Yacht): ?>
<style media="screen">
@media only screen and (max-width: 768px) {
	.yat-detay-slider {
		margin-top: 0 !important;
	}
	/*position: absolute;
    right: 25px;*/
}
</style>
<div class="container">
		<div class="row">
				<div class="col-12 px-0 pb-3 slider-col">
						<div class="yat-detay-slider mt-4 mb-0" style="overflow: hidden; min-width: 100%; width: 0;">
								<div class="item">
										<img class="w-100 gimage" src="<?=uploads_url($Yacht['yc_image'])?>">
										<div class="yat-item-detaylar d-flex flex-column justify-content-end align-items-center pb-5">
												<div class="yat-adi"><?=lang_text($Yacht['yc_title_tr'], $Yacht['yc_title_en'], $Yacht['yc_title_ru'])?></div>
												<!--
												<div class="diger-detaylar d-flex align-items-center">
														<div class="diger-detaylar-item mx-1">
																&#8226; <?=$Yacht['yc_ft']?> <?=read_translate('ft')?>
														</div>
														<div class="diger-detaylar-item mx-1">
																&#8226; <?=$Yacht['yc_length']?> <?=read_translate('length')?>
														</div>
														<div class="diger-detaylar-item mx-1">
																&#8226; <?=$Yacht['yc_builder']?> <?=read_translate('builder')?>
														</div>
												</div>
												-->
												<div class="mt-2 d-flex align-items-center justify-content-center" onclick="GalleryLightbox()" style="cursor:pointer">
													<i class="fas fa-search-plus mr-3"></i> <?=lang_text('Büyüt', 'Zoom', 'Увеличить')?>
												</div>
										</div>
								</div>
								<?php if ($Gallery): ?>
								<?php foreach ($Gallery as $key => $gal): ?>
								<div class="item">
										<img class="w-100 gimage" src="<?=uploads_url($gal['gallery_file'])?>">
										<div class="yat-item-detaylar d-flex flex-column justify-content-end align-items-center pb-5">
												<div class="yat-adi"><?=lang_text($Yacht['yc_title_tr'], $Yacht['yc_title_en'], $Yacht['yc_title_ru'])?></div>
												<!--
												<div class="diger-detaylar d-flex align-items-center">
														<div class="diger-detaylar-item mx-1">
																&#8226; <?=$Yacht['yc_ft']?> <?=read_translate('ft')?>
														</div>
														<div class="diger-detaylar-item mx-1">
																&#8226; <?=$Yacht['yc_length']?> <?=read_translate('length')?>
														</div>
														<div class="diger-detaylar-item mx-1">
																&#8226; <?=$Yacht['yc_builder']?> <?=read_translate('builder')?>
														</div>
												</div>
												-->
												<div class="mt-2 d-flex align-items-center justify-content-center" onclick="GalleryLightbox()" style="cursor:pointer">
													<i class="fas fa-search-plus mr-3"></i> <?=lang_text('Büyüt', 'Zoom', 'Увеличить')?>
												</div>
										</div>
								</div>
								<?php endforeach; ?>
								<?php endif; ?>
						</div>
						<div class="yat-detay-slider-nav mt-2 px-3 px-lg-0"
								style="overflow: hidden; min-width: 100%; width: 0;">
								<div class="item">
										<div class="row px-1 mx-0">
												<div class="col-12 px-0">
														<img class="w-100 gtimage" src="<?=uploads_url($Yacht['yc_image'])?>">
												</div>
										</div>
								</div>
								<?php if ($Gallery): ?>
								<?php foreach ($Gallery as $key => $gal): ?>
								<div class="item">
										<div class="row px-1 mx-0">
												<div class="col-12 px-0">
														<img class="w-100 gtimage" src="<?=uploads_url($gal['gallery_file'])?>">
												</div>
										</div>
								</div>
								<?php endforeach; ?>
								<?php endif; ?>
						</div>
				</div>
		</div>
</div>
<?php endif; ?>
