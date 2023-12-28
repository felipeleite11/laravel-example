@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => '/sie/list/schedule', 'title' => 'Agenda' ],
        [ 'link' => null, 'title' => $schedule->event ]
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
        <h1>{{$schedule->event}}</h1>

        <p>Cidade / UF: <b>{{$schedule->city->description}} - {{$schedule->state->description}}</b></p>
        <p>Data/hora: <b>{{$schedule->datetime}}h</b></p>
        <p>Endereço: <b>{{$schedule->address}}</b></p>
        <p>Observação: <b>{{$schedule->observation}}</b></p>
    </div>

    <div class="card-action">
        <div class="center-align">
            <a class="btn transparent grey-text text-darken-3" href="/sie/list/schedule">Voltar à lista de comprimissos</a>
        </div>
    </div>
</div>

@endsection
