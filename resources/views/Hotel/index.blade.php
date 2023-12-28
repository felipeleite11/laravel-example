@extends('_Layouts/default')

<x-notification :error="$errors" />

@section('main')

    <style>
        .container {
            width: 98%;
        }

        #iframe-hotel {
            width: 100%;
            height: 82vh;
        }
    </style>

    <iframe src="https://www.booking.com/" frameborder="0" id="iframe-hotel"></iframe>

@endsection
