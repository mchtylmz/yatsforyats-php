<?php if (isset($header)) {
	public_view('header', $data);
}
?>
<div class="container-fluid">
	<?=public_view('sidebar/main_menu', [
		'light' => 1
	]);?>
</div>

<!-- breadcrumb -->
<?=public_view('widgets/breadcrumb', [
	'title' => read_translate('iletisim_sayfa_basligi')
]);?>
<!-- breadcrumb -->

<div class="container py-5">
		<div class="row align-items-center">
				<div class="col-lg-8 col-12 order-1 order-lg-0">
						<div class="hakkimizda-detail-title mb-3"><?=lang_text(site_setting('about_title_tr'), site_setting('about_title_en'), site_setting('about_title_ru'))?></div>
						<p class="hakkimizda-detail-desc ck-content"><?=html_entity_decode(lang_text(site_setting('about_desc_tr'), site_setting('about_desc_en'), site_setting('about_desc_ru')))?></p>
				</div>
				<div class="col-lg-4 col-12 order-0 order-lg-1 d-flex justify-content-center">
						<img class="px-5 w-100 mb-5 mb-lg-0" src="<?=uploads_url(lang_text(site_setting('about_img_tr'), site_setting('about_img_en'), site_setting('about_img_ru')))?>" alt="">
				</div>
		</div>
</div>

<?php if (isset($footer)) {
	$data['border_top'] = 1;
	public_view('footer', $data);
} ?>
