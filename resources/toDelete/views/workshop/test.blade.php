@extends('uxmal::layouts.master')
@section('title')
    Test Title
@endsection
@section('content')
    @include('uxmal::uxmal', [ 'data' => $uxmal_data ])
@endsection

@pushonce('scripts')
    <script type="module" src="{{ Vite::useBuildDirectory('workshop')->asset('resources/js/workshop.js') }}"></script>
@endpushonce

@section('javascript')
    @pushonce('DOMContentLoaded')
        if (window.init_listjs) {
        window.init_listjs();
        }
    @endpushonce
@endsection

