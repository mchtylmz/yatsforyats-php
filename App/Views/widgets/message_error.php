<div class="row mesaj-gonderildi <?=$class ?? 'py-5'?>">
		<div class="col-12 bg-white py-5 rounded border">
				<div class="d-flex flex-column align-items-center justify-content center py-5">
						<img src="<?=site_url('assets')?>/dist/img/cancel.svg" style="width: 112px">
						<div class="title my-3">
								<?= $message ?? read_translate('mesaj_gonderimi_basarisiz')?>
						</div>
						<div class="desc">
								<?= $description ?? read_translate('mesaj_basarisiz_aciklama')?>
						</div>
						<a href="<?=lang_site_url()?>">
								<div class="btn btn-danger mt-3 px-5 py-3"><?=read_translate('anasayfa_don')?></div>
						</a>
				</div>
		</div>
</div>
