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

<!-- Yatlar -->
<?=public_view('widgets/buy_yacht_list', [
	'buy_yachts' => $buy_yachts
]);?>
<!-- Yatlar -->


<?php if (isset($footer)) {
	public_view('footer', $data);
} ?>
