@extends('_Layouts/default')

<img src="{{ asset('images/header.png') }}" alt="">

@section('main')

    <style>
        .container {
            width: 98%;
        }

        #iframe-home {
            width: 100%;
            height: 100vh;
        }
    </style>

    <div>
        <iframe src="https://www.alepa.pa.gov.br/noticias.asp" frameborder="0" id="iframe-home"></iframe>
    </div>

@endsection
