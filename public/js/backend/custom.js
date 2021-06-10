
//Initialize google places api.
  initialize();
  var placeSearch, autocomplete,select_first = 1;
  var componentForm = {
    country: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'long_name',
    postal_code  : 'short_name'
  };

  //Funtion for getting location by user location input in the location input box.
  function initialize() {
    var options = {
     
    };
    autocomplete = new google.maps.places.Autocomplete(document.getElementById('location'), options);
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
      fillInAddress();
    });
  }

  //Function to save the location
  function fillInAddress() {
    /* Get the place details from the autocomplete object. */
    var place = autocomplete.getPlace();
    var placeLat                =  place.geometry.location.lat();
    var placeLong                =  place.geometry.location.lng();
    document.getElementById('latitude').value   =   placeLat;
    document.getElementById('longitude').value   =   placeLong;
    for(var i = 0; i < place.address_components.length; i++) {
      var addressType = place.address_components[i].types[0];

      if(componentForm[addressType]) {
        var val = place.address_components[i][componentForm[addressType]];
        
        if(addressType == 'administrative_area_level_1'){
          document.getElementById('administrative_area_level_1').value = place.address_components[i]['long_name'];
        }
        if(addressType == 'country'){
          document.getElementById('country').value = place.address_components[i]['long_name'];
        }
        if(addressType == 'locality'){
          document.getElementById('locality').value = place.address_components[i]['long_name'];
        }
      }
    }
  }
      
  //Empty all the hidden fields related to locaiton on key up other than enter key.
  $("#location").on('keyup', function(e){
    if(e.keyCode == 13){
      return false;
    }else{
      $('#country').val("");
      $('#locality').val("");
      $('#administrative_area_level_1').val("");
      $('#latitude').val("");
      $('#longitude').val("");
    }
  });  

  // Stopping form submission on pressing enter on the location input box.
  $(document).on('keypress','#location',function(e){
    if(e.keyCode == 13) {
      return false;
    }
  });
