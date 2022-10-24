<?php if (isset($Yacht) && $Yacht): ?>
<div class="container yat-detay-content ck-content mt-5 py-5 <?=@$feature_if || @$gallery_if ? 'border-bottom':''?>">
		<div class="row">
				<div class="col-lg-8 text-contents">
						<?php if (@$Yacht['yc_cabin_conf_tr'] || @$Yacht['yc_cabin_conf_en']): ?>
						<div class="section">
								<div class="title"><?=read_translate('cabin_configuration')?></div>
								<p><?=lang_text($Yacht['yc_cabin_conf_tr'], $Yacht['yc_cabin_conf_en'], $Yacht['yc_cabin_conf_ru'])?></p>
						</div>
						<?php endif; ?>
						<br>
						<?php if (@$Yacht['yc_crew_conf_tr'] || @$Yacht['yc_crew_conf_en']): ?>
						<div class="section">
								<div class="title"><?=read_translate('crew_configuration')?></div>
								<p><?=lang_text($Yacht['yc_crew_conf_tr'], $Yacht['yc_crew_conf_en'], $Yacht['yc_crew_conf_ru'])?></p>
						</div>
						<?php endif; ?>
						<br>
						<div class="section">
								<div class="title"><?=read_translate('yacht_info')?></div>
								<p class=""><?=html_entity_decode(lang_text($Yacht['yc_content_tr'], $Yacht['yc_content_en'], $Yacht['yc_content_ru']))?></p>
						</div>
				</div>
				<div class="col-lg-4">
					<?php if ($Yacht['yc_status'] == 'rent'): ?>
						<div class="section">
							<style media="screen">
								div.zabuto_calendar .table tr.calendar-month-header td {
									vertical-align: bottom !important;
									border-top: none !important;
								}
							</style>
							<div class="title"><?=read_translate('charter_rates')?></div>
							<div id="my-calendar" class="mb-4"></div>
							  <?php /*
								<?php if (@$Yacht['yc_summer_price']): ?>
								<div class="box border p-3 d-flex justify-between">
										<div class="box-infos">
												<div class="season"><?=read_translate('yaz')?></div>
												<div class="season-exp"><?=read_translate('p_week')?> + <?=read_translate('expenses')?></div>
												<div class="approx"><?=read_translate('approx')?> <span><?=$Yacht['yc_currency']?><?=$Yacht['yc_summer_price']?></span></div>
										</div>
										<div class="box-icon" style="display: grid; place-content: center; margin-left: auto;">
												<img class="mr-3" src="<?=site_url('assets')?>/dist/img/sun 1.svg">
										</div>
								</div>
								<?php endif; ?>
								<?php if (@$Yacht['yc_winter_price']): ?>
								<div class="box mt-3 border p-3 d-flex justify-between">
										<div class="box-infos">
												<div class="season"><?=read_translate('kis')?></div>
												<div class="season-exp"><?=read_translate('p_week')?> + <?=read_translate('expenses')?></div>
												<div class="approx"><?=read_translate('approx')?> <span><?=$Yacht['yc_currency']?><?=$Yacht['yc_summer_price']?></span></div>
										</div>
										<div class="box-icon" style="display: grid; place-content: center; margin-left: auto;">
												<img class="mr-3" src="<?=site_url('assets')?>/dist/img/sun 1.svg">
										</div>
								</div>
								<?php endif; ?>
								*/ ?>
						</div>
						<?php endif; ?>

						<div class="section mt-4">
								<div class="title"><?=read_translate('specifications')?></div>
								<div class="specifications-box border">
										<?php if ($type = get_type_by_id($Yacht['yc_type_id'] ?? 0)): ?>
											<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
													<div class="spec-title"><?=read_translate('yat_turu')?></div>
													<div class="spec-info"><?=lang_text($type['type_title_tr'], $type['type_title_en'])?></div>
											</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_brand']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('brand')?></div>
												<div class="spec-info"><?=$Yacht['yc_brand']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_length']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('length')?></div>
												<div class="spec-info"><?=$Yacht['yc_length']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_beam']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('beam')?></div>
												<div class="spec-info"><?=$Yacht['yc_beam']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_draft']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('draft')?></div>
												<div class="spec-info"><?=$Yacht['yc_draft']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_year']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('year')?></div>
												<div class="spec-info"><?=$Yacht['yc_year']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_boy']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('boy')?></div>
												<div class="spec-info"><?=$Yacht['yc_boy']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_en']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('en')?></div>
												<div class="spec-info"><?=$Yacht['yc_en']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_govde']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('govde')?></div>
												<div class="spec-info"><?=$Yacht['yc_govde']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_yatak']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('yatak')?></div>
												<div class="spec-info"><?=$Yacht['yc_yatak']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_motor_marka']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('motor_marka')?></div>
												<div class="spec-info"><?=$Yacht['yc_motor_marka']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_motor_adet']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('motor_adet')?></div>
												<div class="spec-info"><?=$Yacht['yc_motor_adet']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_motor_gucu']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('motor_gucu')?></div>
												<div class="spec-info"><?=$Yacht['yc_motor_gucu']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_yakit']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('yakit')?></div>
												<div class="spec-info"><?=$Yacht['yc_yakit']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_calisma']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('govde')?></div>
												<div class="spec-info"><?=$Yacht['yc_calisma']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_flybridge']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('flybridge')?></div>
												<div class="spec-info"><?=$Yacht['yc_flybridge']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_bandra']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('bandra')?></div>
												<div class="spec-info"><?=$Yacht['yc_bandra']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_tonnage']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('gross_tonnage')?></div>
												<div class="spec-info"><?=$Yacht['yc_tonnage']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_speed']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('cruising_speed')?></div>
												<div class="spec-info"><?=$Yacht['yc_speed']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_max_speed']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('max_speed')?></div>
												<div class="spec-info"><?=$Yacht['yc_max_speed']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_built']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('built')?></div>
												<div class="spec-info"><?=$Yacht['yc_built']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_builder']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('builder')?></div>
												<div class="spec-info"><?=$Yacht['yc_builder']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_model']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('model')?></div>
												<div class="spec-info"><?=$Yacht['yc_model']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_edesigner']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('exterior_designer')?></div>
												<div class="spec-info"><?=$Yacht['yc_edesigner']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_idesigner']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('interior_design')?></div>
												<div class="spec-info"><?=$Yacht['yc_idesigner']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_bulundugu_yer']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('bulundugu_yer')?></div>
												<div class="spec-info"><?=$Yacht['yc_bulundugu_yer']?></div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_kimden']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('kimden')?></div>
												<div class="spec-info">
													<?php if ($Yacht['yc_kimden'] == '1'): ?>
														<?=read_translate('kimden_magazadan')?>
													<?php endif; ?>
													<?php if ($Yacht['yc_kimden'] == '2'): ?>
														<?=read_translate('kimden_sahibinden')?>
													<?php endif; ?>
												</div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_takas']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('takas')?></div>
												<div class="spec-info">
													<?php if ($Yacht['yc_takas'] == '1'): ?>
														<?=lang_text('Evet', 'Yes', 'Da')?>
													<?php endif; ?>
													<?php if ($Yacht['yc_takas'] == '2'): ?>
														<?=lang_text('Hayır', 'No', 'Net')?>
													<?php endif; ?>
												</div>
										</div>
										<?php endif; ?>
										<?php if (@$Yacht['yc_durum']): ?>
										<div class="spec-item px-2 px-lg-3 py-2 d-flex justify-content-between align-items-center">
												<div class="spec-title"><?=read_translate('durum')?></div>
												<div class="spec-info">
													<?php if ($Yacht['yc_durum'] == '1'): ?>
														<?=read_translate('durum_sıfır')?>
													<?php endif; ?>
													<?php if ($Yacht['yc_durum'] == '2'): ?>
														<?=read_translate('durum_ikinciel')?>
													<?php endif; ?>
													<?php if ($Yacht['yc_durum'] == '3'): ?>
														<?=read_translate('durum_diger')?>
													<?php endif; ?>
												</div>
										</div>
										<?php endif; ?>

								</div>
						</div>
				</div>
		</div>
</div>
<?php endif; ?>
