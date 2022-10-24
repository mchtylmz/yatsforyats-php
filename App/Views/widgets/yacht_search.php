<!-- Mobil Search -->
<form role="form" action="<?=lang_site_url(lang_text('yatlar', 'yachts' ,'yakhty'))?>" method="GET">
<div class="container-fluid mobile-search d-block d-lg-none">
		<div class="row py-2">
				<div class="col-3 border-right">
						<div class="dropdown-collapse d-flex justify-content-center align-items-center" data-toggle="collapse"
								data-target="#bolge" aria-controls="bolge">
								<img src="<?=site_url('assets')?>/dist/img/location.svg" alt="">
								<a class="btn btn-white d-flex justify-content-between w-100 text-left" id="mobil_bolge" aria-expanded="false">
										<span class="text-truncate">
											<?php if (isset($filter_region) && $filter_region): ?>
											<?=$filter_region?>
											<?php else: ?>
											<?=read_translate('mobil_bolge_secin')?>
											<?php endif; ?>
										</span>
								</a>
						</div>
				</div>
				<div class="col-3 border-right">
						<div class="dropdown-collapse d-flex justify-content-center align-items-center">
								<img src="<?=site_url('assets')?>/dist/img/ice.svg" alt="">
								<a class="btn btn-white d-flex justify-content-between w-100 text-left" id="mobil_zaman">
									<span class="text-truncate">
										<?php if (get('period_start') && get('period_end')): ?>
										<?=date('d/m', strtotime(get('period_start')))?>/<?=date('d/m', strtotime(get('period_end')))?>
										<?php else: ?>
										<?=read_translate('tarih_sec')?>
										<?php endif; ?>
									</span>
									<input type="hidden" class="form-control datepicker" id="mobil_date">
								</a>
						</div>
				</div>
				<div class="col-3 border-right">
						<div class="dropdown-collapse d-flex justify-content-center align-items-center" data-toggle="collapse"
								data-target="#kisi" aria-controls="kisi">
								<img src="<?=site_url('assets')?>/dist/img/users.svg" alt="">
								<a class="btn btn-white d-flex justify-content-between w-100 text-left" id="mobil_kisi" aria-expanded="false">
									<span class="text-truncate">
										<?php if (isset($filter_person) && $filter_person): ?>
										<?=$filter_person?> <?=read_translate('yetiskin')?>
										<?php else: ?>
										1 <?=read_translate('yetiskin')?>
										<?php endif; ?>
									</span>
								</a>
						</div>
				</div>
				<div class="col-3">
						<div class="dropdown-collapse d-flex justify-content-center align-items-center" data-toggle="collapse"
								data-target="#yat" aria-controls="yat">
								<img src="<?=site_url('assets')?>/dist/img/yat.svg" alt="">
								<a class="btn btn-white d-flex justify-content-between w-100 text-left" id="mobil_tur" aria-expanded="false">
									<span class="text-truncate">
										<?php if (isset($filter_type) && $filter_type): ?>
										<?=$filter_type?>
										<?php else: ?>
										<?=read_translate('mobil_yat_turu')?>
										<?php endif; ?>
									</span>
								</a>
						</div>
				</div>
				<div class="col-12">
				    <button type="submit" class="btn btn-info w-100 mt-2"><?=read_translate('arama_yap')?></button>
				</div>
		</div>
</div>

<!-- Mobil Search Items -->
<div class="container-fluid px-0 d-block">
		<div class="collapse collapse-search-items" id="bolge">
				<?php foreach (all_regions() as $key => $region): ?>
				<a class="collapse-search-item d-flex align-items-center justify-content-between px-2 py-3" href="javascript:void(0)"
				onclick="filter_region('<?=lang_text($region['tr_title'], $region['en_title'], $region['ru_title'])?>', '<?=$region['id']?>')">
						<div class="left-info pl-3"><?=lang_text($region['tr_title'], $region['en_title'], $region['ru_title'])?></div>
				</a>
				<?php endforeach; ?>
		</div>
		<div class="collapse collapse-search-items" id="zaman">
				<a class="collapse-search-item d-flex align-items-center justify-content-between px-2 py-3" href="javascript:void(0)"
				onclick="filter_period('<?=read_translate('yaz')?>', '1')">
						<div class="left-info pl-3"><?=read_translate('yaz')?></div>
				</a>
				<a class="collapse-search-item d-flex align-items-center justify-content-between px-2 py-3" href="javascript:void(0)"
				onclick="filter_period('<?=read_translate('kis')?>', '0')">
						<div class="left-info pl-3"><?=read_translate('kis')?></div>
				</a>
		</div>
		<div class="collapse collapse-search-items" id="kisi">
			<?php for ($pr = 1; $pr <= 5; $pr++) : ?>
				<a class="collapse-search-item d-flex align-items-center justify-content-between px-2 py-3" href="javascript:void(0)"
				onclick="filter_person('<?=$pr?>', '<?=$pr?>')">
						<div class="left-info pl-3"><?=$pr?> <?=read_translate('yetiskin')?></div>
				</a>
			<?php endfor; ?>
			<a class="collapse-search-item d-flex align-items-center justify-content-between px-2 py-3" href="javascript:void(0)"
			onclick="filter_person('5-10', '6')">
					<div class="left-info pl-3">5 - 10 <?=read_translate('yetiskin')?></div>
			</a>
			<a class="collapse-search-item d-flex align-items-center justify-content-between px-2 py-3" href="javascript:void(0)"
			onclick="filter_person('10+', '11')">
					<div class="left-info pl-3">10 <?=read_translate('yetiskin')?> <?=read_translate('ve_uzeri')?></div>
			</a>
		</div>
		<div class="collapse collapse-search-items" id="yat">
				<a class="collapse-search-item d-flex align-items-center justify-content-between px-2 py-3" href="javascript:void(0)"
				onclick="filter_type('<?=lang_text('Tüm Yatlar', 'All Yachts', 'Vse yakhty')?>', '')">
						<div class="left-info pl-3"><?=lang_text('Tüm Yatlar', 'All Yachts')?></div>
				</a>
				<?php foreach (all_yacht_types() as $key => $type): ?>
					<a class="collapse-search-item d-flex align-items-center justify-content-between px-2 py-3" href="javascript:void(0)"
					onclick="filter_type('<?=lang_text($type['type_title_tr'], $type['type_title_en'], $type['type_title_ru'])?>', '<?=$type['type_id']?>')">
							<div class="left-info pl-3"><?=lang_text($type['type_title_tr'], $type['type_title_en'], $type['type_title_ru'])?></div>
					</a>
				<?php endforeach; ?>
		</div>
</div>

<!-- Desktop Search -->
<div class="container search-area-row mb-3 mt-3 d-none d-lg-block">
		<div class="row align-items-center search-area yats py-0 py-lg-3 px-1 px-lg-2 border">
				<div class="col-12 col-lg search-col">
						<div class="dropdown d-flex d-lg-block align-items-center py-2 py-lg-0">
								<img class="d-block d-lg-none" src="<?=site_url('assets')?>/dist/img/location.svg" alt="">
								<label class="dropdown-label d-none d-lg-block"><?=read_translate('bölge_secin')?></label>
								<a class="btn btn-white d-flex dropdown-toggle justify-content-between w-100 text-left mb-0 pl-2 pl-lg-0"
										href="#" role="button" id="dropdownRegion" data-toggle="dropdown" aria-haspopup="true"
										aria-expanded="false">
										<span class="text-truncate">
											<?php if (isset($filter_region) && $filter_region): ?>
											<?=$filter_region?>
											<?php else: ?>
											<?=read_translate('bölge_secin')?>
											<?php endif; ?>
										</span>
										<i class="fa fa-chevron-down"></i>
								</a>

								<div class="dropdown-menu" aria-labelledby="dropdownRegion">
									<?php foreach (all_regions() as $key => $region): ?>
										<a class="dropdown-item" href="javascript:void(0)"
										onclick="filter_region('<?=lang_text($region['tr_title'], $region['en_title'], $region['ru_title'])?>', '<?=$region['id']?>')">
											<?=lang_text($region['tr_title'], $region['en_title'], $region['ru_title'])?>
										</a>
									<?php endforeach; ?>
								</div>
						</div>
				</div>
				<div class="col-12 col-lg search-col">
						<div class="dropdown d-flex d-lg-block align-items-center py-2 py-lg-0">
								<img class="d-block d-lg-none" src="<?=site_url('assets')?>/dist/img/ice.svg" alt="">
								<label class="dropdown-label d-none d-lg-block"><?=read_translate('zaman_secin')?></label>
								<a class="btn btn-white d-flex dropdown-toggle justify-content-between w-100 text-left mb-0 pl-2 pl-lg-0"
										href="javascript:void(0)" role="button" id="dropdownPeriod">
										<span class="text-truncate">
											<?php if (get('period_start') && get('period_end')): ?>
											<?=date('d/m', strtotime(get('period_start')))?>/<?=date('d/m', strtotime(get('period_end')))?>
											<?php else: ?>
											<?=read_translate('tarih_sec')?>
											<?php endif; ?>
										</span>
										<i class="fa fa-chevron-down"></i>
										<input type="hidden" class="form-control datepicker" id="pc_date">
								</a>

								<div class="dropdown-menu" aria-labelledby="dropdownPeriod">
									<a class="dropdown-item" href="javascript:void(0)"
									onclick="filter_period('<?=read_translate('yaz')?>', '1')">
										<?=read_translate('yaz')?>
									</a>
									<a class="dropdown-item" href="javascript:void(0)"
									onclick="filter_period('<?=read_translate('kis')?>', '0')">
										<?=read_translate('kis')?>
									</a>
								</div>
						</div>
				</div>
				<div class="col-12 col-lg search-col">
						<div class="dropdown d-flex d-lg-block align-items-center py-2 py-lg-0">
								<img class="d-block d-lg-none" src="<?=site_url('assets')?>/dist/img/users.svg" alt="">
								<label class="dropdown-label d-none d-lg-block"><?=read_translate('kisi_sayisi')?></label>
								<a class="btn btn-white d-flex dropdown-toggle justify-content-between w-100 text-left mb-0 pl-2 pl-lg-0"
										href="#" role="button" id="dropdownPerson" data-toggle="dropdown" aria-haspopup="true"
										aria-expanded="false">
										<span class="text-truncate">
											<?php if (isset($filter_person) && $filter_person): ?>
											<?=$filter_person?> <?=lang_text('Kişi', 'Person')?>
											<?php else: ?>
											1 <?=lang_text('Kişi', 'Person')?>
											<?php endif; ?>
										</span>
										<i class="fa fa-chevron-down"></i>
								</a>

								<div class="dropdown-menu" aria-labelledby="dropdownPerson">
									<?php for ($pr = 1; $pr <= 5; $pr++) : ?>
									<a class="dropdown-item" href="javascript:void(0)"
									onclick="filter_person('<?=$pr?>', '<?=$pr?>')">
										<?=$pr?> <?=lang_text('Kişi', 'Person', 'v')?>
									</a>
									<?php endfor; ?>
									<a class="dropdown-item" href="javascript:void(0)"
									onclick="filter_person('5-10', '6')">
										5 - 10 <?=lang_text('Kişi', 'Person', 'Chelovek')?>
									</a>
									<a class="dropdown-item" href="javascript:void(0)"
									onclick="filter_person('10+', '11')">
										10 <?=lang_text('Kişi', 'Person', 'Chelovek')?> <?=read_translate('ve_uzeri')?>
									</a>
								</div>
						</div>
				</div>
				<div class="col-12 col-lg search-col">
						<div class="dropdown d-flex d-lg-block align-items-center py-2 py-lg-0">
								<img class="d-block d-lg-none" src="<?=site_url('assets')?>/dist/img/users.svg" alt="">
								<label class="dropdown-label d-none d-lg-block"><?=lang_text('Yatlar', 'Yachts', 'Yakhty')?></label>
								<a class="btn btn-white d-flex dropdown-toggle justify-content-between w-100 text-left mb-0 pl-2 pl-lg-0"
										href="#" role="button" id="dropdownType" data-toggle="dropdown" aria-haspopup="true"
										aria-expanded="false">
										<span class="text-truncate">
											<?php if (isset($filter_type) && $filter_type): ?>
											<?=$filter_type?>
											<?php else: ?>
											<?=read_translate('yat_turu')?>
											<?php endif; ?>
										</span>
										<i class="fa fa-chevron-down"></i>
								</a>

								<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
										<a class="dropdown-item" href="javascript:void(0)"
										onclick="filter_type('<?=lang_text('Tüm Yatlar', 'All Yachts', 'Vse yakhty')?>', '')">
												<?=lang_text('Tüm Yatlar', 'All Yachts', 'Vse yakhty')?>
										</a>
										<?php foreach (all_yacht_types() as $key => $type): ?>
											<a class="dropdown-item" href="javascript:void(0)"
											onclick="filter_type('<?=lang_text($type['type_title_tr'], $type['type_title_en'], $type['type_title_ru'])?>', '<?=$type['type_id']?>')">
												<?=lang_text($type['type_title_tr'], $type['type_title_en'], $type['type_title_ru'])?>
											</a>
										<?php endforeach; ?>
								</div>
						</div>
				</div>
				<div class="col-12 col-lg d-none d-lg-flex justify-content-center">
						<button type="submit" class="btn btn-info w-100 py-2 text-center"><?=read_translate('arama_yap')?></button>
				</div>
		</div>
</div>
<input type="hidden" name="region" id="region" value="<?=$input_region ?? ''?>">
<input type="hidden" name="person" id="person" value="<?=$input_person ?? '1'?>">
<input type="hidden" name="period_start" id="period_start" value="<?=$input_period_start ?? get('period_start')?>">
<input type="hidden" name="period_end" id="period_end" value="<?=$input_period_end ?? get('period_end')?>">
<input type="hidden" name="type" id="type" value="<?=$input_type ?? ''?>">
<input type="hidden" name="page" id="page" value="1">
</form>
