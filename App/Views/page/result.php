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
<?=public_view('widgets/breadcrumb', [
	'title' => read_translate('sonuc_sayfa_basligi')
]);?>
<!-- result -->

<!-- result -->
<div class="container-fluid selected-yatch py-2 py-lg-5 pb-3">
	<div class="row mx-2 mx-lg-0">
		<div class="container">
			<?php
			if ($status == 'success') {
				public_view('widgets/message_success', [
					'message' => $message ?? null,
					'description' => $description ?? null
				]);
			} else {
				public_view('widgets/message_error', [
					'message' => $message ?? null,
					'description' => $description ?? null
				]);
			}
			?>
		</div>
	</div>
</div>
<!-- result -->

<?php if (isset($footer)) {
	$data['border_top'] = 1;
	public_view('footer', $data);
} ?>
