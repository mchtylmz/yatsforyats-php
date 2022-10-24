<?php if (isset($header)) {
	public_view('header', $data);
}
?>
<div class="container-fluid">
	<?=public_view('sidebar/main_menu', $data);?>
	<?=public_view('widgets/slider', $data);?>
</div>
<!-- Filtre -->
<?=public_view('widgets/index_filter', $data);?>
<!-- Filtre -->

<!-- Gidilecek Yerler -->
<?=public_view('widgets/index_region', $data);?>
<!-- Gidilecek Yerler -->

<!-- Yatlar -->
<?=public_view('widgets/index_yacht', $data);?>
<!-- Yatlar -->

<!-- Organizasyonlar -->
<?=public_view('widgets/index_organization', $data);?>
<!-- Organizasyonlar -->

<!-- Yardım -->
<?=public_view('widgets/index_support', $data);?>
<!-- Yardım -->

<!-- Bilgi -->
<?=public_view('widgets/index_info', $data);?>
<!-- Bilgi -->

<?php if (isset($footer)) {
	public_view('footer', $data);
} ?>
