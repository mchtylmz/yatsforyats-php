<div class="container border-bottom">
	<div class="row align-items-stretch yatlar py-3 px-0" style="padding-top: 0 !important; padding-bottom: 0 !important;">
			<div class="col-lg-12 col-12 order-lg-0 order-1 yatlar-liste p-4">

					<div class="row mt-3">
						<?php if (isset($buy_yachts['yachts']) && $buy_yachts['yachts']): ?>
						<?php foreach ($buy_yachts['yachts'] as $key => $yacht): ?>
						<?=public_view('widgets/buy_yacht_card', ['yacht' => $yacht], null, true);?>
						<?php endforeach; ?>
						<?php else: ?>
						<!-- Sonuç Bulunamadı -->
						<?=public_view('widgets/yacht_not_result', $data, null, true);?>
						<!-- Sonuç Bulunamadı -->
						<?php endif; ?>
						<!-- Sayfalama -->
						<?php if ($buy_yachts['total'] > 0): ?>
							<?=public_view('widgets/yacht_pagination', [
								'page'  => $buy_yachts['page'],
								'total' => $buy_yachts['total'],
								'limit' => $buy_yachts['limit'],
							]);?>
						<?php endif; ?>
						<!-- Sayfalama -->
					</div>
			</div>
	</div>
</div>
