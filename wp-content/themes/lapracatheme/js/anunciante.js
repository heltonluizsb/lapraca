window.onload = function(){
	var geocoder;
	var map;
	var latLng;
	var panorama;

	function codeAddress(click) {

	  geocoder = new google.maps.Geocoder();

	  var address = document.getElementById('address').value;

	  geocoder.geocode( { 'address': address}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {

			var mapOptions = {
			zoom: 17,
			center: results[0].geometry.location,
			scrollWhell:true,
			mapTypeId:google.maps.MapTypeId.ROADMAP
			}

			map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

			map.setCenter(results[0].geometry.location);

			var marker = new google.maps.Marker({
			  map: map,
			  position: results[0].geometry.location
			});

			panorama = new google.maps.StreetViewPanorama(document.getElementById("pano"),{
				  position: results[0].geometry.location,
				  pov: {
				    heading: 34,
				    pitch: 10,
				  },
			});

			var conteudo = '<a href="https://www.google.com/maps/search/?api=1&query=' + document.getElementById('address').value + '" target="_blank" style="text-decoration:none">';
			conteudo += '<p style="color:black;font-size:13px;font-weight:bold;letter-spacing: 0px;text-align: center;position:relative;">' + document.getElementById('nome').value + '<br><br></p>';
			conteudo += '<p style="color:black;font-size:13px;letter-spacing: 0px;position:relative;">' + document.getElementById('address').value + '</p></a>';
	

			var infoWindow = new google.maps.InfoWindow({
				content:conteudo,
				maxWidth:200,
				pixelOffset: new google.maps.Size(0,20)
			});


			if(click == true){
				google.maps.event.addListener(marker,'click',function(){
				infoWindow.open(map,marker);			
				});
			}
			else{
				infoWindow.open(map,marker)
			}

	    } else {
	      alert('Geocode was not successful for the following reason: ' + status);
	    }
	  });
	}

codeAddress(true);

	// google.maps.event.addDomListener(window, 'load', initialize);
}