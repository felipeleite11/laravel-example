@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => '/sie/list/visit', 'title' => 'Visitas' ],
        [ 'link' => null, 'title' => $visit->place ]
    ];
@endphp

<x-notification :error="$errors" />

@section('main')

<style>
    h1 {
        font-size: 26px;
        font-weight: 400;
    }
    p {
        line-height: 36px;
        padding-left: 10px;
    }
</style>

<x-breadcrumb :pages="$breadcrumbs" />

<div class="card animate__animated animate__fadeIn animate__faster" id="card-appointments">
    <div class="card-content">
        <h1>{{$visit->place}}</h1>

        <p>Data: <b>{{$visit->date}}</b></p>
        <p>Cidade / UF: <b>{{$visit->city->description}} - {{$visit->state->description}}</b></p>
        <p>Observação: <b>{{$visit->observation}}</b></p>
    </div>

    <div class="card-action">
        <div class="center-align">
            <a class="btn transparent grey-text text-darken-3" href="/sie/list/visit">Voltar à lista de visitas</a>
        </div>
    </div>
</div>

@endsection
