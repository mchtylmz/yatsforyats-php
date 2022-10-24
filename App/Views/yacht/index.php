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

<!-- Filtrele -->
<?=public_view('widgets/yacht_search', [
	'filter_region'   => $filter_region ?? null,
	'filter_person'   => $filter_person ?? null,
	'filter_period'   => $filter_period ?? null,
	'filter_type'     => $filter_type ?? null,
	'input_region'    => get('region'),
	'input_person'    => get('person'),
	'input_period'    => get('period'),
	'input_type'      => get('type'),
	'page'            => get('page') ?? 1,
]);?>
<!-- Filtrele -->

<!-- Mobil Map -->
<?=public_view('widgets/mobile_map', $data);?>
<!-- Mobil Map -->

<!-- Yatlar -->
<?=public_view('widgets/yacht_list', [
	'all_yachts'      => $filter_yachts,
	'filter_notfound' => $filter_notfound ?? null,
	'filter_region'   => $filter_region ?? null,
	'filter_person'   => $filter_person ?? null,
	'filter_period'   => $filter_period ?? null,
	'filter_type'     => $filter_type ?? null,
	'notype_yachts' => $notype_yachts ?? null,
]);?>
<!-- Yatlar -->



<?php if (isset($footer)) {
	public_view('footer', $data);
} ?>
<?php
$locations = [];
if (isset($map_filter_yachts['yachts']) && $map_filter_yachts['yachts']) {
	foreach ($map_filter_yachts['yachts'] as $key => $yacht) {
		$locations[] = [
			'marker' => [
				'lat' => floatval($yacht['yc_lat']),
				'lng' => floatval($yacht['yc_lon']),
			],
			'title' => lang_text($yacht['yc_title_tr'], $yacht['yc_title_en']),
			'image' => uploads_url($yacht['yc_image'])
		];
	}
} elseif (isset($map_notype_yachts['yachts']) && $map_notype_yachts['yachts']) {
	foreach ($map_notype_yachts['yachts'] as $key => $yacht) {
		$locations[] = [
			'marker' => [
				'lat' => floatval($yacht['yc_lat']),
				'lng' => floatval($yacht['yc_lon']),
			],
			'title' => lang_text($yacht['yc_title_tr'], $yacht['yc_title_en']),
			'image' => uploads_url($yacht['yc_image'])
		];
	}
}
?>
<?php $map_key = site_setting('google_javascript_map_api'); ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?=$map_key?>&language=<?=get_language()?>" defer></script>
<script type="text/javascript">
$("[data-toggle='collapse']").click(function () {
		let hedef = $(this).attr('data-target');
		$('.collapse').not(hedef).collapse('hide');
		$('#bolge.collapse').collapse('hide');
});
window.filter_region = function(text_value, input_value) {
	$('#mobil_bolge span').text(text_value.substr(0, 4) + '..');
	$('#dropdownRegion span').text(text_value);
	$('#region').val(input_value);
	$('#bolge.collapse').collapse('hide');
};
window.filter_period = function(text_value, input_value) {
	$('#mobil_zaman span').text(text_value);
	$('#dropdownPeriod span').text(text_value);
	$('#period').val(input_value);
	$('#zaman.collapse').collapse('hide');
};
window.filter_person = function(text_value, input_value) {
	$('#mobil_kisi span').text(text_value);
	$('#dropdownPerson span').text(text_value);
	$('#person').val(input_value);
	$('#kisi.collapse').collapse('hide');
};
window.filter_type = function(text_value, input_value) {
	$('#mobil_tur span').text(text_value.substr(0, 4) + '..');
	$('#dropdownType span').text(text_value);
	$('#type').val(input_value);
	$('#yat.collapse').collapse('hide');
};
$(document).ready(function () {
	var konum = <?php echo json_encode($locations, JSON_PRETTY_PRINT) ?>;
	var myCenter = new google.maps.LatLng(38.423733, 27.142826);

	function initialize() {
	  var mapProp = {
	    center: konum[0]['marker'] ? konum[0]['marker']:myCenter,
	    zoom: konum[0]['marker'] ? 11:9,
	    mapTypeId: google.maps.MapTypeId.ROADMAP,
		  mapTypeControl: false,
		  scaleControl: false,
		  streetViewControl: false,
		  rotateControl: false,
			fullscreenControl: false
	  };
	  var map = new google.maps.Map(document.getElementById("map_desktop"), mapProp);
		for (var i = 0; i < konum.length; i++) {
			var marker = new google.maps.Marker({
		    position: konum[i]['marker'],
		    animation: google.maps.Animation.DROP,
				icon: 'https://yatsforyats.com/assets/dist/img/location.svg'
		  });
			addInfoWindow(map, marker, konum[i]);
		  marker.setMap(map);
		}

	  var mapProp2 = {
	    center: konum[0]['marker'] ? konum[0]['marker']:myCenter,
	    zoom: 9,
	    mapTypeId: google.maps.MapTypeId.ROADMAP2,
		  mapTypeControl: false,
		  scaleControl: false,
		  streetViewControl: false,
		  rotateControl: false,
			fullscreenControl: false
	  };
	  var map = new google.maps.Map(document.getElementById("map_mobile"), mapProp2);
		for (var i = 0; i < konum.length; i++) {
			var marker = new google.maps.Marker({
		    position: konum[i]['marker'],
		    animation: google.maps.Animation.DROP,
				icon: 'https://yatsforyats.com/assets/dist/img/location.svg'
		  });
			addInfoWindow(map, marker, konum[i]);
		  marker.setMap(map);
		}
	}
	google.maps.event.addDomListener(window, 'load', initialize);

	function addInfoWindow(map, marker, yat) {
	    var infoWindow = new google.maps.InfoWindow({
	        content: '<img style="margin-bottom: 10px; width: 100px;" src="' + yat['image'] + '"> <br> <h5 style="text-align:center">' +  yat['title'] + '</h5>'
	    });
	    google.maps.event.addListener(marker, 'click', function () {
	        infoWindow.open(map, marker);
	    });
	}

});
</script>
