<div class="container border-bottom border-top">
	<div class="row align-items-center yatlar py-3 px-0" style="padding-top: 0 !important; padding-bottom: 0 !important;">
			<div class="col-12  yatlar-liste p-4">
					<div class="d-flex align-items-center justify-content-between">
							<div class="sehir-adi"><?=read_translate('blogs')?></div>
							<div class="justify-self-end sehir-yat-sayisi px-3 py-1">
									<p class="mb-0"><?=$blogs['total'] ?? 0?> <?=read_translate('blog')?></p>
							</div>
					</div>

					<div class="row mt-3">
						<?php if (isset($blogs['blogs']) && $blogs['blogs']): ?>
						<?php foreach ($blogs['blogs'] as $key => $blog): ?>
						<div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-4">
							<div class="yat-card card border rounded-none">
									<img class="card-img-top w-100 blimage" src="<?=uploads_url(lang_text($blog['b_image_tr'], $blog['b_image_en'], $blog['b_image_ru']))?>"
											 alt="<?=lang_text($blog['b_title_tr'], $blog['b_title_en'], $blog['b_title_ru'])?>" style="object-fit:cover;">
									<div class="card-body pt-0 pb-0 pr-0 pl-3">
										<div class="d-flex justify-content-between align-items-center px-2 px-lg-2 pt-2 mt-1 mt-lg-0 pb-lg-3">
												<div>
														<div class="yat-adi">
															<?=lang_text($blog['b_title_tr'], $blog['b_title_en'], $blog['b_title_ru'])?>
														</div>
														<div class="yat-marka-yil" style="opacity:0.7; font-size: 14px; font-weight: 500; margin-top: 5px">
															<?=lang_text(turkish_long_date('l, j F Y', $blog['b_added']), date('l, j F Y', strtotime($blog['b_added'])))?>
														</div>
												</div>
										</div>
										<div class="text-left pl-2" style="margin-bottom: 10px;">
											<a href="<?=lang_site_url(generate_permalink(lang_text($blog['b_title_tr'], $blog['b_title_en'], $blog['b_title_ru'])) .'/blog-'. $blog['b_id'])?>" class="btn btn-sm btn-site btn-primary"><?=read_translate('devamini_oku')?></a>
										</div>
									</div>
							</div>
						</div>
						<?php endforeach; ?>
						<?php else: ?>
						<!-- Sonuç Bulunamadı -->
						<?=public_view('widgets/blog_not_result', $data);?>
						<!-- Sonuç Bulunamadı -->
						<?php endif; ?>
						<!-- Sayfalama -->
						<?=public_view('widgets/blog_pagination', [
							'page'  => $blogs['page'],
							'total' => $blogs['total'],
							'limit' => $blogs['limit'],
						]);?>
						<!-- Sayfalama -->
					</div>
			</div>
	</div>
</div>
