<?php if (isset($BlogDetail) && $BlogDetail): ?>
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
						<div class="blog-detay-slider mt-4 mb-0" style="overflow: hidden; min-width: 100%; width: 0;">
								<div class="item">
										<img class="w-100 gimage" src="<?=uploads_url(lang_text($BlogDetail['b_image_tr'], $BlogDetail['b_image_en'] ? $BlogDetail['b_image_en']:$BlogDetail['b_image_tr'], $BlogDetail['b_image_ru'] ? $BlogDetail['b_image_ru']:$BlogDetail['b_image_tr']))?>">
								</div>
						</div>
				</div>
		</div>
</div>
<?php endif; ?>
