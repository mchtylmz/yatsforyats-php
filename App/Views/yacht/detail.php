<?php if (isset($header)) {
	public_view('header', $data);
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/css/lightgallery.min.css">
<div class="container-fluid">
	<?=public_view('sidebar/main_menu', [
		'light' => 1,
		'active_menu' => $active_menu ?? ''
	]);?>
</div>

<!-- Page Slider -->
<?=public_view('widgets/yacht_detail_slider', [
	'Yacht' => $Yacht,
	'Gallery' => $Galleries
]);?>
<!-- Page Slider -->


<!-- Title Header -->
<?=public_view('widgets/yacht_detail_title', [
	'Yacht' => $Yacht
]);?>
<!-- Title Header -->

<!-- information -->
<?=public_view('widgets/yacht_detail_info', [
	'Yacht' => $Yacht,
	'feature_if' => isset($Features) && $Features,
	'gallery_if' => isset($Extras) && $Extras,
]);?>
<!-- information -->

<!-- Featured -->
<?=public_view('widgets/yacht_detail_feature', [
	'Yacht' => $Yacht,
	'Features' => $Features,
	'gallery_if' => isset($Extras) && $Extras,
]);?>
<!-- Featured -->

<!-- Tabs -->
<?=public_view('widgets/yacht_detail_tabs', [
	'Yacht' => $Yacht,
	'Extras' => $Extras,
]);?>
<!-- Tabs -->

<?php if (isset($footer)) {
	$data['border_top'] = 1;
	public_view('footer', $data);
} ?>
<?php
$resimler = [
	[
		'src' => uploads_url($Yacht['yc_image']),
		'thumb' => uploads_url($Yacht['yc_image']),
	]
];
if ($Galleries):
	foreach ($Galleries as $key => $gal):
	$resimler[] = [
		'src' => uploads_url($gal['gallery_file']),
		'thumb' => uploads_url($gal['gallery_file']),
	];
	endforeach;
endif;
?>
<?php if ($Yacht['yc_status'] == 'rent'): ?>
<!-- Zabuto Calendar -->
<script src="https://www.zabuto.com/dev/calendar/zabuto_calendar.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://www.zabuto.com/dev/calendar/zabuto_calendar.min.css">
<style media="screen">
	.rezervasyon_var {
		background-color: #fff0c3;
	}
</style>
<script type="application/javascript">
$(document).ready(function () {
	var eventData = <?php echo json_encode($ReserveDates ?? [], JSON_PRETTY_PRINT) ?>;
    $("#my-calendar").zabuto_calendar({
				legend: [
					{type: "block", label: "<?=read_translate('rezervasyon_var')?>", classname: "rezervasyon_var"},
				],
				data: eventData,
        language: "<?=get_language()?>",
				nav_icon: {
		      prev: '<i class="fa fa-chevron-left"></i>',
		      next: '<i class="fa fa-chevron-right"></i>'
		    }
    });
});
</script>
<?php endif; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.10.0/js/lightgallery.min.js" charset="utf-8"></script>
<script type="text/javascript">
var $galleries = <?php echo json_encode($resimler, JSON_PRETTY_PRINT) ?>;
function GalleryLightbox() {
	$(this).lightGallery({
      dynamic: true,
			thumbnail: true,
      dynamicEl: $galleries
  })
}
</script>
<script type="text/javascript">
$('.yat-detay-slider').slick({
		autoplay: true,
		speed: 1500,
		arrows: true,
		dots: true,
		asNavFor: ".yat-detay-slider-nav"
});
$('.yat-detay-slider-nav').slick({
		slidesToShow: 6,
		slidesToScroll: 1,
		autoplay: false,
		speed: 1500,
		dots: false,
  	centerMode: true,
  	focusOnSelect: true,
		asNavFor: ".yat-detay-slider",
		responsive: [{
				breakpoint: 992,
				settings: {
						slidesToShow: 4,
				}
		}]
});
$('.features-slider').slick({
		slidesToShow: 5,
		autoplay: false,
		speed: 1000,
		arrows: false,
		dots: false,
		responsive: [{
				breakpoint: 992,
				settings: {
						slidesToShow: 1,
						dots: true,
				}
		}]
});
</script>
