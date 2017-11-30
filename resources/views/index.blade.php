@extends('layout.index')
@section('custom-css')
    <link href="/css/index.css" rel="stylesheet" type="text/css" />
@endsection
@section('oneModal', '')
@section('pageContentDetail')
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @if (Auth::check())
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                @endif
            </div>
        @endif

        <div class="content">
            <div class="title m-b-md">
                Peter Home
            </div>

            <div class="links">
                <a href="https://laravel.com/docs">Laravel Documentation</a>
                <a href="https://github.com/yantianpi/laravelDemo">GitHub</a>
            </div>
        </div>
    </div>
@endsection

