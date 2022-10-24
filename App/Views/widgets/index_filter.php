<!-- Search Area -->
<form role="form" action="<?=lang_site_url(lang_text('yatlar', 'yachts'))?>" method="GET">
<div class="container px-4 px-lg-5 mb-5 pb-5">
		<div class="row align-items-center search-area py-0 py-lg-3 px-1 px-lg-3 border">
				<div class="col-12 col-lg search-col">
						<div class="dropdown d-flex d-lg-block align-items-center py-2 py-lg-0">
								<img class="d-block d-lg-none" src="<?=site_url('assets/dist/img/location.svg')?>" alt="">
								<label class="dropdown-label d-none d-lg-block"><?=read_translate('bölge_secin')?></label>
								<a class="btn btn-white d-flex dropdown-toggle justify-content-between w-100 text-left mb-0 pl-2 pl-lg-0"
										href="#" role="button" id="dropdownRegion" data-toggle="dropdown" aria-haspopup="true"
										aria-expanded="false">
										<span class="text-truncate"><?=read_translate('bölge_secin')?></span>
										<i class="fa fa-chevron-down"></i>
								</a>

								<div class="dropdown-menu" aria-labelledby="dropdownRegion">
									<?php foreach (all_regions() as $key => $region): ?>
										<a class="dropdown-item" href="javascript:void(0)"
										onclick="change_filter('#dropdownRegion span', '<?=lang_text($region['tr_title'], $region['en_title'], $region['ru_title'])?>', '#region', '<?=$region['id']?>')">
											<?=lang_text($region['tr_title'], $region['en_title'],  $region['ru_title'])?>
										</a>
									<?php endforeach; ?>
								</div>
						</div>
				</div>

				<div class="col-12 col-lg search-col">
						<div class="dropdown d-flex d-lg-block align-items-center py-2 py-lg-0" >
								<img class="d-block d-lg-none" src="<?=site_url('assets/dist/img/ice.svg')?>" alt="">
								<label class="dropdown-label d-none d-lg-block"><?=read_translate('zaman_secin')?></label>
								<a class="btn btn-white d-flex dropdown-toggle justify-content-between w-100 text-left mb-0 pl-2 pl-lg-0"
										href="javascript:void(0)" role="button" id="dropdownPeriod">
										<span class="text-truncate"><?=read_translate('tarih_sec')?></span>
										<i class="fa fa-chevron-down"></i>
										<input type="hidden" class="form-control datepicker" id="pc_date">
								</a>

								<div class="dropdown-menu" aria-labelledby="dropdownPeriod">
									<a class="dropdown-item" href="javascript:void(0)"
									onclick="change_filter('#dropdownPeriod span', '<?=read_translate('yaz')?>', '#period', '1')">
										<?=read_translate('yaz')?>
									</a>
									<a class="dropdown-item" href="javascript:void(0)"
									onclick="change_filter('#dropdownPeriod span', '<?=read_translate('kis')?>', '#period', '0')">
										<?=read_translate('kis')?>
									</a>
								</div>
						</div>
				</div>
				<div class="col-12 col-lg search-col">
						<div class="dropdown d-flex d-lg-block align-items-center py-2 py-lg-0">
								<img class="d-block d-lg-none" src="<?=site_url('assets/dist/img/users.svg')?>" alt="">
								<label class="dropdown-label d-none d-lg-block"><?=read_translate('kisi_sayisi')?></label>
								<a class="btn btn-white d-flex dropdown-toggle justify-content-between w-100 text-left mb-0 pl-2 pl-lg-0"
										href="#" role="button" id="dropdownPerson" data-toggle="dropdown" aria-haspopup="true"
										aria-expanded="false">
										<span class="text-truncate">1 <?=read_translate('yetiskin')?></span>
										<i class="fa fa-chevron-down"></i>
								</a>

								<div class="dropdown-menu" aria-labelledby="dropdownPerson">
									<?php for ($pr = 1; $pr <= 5; $pr++) : ?>
									<a class="dropdown-item" href="javascript:void(0)"
									onclick="change_filter('#dropdownPerson span', '<?=$pr?> <?=read_translate('yetiskin')?>', '#person', '<?=$pr?>')">
										<?=$pr?> <?=read_translate('yetiskin')?>
									</a>
									<?php endfor; ?>
									<a class="dropdown-item" href="javascript:void(0)"
									onclick="change_filter('#dropdownPerson span', '5 - 10 <?=read_translate('yetiskin')?>', '#person', '6')">
										5 - 10 <?=read_translate('yetiskin')?>
									</a>
									<a class="dropdown-item" href="javascript:void(0)"
									onclick="change_filter('#dropdownPerson span', '10 <?=read_translate('ve_uzeri')?>', '#person', '11')">
										10 <?=read_translate('yetiskin')?> <?=read_translate('ve_uzeri')?>
									</a>
								</div>
						</div>
				</div>
				<div class="col-12 col-lg search-col">
						<div class="dropdown d-flex d-lg-block align-items-center py-2 py-lg-0">
								<img class="d-block d-lg-none" src="<?=site_url('assets/dist/img/users.svg')?>" alt="">
								<label class="dropdown-label d-none d-lg-block"><?=lang_text('Yatlar', 'Yachts')?></label>
								<a class="btn btn-white d-flex dropdown-toggle justify-content-between w-100 text-left mb-0 pl-2 pl-lg-0"
										href="#" role="button" id="dropdownType" data-toggle="dropdown" aria-haspopup="true"
										aria-expanded="false">
										<span class="text-truncate"><?=read_translate('yat_turu')?></span>
										<i class="fa fa-chevron-down"></i>
								</a>

								<div class="dropdown-menu" aria-labelledby="dropdownType">
									<?php foreach (all_yacht_types() as $key => $type): ?>
										<a class="dropdown-item" href="javascript:void(0)"
										onclick="change_filter('#dropdownType span', '<?=lang_text($type['type_title_tr'], $type['type_title_en'], $type['type_title_ru'])?>', '#type', '<?=$type['type_id']?>')">
											<?=lang_text($type['type_title_tr'], $type['type_title_en'], $type['type_title_ru'])?>
										</a>
									<?php endforeach; ?>
								</div>
						</div>
				</div>
				<div class="col-12 col-lg d-none d-lg-block">
						<input type="hidden" name="region" id="region" value="">
						<input type="hidden" name="person" id="person" value="1">
						<input type="hidden" name="period_start" id="period_start" value="">
						<input type="hidden" name="period_end" id="period_end" value="">
						<input type="hidden" name="type" id="type" value="">
						<button type="submit" class="btn btn-info w-100 py-2"><?=read_translate('arama_yap')?></button>
				</div>
		</div>
		<div class="row align-items-center py-0 py-lg-3 px-1 px-lg-3 border d-block d-lg-none d-xl-none ">
			<div class="col-12 m-0 p-0">
					<button type="submit" class="btn btn-info w-100 mt-2" style="min-height: 44px; line-height: 2; box-sizing: border-box;">
						<?=read_translate('arama_yap')?>
					</button>
			</div>
		</div>
</div>
</form>
