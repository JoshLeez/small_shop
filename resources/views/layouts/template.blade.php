@extends('adminlte::page')

@section('css')
    @vite(['resources/js/main.js'])
@stop


@section('content_header')
    <div class="row d-none ">
        <div class="col-sm-6">
            <h1 class="mt-10">@yield('page_title')</h1>
        </div>
    </div>
@stop

@push('js')
    @vite(['resources/js/utils.js'])
@endpush

