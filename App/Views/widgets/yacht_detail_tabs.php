<?php if (isset($Extras) && $Extras): ?>
	<div class="container py-3 py-lg-5">
			<div class="row px-4 px-lg-0">
					<div class="col-12">
							<ul class="tabs nav nav-pills mb-3 border-bottom pb-2" id="pills-tab" role="tablist">
									<li class="nav-item mr-2">
											<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#amenities" role="tab"
													aria-controls="pills-home" aria-selected="true"><?=read_translate('amenities')?></a>
									</li>
									<li class="nav-item">
											<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#entertaintment" role="tab"
													aria-controls="pills-profile" aria-selected="false"><?=read_translate('entertaintment')?></a>
									</li>
							</ul>
							<div class="tab-content" id="pills-tabContent">
									<div class="tab-pane fade show active" id="amenities" role="tabpanel" aria-labelledby="amenities">
											<div class="row px-2 px-lg-0">
													<?php if (@$Extras['wifi'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/wifi.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('wifi')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['bathub'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/bathtub.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('bathub')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['hairdryer'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/hair.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('hairdryer')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['no_smoking'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/nosmokin.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('no_smoking')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['room_safe'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/room.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('room_safe')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['towels'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/towel.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('towels')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['cleaning'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/cleaning.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('cleaning')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['tv'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/tv.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('tv')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['air_cond'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/air.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('air_cond')?></div>
															</div>
													</div>
													<?php endif; ?>
											</div>
									</div>
									<div class="tab-pane fade" id="entertaintment" role="tabpanel"
											aria-labelledby="entertaintment">
											<div class="row px-2 px-lg-0">
													<?php if (@$Extras['2x_flyboard'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/flyboard.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('2x_flyboard')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['2x_jetsurfs'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/jetsutf.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('2x_jetsurfs')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['3x_sup'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/paddle.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('3x_sup')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['2x_f7'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/seabobs.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('2x_f7')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['1x_waterslide'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/Slide.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('1x_waterslide')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['u_tube'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/Utubbe.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('u_tube')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['banana'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/banana.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('banana')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['water_ski'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/waterski.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('water_ski')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['wake_board'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/wakeboard.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('wake_board')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['knee_board'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/kneeboard.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('knee_board')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['1x_person_kayak'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/personkayak.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('1x_person_kayak')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['fishing_equip'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/fishing.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('fishing_equip')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['snorkel_equip'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/snorkelling.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('snorkel_equip')?></div>
															</div>
													</div>
													<?php endif; ?>
													<?php if (@$Extras['water_toy'] == '1'): ?>
													<div class="col-12 col-lg-2 tab-item">
															<div class="d-flex align-items-center">
																	<img src="<?=site_url('assets')?>/dist/img/watertoy.svg" alt="">
																	<div class="tab-item-title ml-2"><?=read_translate('water_toy')?></div>
															</div>
													</div>
													<?php endif; ?>
											</div>
									</div>

							</div>
					</div>
			</div>
	</div>
<?php endif; ?>
