@extends('layouts.app')

@section('main-content')
    <div>
        <h1>Internet Access Survey</h1>
        <h3>Drop a pin on your location</h3>
        <div id="mapid" style="height: 440px"></div>
        <div>
            The Lat/Long from your Pin: <span id=ll></span>
        </div>

        <form id="survey" method="POST" action='{{url("result")}}'>
            {{csrf_field()}}
            <input type="hidden" id="lat" name="lat">
            <input type="hidden" id="long" name="long">
            <input type="hidden" id='satisfaction' name="satisfaction">
            <div class="form-group row">
                <label for="name" class="col-sm-2 control-label">Your Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name">
                </div>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
                <label for="email" class="col-sm-2 control-label">Your Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" autocomplete="off" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('isp') ? ' has-error' : '' }} row">
                <label for="isp" class="col-sm-2 control-label">Your Internet Service Provider</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="isp" name="isp" required>
                    @if ($errors->has('isp'))
                        <span class="help-block">
                            <strong>{{ $errors->first('isp') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                <label for="sat_stars" class="col-sm-2">How Satisfied Are You with Your ISP?</label>
                <div class="col-sm-10">
                    <section class='rating-widget' id="sat_stars">

                        <!-- Rating Stars Box -->
                        <div class='rating-stars text-center'>
                            <ul id='stars'>
                                <li class='star' title='Poor' data-value='1'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Fair' data-value='2'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Good' data-value='3'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='Excellent' data-value='4'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                                <li class='star' title='WOW!!!' data-value='5'>
                                    <i class='fa fa-star fa-fw'></i>
                                </li>
                            </ul>
                        </div>
                    </section>
                </div>

            </div>
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-danger">Join the Co-op, fight for a better deal</button>
                </div>
            </div>
        </form>
    </div>

@endsection


@section('local-scripts')
    <script>

    const one =   '#FF0000'
    const two =   '#FF5F00'
    const three = '#FFBF00'
    const four  = '#a99852'
    const five  = '#00FF00'

    function satisfaction_colour(stars) {
        switch (stars) {
            case 1:
                return one;
                break;
            case 2:
                return two;
                break;
            case 3:
                return three;
                break;
            case 4:
                return four;
                break;
            default:
                return five;
        }
    }

    function markerStyle(stars) {
        var co = satisfaction_colour(stars);
        var style = `
        background-color: ${co};
        width: 3rem;
        height: 3rem;
        display: block;
        left: -1.5rem;
        top: -1.5rem;
        position: relative;
        border-radius: 3rem 3rem 0;
        transform: rotate(45deg);
        border: 1px solid #FFFFFF`;
        return style;
    }

    var icon1 = L.divIcon({
      className: "my-custom-pin",
      iconAnchor: [0, 24],
      labelAnchor: [-6, 0],
      popupAnchor: [0, -36],
      html: `<span style="${markerStyle(1)}" />`
    });

    var icon2 = L.divIcon({
      className: "my-custom-pin",
      iconAnchor: [0, 24],
      labelAnchor: [-6, 0],
      popupAnchor: [0, -36],
      html: `<span style="${markerStyle(2)}" />`
    });

    var icon3 = L.divIcon({
      className: "my-custom-pin",
      iconAnchor: [0, 24],
      labelAnchor: [-6, 0],
      popupAnchor: [0, -36],
      html: `<span style="${markerStyle(3)}" />`
    });

    var icon4 = L.divIcon({
      className: "my-custom-pin",
      iconAnchor: [0, 24],
      labelAnchor: [-6, 0],
      popupAnchor: [0, -36],
      html: `<span style="${markerStyle(4)}" />`
    });

    var icon5 = L.divIcon({
      className: "my-custom-pin",
      iconAnchor: [0, 24],
      labelAnchor: [-6, 0],
      popupAnchor: [0, -36],
      html: `<span style="${markerStyle(5)}" />`
    });

    var mymap = L.map('mapid').setView([53.73, -114.17], 10);
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1Ijoibm9ydGhjcmVla2RhdmUiLCJhIjoiY2p0dWxmcDN2MDB5YTN5bmVmcWxxcXFjdSJ9.aCpnpdVb8SxWsCUxsBr03g'
    }).addTo(mymap);
    @foreach($responses as $resp)
        existingMarker = new L.marker([{{$resp->lat}}, {{$resp->long}}],
            {
                draggable:false,
                icon: icon{{$resp->score}}
            }
        )
        .on('mouseover', function(e) {
            e.target.bindPopup("{{$resp->isp}}").openPopup();
        })
        .on('mouseout', function(e) {
            e.target.closePopup()
        });
        mymap.addLayer(existingMarker);
    @endforeach


    var oldpin = false;

    mymap.on('click', function(e){
        var marker = new L.marker(e.latlng, {draggable:true});
        mymap.addLayer(marker);
        var latitude = parseFloat(e.latlng.lat).toFixed(4);
        var longitude = parseFloat(e.latlng.lng).toFixed(4);
        if (oldpin) {
            mymap.removeLayer(oldpin);
        }
        oldpin = marker;
        $("#ll").text(latitude+', '+longitude);
        $("#lat").val(latitude);
        $("#long").val(longitude);
    });


$(document).ready(function(){
 /* 1. Visualizing things on Hover - See next part for action on click */
 $('#stars li').on('mouseover', function(){
   var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

   // Now highlight all the stars that's not after the current hovered star
   $(this).parent().children('li.star').each(function(e){
     if (e < onStar) {
       $(this).addClass('hover');
     }
     else {
       $(this).removeClass('hover');
     }
   });

 }).on('mouseout', function(){
   $(this).parent().children('li.star').each(function(e){
     $(this).removeClass('hover');
   });
 });


 /* 2. Action to perform on click */
 $('#stars li').on('click', function(){
   var onStar = parseInt($(this).data('value'), 10); // The star currently selected
   var stars = $(this).parent().children('li.star');

   for (i = 0; i < stars.length; i++) {
     $(stars[i]).removeClass('selected');
   }

   for (i = 0; i < onStar; i++) {
     $(stars[i]).addClass('selected');
   }

   var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
   var msg = ratingValue + " stars";
   $("#satisfaction").val(msg);

 });

});
</script>



@endsection
