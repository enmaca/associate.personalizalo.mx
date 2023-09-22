@extends('layouts.master')
@section('title')
    @lang('translation.dashboards')
@endsection
@section('css')
@endsection
@section('content')
    <div>
        {{-- The Master doesn't talk, he acts. --}}
    </div>
@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
