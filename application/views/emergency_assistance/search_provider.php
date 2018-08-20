<style>
/* Always set the map height explicitly to define the size of the div element that contains the map. */
#map {  height: 400px; }
</style>
<div>
	<div class="page-title">
		<div class="title_left">
			<h3>Search Provider</h3>
		</div>
	</div>
	<div class="clearfix"></div>

	<!-- Provider search Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_content">
					<!-- search policy filter start -->
					<?php echo form_open("", array('class'=>'form-horizontal', 'method'=>'get')); ?>
					<input type='hidden' name='lat' id='lat' value=''>
					<input type='hidden' name='lng' id='lng' value=''>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group col-sm-8">
								<?php echo form_label('Address :', 'address', array("class"=>'col-sm-12')); ?>
								<?php echo form_input("address", $address, array("class"=>"form-control", 'placeholder'=>'Address', 'id'=>'autocomplete', 'onFocus'=>'geolocate()')); ?>
							</div>
							<div class="col-sm-4">
								<label class="col-sm-12">&nbsp;</label>
								<button class="btn btn-primary">Search</button>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
					<?php echo form_close(); ?>
					<div class="row">
						<div class="col-sm-12">
							<div id="map"></div>
						</div>
					</div>
					<!-- search policy filter end -->
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>

	<!-- Provider List Section -->
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<!-- search results start -->
			<div class="x_title">
				<h2>
					Search Result<small></small>
				</h2>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<?php if(!empty($records)): ?>
				<div class="table-responsive">
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>Name</th>
								<th>Services</th>
								<th>Address</th>
								<th>PostCode</th>
								<th>Discount</th>
								<th>Contact Person</th>
								<th>Phone number</th>
								<th>Email</th>
								<th>PPO codes</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($records as $value): ?>
							<tr>
								<td><?php echo $value['name']; ?></td>
								<td><?php echo $value['services']; ?></td>
								<td><?php echo $value['address']; ?></td>
								<td><?php echo $value['postcode']; ?></td>
								<td><?php echo $value['discount']; ?></td>
								<td><?php echo $value['contact_person']; ?></td>
								<td><?php echo $value['phone_no']; ?></td>
								<td><?php echo $value['email']; ?></td>
								<td><?php echo $value['ppo_codes']; ?></td>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>
					<!-- End Search List Section -->
				</div>
				<?php else: ?>
				<center><?php echo heading("No record available", 4); ?></center>
				<?php endif ?>
				<div class="col-sm-12" style="text-align: center">
					<button class="btn btn-primary return_back">Return</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php echo link_tag('assets/css/bootstrap-datepicker.css'); ?>
<script>
$(document).ready(function() {
	$(".return_back").click(function(){
		window.close(); // or self.close();
	})
})

var map;
var markers = [];
function initMap() {
	map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: <?php echo $lat;?>, lng: <?php echo $lng;?>},
		zoom: 9
	});

	var infowindow = new google.maps.InfoWindow();
	var bounds = new google.maps.LatLngBounds();
	// http://maps.google.com/mapfiles/ms/icons/green-dot.png
	// http://maps.google.com/mapfiles/ms/icons/hospitals.png
	var myLatLng = {lat: <?php echo $lat;?>, lng: <?php echo $lng;?>};
	var markerx = new google.maps.Marker({
		position: myLatLng,
		map: map,
		icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
		title: 'Your are here'
	});
	bounds.extend(markerx.getPosition());
	
<?php
	if (!empty($records)) {
		$i = 0;
		foreach ($records as $key => $value) {
			$i++;
			# code...
?>
			var myLatLng = {lat: <?php echo $value['lat'];?>, lng: <?php echo $value['lng'];?>};
			var marker<?php echo $i; ?> = new google.maps.Marker({
					position: myLatLng,
					map: map,
					icon: 'http://maps.google.com/mapfiles/ms/icons/hospitals.png',
					title: "<?php echo $value['address'];?>"
				});
			bounds.extend(marker<?php echo $i; ?>.getPosition());

			google.maps.event.addListener(marker<?php echo $i; ?>, 'click', function() {
				infowindow.setContent("<div><strong> <?php echo $value['name'];?> </strong><br><?php echo $value['address'];?></div>");
				infowindow.open(map, this);
			});
<?php
		}
	}
?> 
	map.fitBounds(bounds);
}

var placeSearch, autocomplete;
var componentForm = {
		street_number: 'short_name',
		route: 'long_name',
		locality: 'long_name',
		administrative_area_level_1: 'short_name',
		country: 'short_name',
		postal_code: 'short_name'
};

function initAutocomplete() {
	initMap();
	autocomplete = new google.maps.places.Autocomplete((document.getElementById('autocomplete')),{types: ['geocode']});
	autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
	var place = autocomplete.getPlace();
	
	document.getElementById('lat').value = place.geometry.location.lat();
	document.getElementById('lng').value  = place.geometry.location.lng();
    
	for (var component in componentForm) {
		document.getElementById(component).value = '';
		// document.getElementById(component).disabled = false;
	}

	// Get each component of the address from the place details and fill the corresponding field on the form.
	for (var i = 0; i < place.address_components.length; i++) {
		var addressType = place.address_components[i].types[0];
		if (componentForm[addressType]) {
			var val = place.address_components[i][componentForm[addressType]];
			document.getElementById(addressType).value = val;
		}
	}
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var geolocation = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
					};
			var circle = new google.maps.Circle({
				center: geolocation,
				radius: position.coords.accuracy
				});
			autocomplete.setBounds(circle.getBounds());
		});
	}
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&libraries=places&callback=initAutocomplete" async defer></script>
