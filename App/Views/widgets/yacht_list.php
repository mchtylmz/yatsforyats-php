<div class="container-fluid border-bottom border-top">
	<div class="row align-items-stretch yatlar py-3 px-0" style="padding-top: 0 !important; padding-bottom: 0 !important;">
			<div class="offset-lg-1 col-lg-7 col-12 order-lg-0 order-1 yatlar-liste p-4">
					<div class="d-flex align-items-center justify-content-between">
							<div class="sehir-adi">
								<?php if (isset($filter_region) && $filter_region && !$filter_notfound): ?>
								<?=$filter_region?>
								<?php elseif (isset($filter_notfound) && $filter_notfound) : ?>
								<?=read_translate('yat_filtre_sonuc_bulunamadı')?>
								<?php else: ?>
								<?=read_translate('tum_yatlar')?>
								<?php endif; ?>
							</div>
							<div class="justify-self-end sehir-yat-sayisi px-3 py-1">
									<p class="mb-0"><?=$all_yachts['total'] ?? 0?> <?=read_translate('yat')?></p>
							</div>
					</div>

					<div class="row mt-3">
						<?php if (isset($all_yachts['yachts']) && $all_yachts['yachts']): ?>
						<?php foreach ($all_yachts['yachts'] as $key => $yacht): ?>
						<?=public_view('widgets/yacht_card', ['yacht' => $yacht], null, true);?>
						<?php endforeach; ?>
						<?php else: ?>
						<!-- Sonuç Bulunamadı -->
						<?=public_view('widgets/yacht_not_result', $data, null, true);?>
						<!-- Sonuç Bulunamadı -->
						<?php endif; ?>
						<!-- Sayfalama -->
						<?php if ($all_yachts['total'] > 0): ?>
							<?=public_view('widgets/yacht_pagination', [
								'page'  => $all_yachts['page'],
								'total' => $all_yachts['total'],
								'limit' => $all_yachts['limit'],
							]);?>
						<?php elseif(isset($notype_yachts['total']) && isset($notype_yachts['yachts'])): ?>
							<?=public_view('widgets/notype_yachts', [
								'notype_yachts' => $notype_yachts
							]);?>
						<?php endif; ?>
						<!-- Sayfalama -->
					</div>
			</div>
			<!-- Normal Map -->
			<?=public_view('widgets/desktop_map', $data);?>
			<!-- Normal Map -->
	</div>
</div>
