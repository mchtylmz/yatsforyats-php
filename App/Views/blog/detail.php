<?php if (isset($header)) {
	public_view('header', $data);
}
?>
<div class="container-fluid">
	<?=public_view('sidebar/main_menu', [
		'light' => 1,
		'active_menu' => $active_menu ?? ''
	]);?>
</div>

<!-- Page Slider -->
<?=public_view('widgets/blog_detail_image', [
	'BlogDetail' => $BlogDetail
]);?>
<!-- Page Slider -->

<!-- Title Header -->
<?=public_view('widgets/blog_detail', [
	'BlogDetail' => $BlogDetail
]);?>
<!-- Title Header -->

<?php if (isset($footer)) {
	$data['border_top'] = 1;
	public_view('footer', $data);
} ?>
