<?php
$filter = [];
$page = [
	'n_page' => intval($page ?? 1) + 1,
	'o_page' => intval($page ?? 1) - 1,
	'page'   => intval($page ?? 1),
];
?>
<style media="screen">
	a {outline: none !important;}
	.slick-arrow {
		color: white !important;
    background-color: #07A4BA !important;
    border: 1px solid #07A4BA !important;
	}
	.disabled {
	  color: currentColor;
	  cursor: not-allowed;
	  opacity: 0.64;
	  text-decoration: none;
		pointer-events: none;
	}
</style>
<div class="col-12 mt-4 mb-4 text-right" style="display: flex;align-items: end;justify-content: flex-end;">
	<?php $filter['page'] = $page['page'] > 1 ? $page['o_page']:$page['page']; ?>
	<a href="<?=lang_site_url(lang_text('blog', 'blog', 'blog') . '?' . http_build_query($filter))?>" class="<?=($page['page'] > 1) ? '':'disabled'?>">
		<div class="slick-next slick-arrow" style="position: unset;margin: auto 5px;" aria-disabled="false">
			<i class="fa fa-chevron-left"></i>
		</div>
	</a>
	<?php /* $total > ($page['page'] * $limit) */ ?>
  <?php $filter['page'] = $page['n_page']; ?>
	<a href="<?=lang_site_url(lang_text('blog', 'blog', 'blog') . '?' . http_build_query($filter))?>" class="<?=($total > ($page['page'] * $limit) ? '':'disabled')?>">
		<div class="slick-next slick-arrow" style="position: unset;margin: auto 5px;" aria-disabled="false">
			<i class="fa fa-chevron-right"></i>
		</div>
	</a>

</div>
