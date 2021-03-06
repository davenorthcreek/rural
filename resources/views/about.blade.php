@extends('layouts.app')

@section('main-content')
    <div>
        <h1>Internet Access Survey</h1>
        @isset($resp)
            <h3>Thank you for your contribution, {{$resp->name}}!</h3>
        @endisset
        <div>
            <div id="mapid" style="height: 440px"></div>
        </div>
        <h3>The Concept</h3>
        <ul>
            <li>Collect locations from rural residents</li>
            <li>Collect locations of Internet towers and Cell towers</li>
            <li>Let residents know if they should switch to a different tower or ISP</li>
            <li>Lobby ISPs for new tower construction where it is needed</li>
        </ul>

        @if(!isset($resp))
            <h2><a href="{{url('survey')}}">Take the Survey Here!</a></h2>
        @endif

        <h3><a href="http://forum.firstworldrural.ca">New! Join the Forum!</a></h3>

        <h3>Subscribe to <a href="http://newsletter.firstworldrural.ca">First World Rural (problems)</a>,
            a newsletter about living out of town and working in cyberspace.</h3>
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
        @if(isset($resp))
            var mymap = L.map('mapid').setView([{{$resp->lat}}, {{$resp->long}}], 12);
        @else
            var mymap = L.map('mapid').setView([53.73, -114.17], 10);
        @endif
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1Ijoibm9ydGhjcmVla2RhdmUiLCJhIjoiY2p0dWxmcDN2MDB5YTN5bmVmcWxxcXFjdSJ9.aCpnpdVb8SxWsCUxsBr03g'
        }).addTo(mymap);
        @if(isset($resp))
            var marker = new L.marker([{{$resp->lat}}, {{$resp->long}}], {draggable:true, icon: icon{{$resp->score}}});
            mymap.addLayer(marker);
        @else
            @foreach($responses as $resp)
                marker = new L.marker([{{$resp->lat}}, {{$resp->long}}],
                    {
                        draggable:false,
                        icon: icon{{$resp->score}}
                    }
                );
                mymap.addLayer(marker);
            @endforeach
        @endif
    </script>
@endsection
