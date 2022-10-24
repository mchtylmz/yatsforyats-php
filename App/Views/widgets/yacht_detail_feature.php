<?php if (isset($Features) && $Features): ?>
	<?php if (is_array($Features) && count($Features) <= 4): ?>
	<style media="screen">
		.slick-track {
			margin-left: 0 !important;
		}
	</style>
	<?php endif; ?>
	<div class="container">
			<div class="row">
					<div class="col-12 px-0">
							<div class="features-title text-center text-lg-left my-3 my-lg-4"><?=read_translate('top_standout_features')?></div>
					</div>
					<div class="col-12 px-0">
							<div class="features-slider mt-2 px-3 px-lg-0" style="overflow: hidden; min-width: 100%; width: 0;">
									<?php foreach ($Features as $key => $fea): ?>
									<div class="item">
											<div class="row px-1 mx-0">
													<div class="col-12 px-0 border">
															<img class="w-100 feimg" src="<?=uploads_url($fea['feature_image'])?>">
															<div class="details p-2 py-3">
																	<div class="feature-title mb-2"><?=lang_text($fea['feature_title_tr'], $fea['feature_title_en'], $fea['feature_title_ru'])?></div>
																	<div class="feature-desc"><?=lang_text($fea['feature_brief_tr'], $fea['feature_brief_en'], $fea['feature_brief_ru'])?></div>
															</div>
													</div>
											</div>
									</div>
									<?php endforeach; ?>
							</div>
					</div>
			</div>
	</div>
<?php endif; ?>
