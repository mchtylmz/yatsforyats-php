<div class="row">
	<div class="col-12 px-0">
		<div class="main-slider" style="overflow: hidden; min-width: 100%; width: 0;">
			<?php if (site_setting('site_slider1_enabled') == 'Aktif'): ?>
			<div class="main-slider-item">
				<img class="w-100" src="<?=uploads_url(site_setting('site_slider1_img'))?>" />
				<div class="main-slider-item-content px-3 px-lg-0">
						<div class="big-title">
							<?=lang_text(site_setting('site_slider1_title_tr'), site_setting('site_slider1_title_en'), site_setting('site_slider1_title_ru'))?>
						</div>
						<div class="light-title mt-2 mt-lg-0">
							<?=lang_text(site_setting('site_slider1_desc_tr'), site_setting('site_slider1_desc_en'), site_setting('site_slider1_desc_ru'))?>
						</div>
				</div>
			</div>
			<?php endif; ?>
			<?php if (site_setting('site_slider2_enabled') == 'Aktif'): ?>
			<div class="main-slider-item">
				<img class="w-100" src="<?=uploads_url(site_setting('site_slider2_img'))?>" />
				<div class="main-slider-item-content px-3 px-lg-0">
						<div class="big-title">
							<?=lang_text(site_setting('site_slider2_title_tr'), site_setting('site_slider2_title_en'), site_setting('site_slider2_title_ru'))?>
						</div>
						<div class="light-title mt-2 mt-lg-0">
							<?=lang_text(site_setting('site_slider2_desc_tr'), site_setting('site_slider2_desc_en'), site_setting('site_slider2_desc_ru'))?>
						</div>
				</div>
			</div>
			<?php endif; ?>
			<?php if (site_setting('site_slider3_enabled') == 'Aktif'): ?>
			<div class="main-slider-item">
				<img class="w-100" src="<?=uploads_url(site_setting('site_slider3_img'))?>" />
				<div class="main-slider-item-content px-3 px-lg-0">
						<div class="big-title">
							<?=lang_text(site_setting('site_slider3_title_tr'), site_setting('site_slider3_title_en'), site_setting('site_slider3_title_ru'))?>
						</div>
						<div class="light-title mt-2 mt-lg-0">
							<?=lang_text(site_setting('site_slider3_desc_tr'), site_setting('site_slider3_desc_en'), site_setting('site_slider3_desc_ru'))?>
						</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
