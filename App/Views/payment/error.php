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
			<?php if (isset($odeme_sonucu['banka_hata']['msg'])): ?>
			<p class="bg-danger text-white p-3 mt-3 mb-0" style="border-radius: 4px;"><?=$odeme_sonucu['banka_hata']['msg']?></p>
			<?php endif; ?>

			<?php if (isset($odeme_sonucu['hata'])): ?>
				<?php foreach ($odeme_sonucu['hata'] as $key => $hata): ?>
					<?php if (isset($hata['mesaj'])): ?>
					<p class="bg-danger text-white mt-3 mb-0" style="border-radius: 4px;"><?=$hata['mesaj']?></p>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>

			<?php
			public_view('widgets/message_error', [
				'message' => read_translate('odeme_basarisiz'),
				'description' => read_translate('odeme_basarisiz_aciklama'),
				'class' => 'pt-3'
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
