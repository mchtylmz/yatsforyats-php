<?php if (isset($BlogDetail) && $BlogDetail): ?>
	<style media="screen">
		.yat-detay-slider .item .yat-item-detaylar {
			background: linear-gradient(181.06deg,rgba(10,17,36,0) .191%,#0A1124 200.47%);
		}
	</style>
	<div class="container px-lg-0 mt-0">
			<div class="yat-detay-header">
					<div class="d-flex justify-content-between align-items-center border-bottom py-4 px-3">
							<div class="d-flex flex-column flex-lg-row align-items-lg-center">
									<div class="yat-adi mr-2"><?=lang_text($BlogDetail['b_title_tr'], $BlogDetail['b_title_en'], $BlogDetail['b_title_ru'])?></div>
							</div>
							<div class="d-flex align-items-center">
									<div class="gunluk d-flex flex-column flex-lg-row align-items-center">
											<div class="fiyat mr-2 text-dark">
													<small><?=lang_text(turkish_long_date('l, j F Y', $BlogDetail['b_added']), date('l, j F Y', strtotime($BlogDetail['b_added'])))?></small>
											</div>
									</div>
							</div>
					</div>
			</div>
	</div>
	<div class="container yat-detay-content ck-content mt-0 py-0">
			<div class="row">
					<div class="col-lg-12 text-contents">
						<div class="section">
								<p><?=html_entity_decode(lang_text($BlogDetail['b_content_tr'], $BlogDetail['b_content_en'], $BlogDetail['b_content_ru']))?></p>
						</div>
					</div>
			</div>
	</div>
<?php endif; ?>
