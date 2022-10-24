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
	'title' => lang_text(site_setting('privacy_page_title_tr'), site_setting('privacy_page_title_en'), site_setting('privacy_page_title_ru'))
]);?>
<!-- breadcrumb -->

<div class="container py-5">
		<div class="row align-items-center">
				<div class="col-lg-12 col-12">
						<p class="hakkimizda-detail-desc ck-content"><?=html_entity_decode(lang_text(site_setting('privacy_page_content_tr'), site_setting('privacy_page_content_en'), site_setting('privacy_page_content_ru')))?></p>
				</div>
		</div>
</div>

<?php if (isset($footer)) {
	$data['border_top'] = 1;
	public_view('footer', $data);
} ?>
