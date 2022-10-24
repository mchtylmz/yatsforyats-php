<div class="container">
		<div class="row">
				<div class="col-12">
						<div class="contact-slider mt-2 px-3 px-lg-5 bg-white rounded py-5"
								style="overflow: hidden; min-width: 100%; width: 0;">
								<div class="item">
										<div class="row px-1 mx-0">
												<div class="col-12 px-0">
														<div
																class="d-flex flex-column flex-lg-row align-items-center justify-content-center justify-content-lg-start">
																<img class="mb-4 mb-lg-0" src="<?=site_url('assets')?>/dist/img/home 2.svg">
																<div class="ml-lg-3 d-flex flex-column">
																		<div class="contact-title mb-3 text-center text-lg-left"><?=read_translate('merkez_ofis')?></div>
																		<div class="contact-desc text-center text-lg-left">
																			<?=lang_text(site_setting('merkez_ofis_tr'), site_setting('merkez_ofis_en'), site_setting('merkez_ofis_ru'))?>
																		</div>
																</div>
														</div>
												</div>
										</div>
								</div>
								<div class="item">
										<div class="row px-1 mx-0">
												<div class="col-12 px-0">
														<div
																class="d-flex flex-column flex-lg-row align-items-center justify-content-center justify-content-lg-center">
																<img class="mb-4 mb-lg-0" src="<?=site_url('assets')?>/dist/img/mail.svg">
																<div class="ml-lg-3 d-flex flex-column">
																		<div class="contact-title mb-3 text-center text-lg-left"><?=read_translate('mail_adresi')?></div>
																		<div class="contact-desc text-center text-lg-left">
																			<?=lang_text(site_setting('mail_address_tr'), site_setting('mail_address_en'), site_setting('mail_address_ru'))?>
																		</div>
																</div>
														</div>
												</div>
										</div>
								</div>
								<?php if (site_setting('phone_number_tr')): ?>
								<div class="item">
										<div class="row px-1 mx-0 justify-content-end">
												<div class="col-12 px-0">
														<div
																class="d-flex flex-column flex-lg-row align-items-center justify-content-center justify-content-lg-end">
																<img class="mb-4 mb-lg-0" src="<?=site_url('assets')?>/dist/img/phone-incoming 1.svg">
																<div class="ml-lg-3 d-flex flex-column">
																		<div class="contact-title mb-3 text-center text-lg-left"><?=read_translate('telefon_numarasi')?></div>
																		<div class="contact-desc text-center text-lg-left">
																			<?php
																			$numaralar = explode('/', lang_text(site_setting('phone_number_tr'), site_setting('phone_number_en'), site_setting('phone_number_ru')));
																			if (count($numaralar) <= 1) {
																				$numaralar = explode(',', lang_text(site_setting('phone_number_tr'), site_setting('phone_number_en'), site_setting('phone_number_ru')));
																			}
																			if ($numaralar) {
																				for ($i = 0; $i < count($numaralar); $i++) {
																					echo '<a style="margin-right: 10px; color: #222; text-decoration: underline" href="tel:'.trim($numaralar[$i]).'">' . trim($numaralar[$i]) . '</a>';
																					if ($i < count($numaralar) -1 ) {
																						echo '<br>';
																					}
																				}
																			} else {
																				echo lang_text(site_setting('phone_number_tr'), site_setting('phone_number_en'), site_setting('phone_number_ru'));
																			}
																			?>
																		</div>
																</div>
														</div>
												</div>
										</div>
								</div>
								<?php endif; ?>
						</div>
				</div>
		</div>
</div>
