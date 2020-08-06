$(document).ready(function () {
  if ($('#map').length) {
    initAutocomplete();
  }
  $('.hb-map__col:first-child').addClass('active');
});

function initAutocomplete()
{
  var defaultLat = $('.hb-map__col:first-child').data('lat'),
  defaultLng = $('.hb-map__col:first-child').data('lng'),
  markerIcon = {
    url: '../assets/src/image/icon/marker.png',
    size: new google.maps.Size(40, 60),
    origin: new google.maps.Point(0, 0),
    anchor: new google.maps.Point(17, 34)
  },
  marker = new google.maps.Marker({
    position: new google.maps.LatLng(defaultLat, defaultLng),
    map: map,
    draggable: false,
    icon: markerIcon
  }),
  options = {
    center: {lat: defaultLat, lng: defaultLng},
    zoom: 16,
    mapTypeId: 'roadmap',
    icon: marker
  },
  map = new google.maps.Map(document.getElementById('map'), options);

  (function (Mapping, $, undefined) {
    let self = this;

    function Initialize()
    {
      let dropdownAddress = $('.hb-map-select-store');
      let myOptions = {
        zoom: 16,
        center: new google.maps.LatLng(defaultLat, defaultLng),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      self.map = new google.maps.Map(document.getElementById("map"),myOptions);
      self.infoWindow = new google.maps.InfoWindow();

      $('.hb-map__col').each(function () {
        let $this = $(this);
        let pos = new google.maps.LatLng($this.data('lat'), $this.data('lng'));
        let marker = new google.maps.Marker({
          position: pos,
          map: self.map
        });
        $this.click(function () {
          self.map.panTo(pos);
          $this.siblings().removeClass('active');
          $this.addClass('active');
        });
      });

      if ( window.screen.width <= '767' ) {
        $('.hb-map__col').hide();
        $('.hb-map__col:first-child').show();
        dropdownAddress.on('change', function () {
          let selectedAddress = $(this).val();
          $('.hb-map__col').each(function () {
            let $this = $(this);
            let storeAddress = $(this).data('store');
            if (selectedAddress == storeAddress) {
              let pos = new google.maps.LatLng($this.data('lat'), $this.data('lng'));
              let marker = new google.maps.Marker({
                position: pos,
                map: self.map
              });
              self.map.panTo(pos);
              $this.siblings().removeClass('active').hide();
              $this.addClass('active').show();
            }
          });
        });
      }
    }

    Initialize();
  })(window.Mapping = window.Mapping || {}, jQuery);
}
