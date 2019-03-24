@extends('errors::illustrated-layout')

@section('code', '500')
@section('title', __('Error'))

@section('image')
    <div style="background-image: url({{ asset('/img/500.img') }});" class="absolute bg-cover pin bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('Error interno del Servidor. Por favor informar al Administrador!!!'))
