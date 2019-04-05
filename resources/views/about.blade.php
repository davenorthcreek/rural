@extends('layouts.app')

@section('main-content')
    <div>
        <h1>Internet Access Survey</h1>
        @isset($resp)
            <h3>Thank you for your contribution, {{$resp->name}}!</h3>
            <div>
                <div id="mapid" style="height: 440px"></div>
            </div>
        @endisset
        <h3>The Concept</h3>
        <ul>
            <li>Collect locations from rural residents</li>
            <li>Collect locations of Internet towers and Cell towers</li>
            <li>Let residents know if they should switch to a different tower or ISP</li>
            <li>Lobby ISPs for new tower construction where it is needed</li>
        </ul>
    </div>

    @if(!isset($resp))
        <h2><a href="{{url('survey')}}">Take the Survey Here!</a></h2>
    @endif

    <h3>Subscribe to <a href="http://newsletter.firstworldrural.ca">First World Rural (problems)</a>,
        a newsletter about living out of town and working in cyberspace.</h3>

@endsection

@section('local-scripts')
    <script>
    @isset($resp)
    var mymap = L.map('mapid').setView([{{$resp->lat}}, {{$resp->long}}], 12);
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1Ijoibm9ydGhjcmVla2RhdmUiLCJhIjoiY2p0dWxmcDN2MDB5YTN5bmVmcWxxcXFjdSJ9.aCpnpdVb8SxWsCUxsBr03g'
    }).addTo(mymap);
    var marker = new L.marker([{{$resp->lat}}, {{$resp->long}}], {draggable:true});
    mymap.addLayer(marker);
    @endisset
@endsection
