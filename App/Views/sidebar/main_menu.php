<?php
$lang = $lang ?? get_language();
$active_menu = $active_menu ?? '';
?>
<div class="container-fluid px-0 top-menu py-0 py-lg-3 <?=isset($light) ? 'light border-bottom':''?>">
		<div class="container px-0 px-lg-3">
				<nav class="navbar navbar-expand-lg navbar-light bg-transparent justify-between px-0 px-lg-2 py-0 py-lg-1">
						<a class="d-block d-lg-none navbar-brand pl-3 py-2" href="/">
							<?php if (isset($light)): ?>
							<img class="mobile-navbar-logo" src="<?=uploads_url(site_setting('site_logo_beyaz'))?>" alt="<?=site_config('title')?>">
							<?php else: ?>
							<img class="mobile-navbar-logo" src="<?=uploads_url(site_setting('site_logo_normal'))?>" alt="<?=site_config('title')?>">
							<?php endif; ?>
						</a>
						<div class="d-flex">
								<div class="justify-content-end languages d-flex d-lg-none mr-2">
										<a href="<?=site_url(change_lang('en'))?>" class="m-2 my-3 px-2 py-1 <?=isset($light) ? '':'text-white'?> <?=$lang == 'en' ? 'active':'not-active'?>">
											<?=read_translate('kisa_dil_ingilizce', 'en')?>
										</a>
										<a href="<?=site_url(change_lang('tr'))?>" class="m-2 my-3 px-2 py-1 <?=isset($light) ? '':'text-white'?> <?=$lang == 'tr' ? 'active':'not-active'?>">
											<?=read_translate('kisa_dil_turkce', 'tr')?>
										</a>
								</div>
								<button class="navbar-toggler border-0 px-0 pr-3" type="button" data-toggle="collapse"
										data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
										aria-expanded="false" aria-label="Toggle navigation">
										<i class="fa fa-bars"></i>
										<!-- <span class="navbar-toggler-icon"></span> -->
								</button>
						</div>
						<div class="collapse navbar-collapse justify-content-between py-4 py-lg-0" id="navbarSupportedContent">
								<div class="col-lg-2 d-none d-lg-block">
										<a href="/">
											<?php if (isset($light)): ?>
											<img class="logo" src="<?=uploads_url(site_setting('site_logo_beyaz'))?>" alt="<?=site_config('title')?>">
											<?php else: ?>
											<img class="logo" src="<?=uploads_url(site_setting('site_logo_normal'))?>" alt="<?=site_config('title')?>">
											<?php endif; ?>
										</a>
								</div>
								<div class="col-lg-8 col-12 row justify-content-center  pr-0 pr-lg-4 mr-0 mr-lg-4">
										<ul class="navbar-nav w-100 align-items-center justify-content-center">
												<li class="py-2 py-lg-0 top-menu-item <?=is_menu_url(lang_text('anasayfa', 'home', 'dom')) ? 'active':''?>">
														<a class="py-0 py-lg-2 top-menu-link text-center mr-1 ml-1" href="<?=lang_site_url()?>">
															<?=read_translate('menu_anasayfa', $lang)?>
														</a>
												</li>
												<li class="py-2 py-lg-0 top-menu-item <?=$active_menu == 'sale' ? 'active':''?>">
														<a class="py-0 py-lg-2 top-menu-link text-center mr-1 ml-1" href="<?=lang_site_url(lang_text('satilik/yatlar', 'sale/yachts', 'prodazha/yakhty'))?>">
															<?=read_translate('menu_satilik_yatlar', $lang)?>
														</a>
												</li>
												<li class="py-2 py-lg-0 top-menu-item <?=$active_menu == 'rent' ? 'active':''?>">
														<a class="py-0 py-lg-2 top-menu-link text-center mr-1 ml-1" href="<?=lang_site_url(lang_text('yatlar', 'yachts', 'yakhty'))?>">
															<?=read_translate('menu_yatlar', $lang)?>
														</a>
												</li>
												<li class="py-2 py-lg-0 top-menu-item <?=is_menu_url(lang_text('blog', 'blog', 'blog')) || $active_menu == 'blog' ? 'active':''?>">
														<a class="py-0 py-lg-2 top-menu-link text-center mr-1 ml-1" href="<?=lang_site_url(lang_text('blog', 'blog', 'blog'))?>">
															<?=read_translate('menu_blog', $lang)?>
														</a>
												</li>
												<li class="py-2 py-lg-0 top-menu-item <?=is_menu_url(lang_text('hakkimizda', 'about', 'около')) ? 'active':''?>">
														<a class="py-0 py-lg-2 top-menu-link text-center mr-1 ml-1" href="<?=lang_site_url(lang_text('hakkimizda', 'about', 'около'))?>">
															<?=read_translate('menu_hakkimizda', $lang)?>
														</a>
												</li>
												<li class="py-2 pb-3 py-lg-0 pb-lg-0 top-menu-item <?=is_menu_url(lang_text('iletisim', 'contact', 'kkntakt')) ? 'active':''?>">
														<a class="py-0 py-lg-2 top-menu-link text-center mr-1 ml-1" href="<?=lang_site_url(lang_text('iletisim', 'contact', 'kkntakt'))?>">
															<?=read_translate('menu_iletisim', $lang)?>
														</a>
												</li>
												<li class="py-3 pb-1 border-top w-full d-flex d-lg-none flex-row">
														<a target="_blank" href="https://facebook.com/<?=site_setting('facebook')?>" class="mx-2">
															<img src="<?=site_url('assets/')?>dist/img/Instagram.svg" />
														</a>
														<a target="_blank" href="https://twitter.com/<?=site_setting('twitter')?>" class="mx-2">
															<img src="<?=site_url('assets/')?>dist/img/Twitter.svg">
														</a>
														<a target="_blank" href="https://instagram.com/<?=site_setting('instagram')?>" class="mx-2">
															<img src="<?=site_url('assets/')?>dist/img/Instagram.svg">
														</a>
												</li>
										</ul>

								</div>
								<div class="col-lg-2 row justify-content-end languages d-none d-lg-flex">
										<a href="<?=site_url(change_lang('en'))?>" class="mx-1 px-2 py-1 <?=isset($light) ? '':'text-white'?> <?=$lang == 'en' ? 'active':'not-active'?>">
											<?=read_translate('kisa_dil_ingilizce', 'en')?>
										</a>
										<a href="<?=site_url(change_lang('tr'))?>" class="mx-1 px-2 py-1 <?=isset($light) ? '':'text-white'?> <?=$lang == 'tr' ? 'active':'not-active'?>">
											<?=read_translate('kisa_dil_turkce', 'tr')?>
										</a>
										<!--
										<a href="<?=site_url(change_lang('ru'))?>" class="mx-1 px-2 py-1 <?=isset($light) ? '':'text-white'?> <?=$lang == 'ru' ? 'active':'not-active'?>">
											<?=read_translate('kisa_dil_rusca', 'ru')?>
										</a>
									-->
								</div>
						</div>
				</nav>
		</div>
</div>
