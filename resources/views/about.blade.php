@extends('layouts.app')

@section('main-content')
    <div>
        <h1>Internet Access Survey</h1>
        @isset($name)
            <h3>Thank you for your contribution, {{$name}}!</h3>
        @endisset
        <h3>The Concept</h3>
        <ul>
            <li>Collect locations from rural residents</li>
            <li>Collect locations of Internet towers and Cell towers</li>
            <li>Let residents know if they should switch to a different tower or ISP</li>
            <li>Lobby ISPs for new tower construction where it is needed</li>
        </ul>
    </div>

    <h3>Subscribe to <a href="http://newsletter.firstworldrural.ca">First World Rural (problems)</a>,
        a newsletter about living out of town and working in cyberspace.</h3>

@endsection
