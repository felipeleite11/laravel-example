@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => '/sie/list/assembly', 'title' => 'Câmaras municipais' ],
        [ 'link' => null, 'title' => $assemblymen->name ]
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
        <h1>{{$assemblymen->name}} ({{$assemblymen->nickname}})</h1>

        <p>Município / UF: <b>{{$assemblymen->city->description}} - {{$assemblymen->state->description}}</b></p>
        <p>Partido: <b>{{$assemblymen->party}}</b></p>
        <p>Cargo: <b>{{$assemblymen->job}}</b></p>
        <p>Número do candidato: <b>{{$assemblymen->number}}</b></p>
        <p>Total de votos em {{$assemblymen->year}}: <b>{{$assemblymen->total_votes}}</b></p>
        <p>Situação: <b>{{$assemblymen->situation_detail}}</b></p>
        <p>Situação da candidatura: <b>{{$assemblymen->situation_candidate}}</b></p>
    </div>

    <div class="card-action">
        <div class="center-align">
            <a class="btn transparent grey-text text-darken-3" href="/sie/list/assembly">Voltar à lista de Câmaras Municipais</a>
        </div>
    </div>
</div>

@endsection
