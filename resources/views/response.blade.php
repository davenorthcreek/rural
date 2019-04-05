@extends('layouts.app')

@section('main-content')
    <div>
        <h1>Internet Access Survey Response</h1>
        @isset($resp)
            <h3>Response from {{$resp->name}}</h3>
            <div>
                <div id="mapid" style="height: 440px"></div>
            </div>

            <ul>
                <li>{{$resp->name}}</li>
                <li>{{$resp->email}}</li>
                <li>{{$resp->isp}}</li>
                <li>{{$resp->satisfaction}}</li>
                <li>{{$resp->lat}}, {{$resp->long}}</li>
            </ul>
        @endisset

@endsection

@section('local-scripts')
    @isset($resp)
        <script>
            var mymap = L.map('mapid').setView([{{$resp->lat}}, {{$resp->long}}], 12);
            L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                maxZoom: 18,
                id: 'mapbox.streets',
                accessToken: 'pk.eyJ1Ijoibm9ydGhjcmVla2RhdmUiLCJhIjoiY2p0dWxmcDN2MDB5YTN5bmVmcWxxcXFjdSJ9.aCpnpdVb8SxWsCUxsBr03g'
            }).addTo(mymap);
            var marker = new L.marker([{{$resp->lat}}, {{$resp->long}}], {draggable:false});
        mymap.addLayer(marker);
        </script>
    @endisset
@endsection