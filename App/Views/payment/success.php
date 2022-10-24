<?php if (isset($header)) {
	public_view('header', $data);
}
?>
<div class="container-fluid">
	<?=public_view('sidebar/main_menu', [
		'light' => 1
	]);?>
</div>

<!-- result -->
<div class="container-fluid selected-yatch py-2 py-lg-5 pb-3">
	<div class="row mx-2 mx-lg-0">
		<div class="container">
			<?php
			public_view('widgets/message_success', [
				'message' => read_translate('odeme_basarili'),
				'description' => read_translate('odeme_basarili_aciklama')
			]);
			?>
		</div>
	</div>
</div>
<!-- result -->

<?php if (isset($footer)) {
	$data['border_top'] = 1;
	public_view('footer', $data);
} ?>
