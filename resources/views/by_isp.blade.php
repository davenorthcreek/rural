@extends('layouts.app')

@section('main-content')
    <div>
        <h1>Internet Access Survey Response By ISP</h1>
        @isset($isp)
            <h3>Responses from <span class="satisfaction-{{round($average[$isp])}}">{{$isp}}</span></h3>
            <div>
                <div id="mapid" style="height: 440px"></div>
            </div>
        @endisset
        @if (! Auth::guest())
        <p>Responses</p>
        <ul>
            @foreach($matching as $res)
                <li class="satisfaction-{{$res->score}}">
                    <a class="satisfaction-{{$res->score}}" href="{{url("/response/".$res->id)}}">
                        {{$res->name}}: {{$res->isp}} ({{$res->satisfaction}})
                    </a>
                </li>
            @endforeach
        </ul>
        @endif
        <p>ISPs</p>
        <ul>
            @foreach($isps as $another_isp)
                <li class="satisfaction-{{round($average[$another_isp])}}">
                    <a class="satisfaction-{{round($average[$another_isp])}}" href="{{url("/byIsp/".$another_isp)}}">
                        {{$another_isp}}: {{$average[$another_isp]}} stars from {{$count[$another_isp]}} responses
                    </a>
                </li>
            @endforeach
        </ul>
        <div><a href="{{url("/all")}}">Back to All Responses</a></div>
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

        var mymap = L.map('mapid').setView([{{$location[0]}}, {{$location[1]}}], 10);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1Ijoibm9ydGhjcmVla2RhdmUiLCJhIjoiY2p0dWxmcDN2MDB5YTN5bmVmcWxxcXFjdSJ9.aCpnpdVb8SxWsCUxsBr03g'
        }).addTo(mymap);
        @foreach($matching as $inRange)
            marker = new L.marker([{{$inRange->lat}}, {{$inRange->long}}],
                {
                    draggable:false,
                    icon: icon{{$inRange->score}}
                }
            );
            mymap.addLayer(marker);
        @endforeach
    </script>
@endsection
