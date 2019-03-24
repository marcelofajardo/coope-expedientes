
@extends('errors::illustrated-layout')

@section('code', '404')
@section('title', __('Page Not Found'))

@section('image')
    <div style="background-image: url({{ asset('/img/404.png') }});" class="absolute pin bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('Lo que Ud intenta visualizar, no existe'))
