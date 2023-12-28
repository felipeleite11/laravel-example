@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => '/sie/list/proposition', 'title' => 'Proposições' ],
        [ 'link' => null, 'title' => $proposition->description ]
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
        <h1>{{$proposition->description}}</h1>

        <p>Número: <b>{{$proposition->number}}</b></p>
        <p>Data: <b>{{$proposition->date}}</b></p>
        <p>Ano: <b>{{$proposition->year}}</b></p>
        <p>Cidade / UF: <b>{{$proposition->city->description}} - {{$proposition->state->description}}</b></p>
        <p>Referência: <b>{{$proposition->reference}}</b></p>
        <p>Área: <b>{{$proposition->area}}</b></p>
        <p>Tipo: <b>{{$proposition->type->description}}</b></p>
        <p>Situação: <b>{{$proposition->situation->description}}</b></p>
        <p>Observação: <b>{{$proposition->observation}}</b></p>
    </div>

    <div class="card-action">
        <div class="center-align">
            <a class="btn transparent grey-text text-darken-3" href="/sie/list/proposition">Voltar à lista de proposições</a>
        </div>
    </div>
</div>

@endsection
