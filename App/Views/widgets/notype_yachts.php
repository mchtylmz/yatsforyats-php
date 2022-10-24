<?php if (isset($notype_yachts)): ?>
<div class="col-lg-12 mb-3">
	<hr>
</div>
<div class="col-lg-12 mb-3">
	<div class="d-flex align-items-center justify-content-between">
			<div class="sehir-adi">
				<?=read_translate('bolge_diger_yatlar')?>
			</div>
			<div class="justify-self-end sehir-yat-sayisi px-3 py-1">
					<p class="mb-0"><?=$notype_yachts['total'] ?? 0?> <?=read_translate('yat')?></p>
			</div>
	</div>
	<br>
</div>
<?php if ($notype_yachts['yachts']): ?>
	<?php foreach ($notype_yachts['yachts'] as $key => $yacht): ?>
	<?=public_view('widgets/yacht_card', ['yacht' => $yacht], null, true);?>
	<?php endforeach; ?>
<?php else: ?>
	<!-- Sonuç Bulunamadı -->
	<?=public_view('widgets/yacht_not_result', $data, null, true);?>
	<!-- Sonuç Bulunamadı -->
<?php endif; ?>
<?=public_view('widgets/yacht_pagination', [
	'page'  => $notype_yachts['page'],
	'total' => $notype_yachts['total'],
	'limit' => $notype_yachts['limit'],
]);?>
<?php endif; ?>
