@extends('layouts.main')

    @section('top-side')
        @include('partials.topbar')
        @include('partials.sidebar')
    @endsection


@section('container')
    @include('partials.altcontent')

    {{-- WRITE ALL THE CODES DOWN HERE --}}

@endsection
