<div class="row mesaj-gonderildi py-5">
		<div class="col-12 bg-white py-5 rounded border">
				<div class="d-flex flex-column align-items-center justify-content center py-5">
						<img src="<?=site_url('assets')?>/dist/img/tick.svg">
						<div class="title my-3">
								<?= $message ?? read_translate('mesaj_basariyla_gonderildi')?>
						</div>
						<div class="desc">
								<?= $description ?? read_translate('mesaj_basarili_aciklama')?>
						</div>
						<?php if (session('reserve_no')): ?>
							<div class="desc alert alert-secondary mt-3 mb-1">
									<?=read_translate('rezervasyon_no')?> <?=session('reserve_no')?>
							</div>
						<?php session_delete('reserve_no'); endif; ?>
						<?php if (session('payment_slug')): ?>
							<a href="<?=lang_site_url(lang_text('odeme', 'payment', 'oplata')) .'/'. session('payment_slug')?>">
									<div class="btn btn-info mt-3 px-5 py-3"><?=read_translate('odeme_yap')?></div>
							</a>
						<?php session_delete('payment_slug'); endif; ?>
						<a href="<?=lang_site_url()?>">
								<div class="btn btn-info mt-3 px-5 py-3"><?=read_translate('anasayfa_don')?></div>
						</a>
				</div>
		</div>
</div>
