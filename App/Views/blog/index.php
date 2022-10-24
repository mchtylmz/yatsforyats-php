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

<!-- Blog -->
<?=public_view('widgets/blog_list', [
	'blogs' => $blogs
]);?>
<!-- Blog -->

<?php if (isset($footer)) {
	public_view('footer', $data);
} ?>
