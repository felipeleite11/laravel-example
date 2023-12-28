@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => '/sie/list/appointment', 'title' => 'Atendimentos' ],
        [ 'link' => null, 'title' => $appointment->name ]
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
        <h1>{{$appointment->name}}</h1>

        <p>Data: <b>{{$appointment->date}}</b></p>
        <p>Telefone: <b>{{$appointment->phone}}</b></p>
        <p>Observação: <b>{{$appointment->observation}}</b></p>
        <p>Cidade / UF: <b>{{$appointment->city->description}} - {{$appointment->state->description}}</b></p>
        <p>Administração: <b>{{$appointment->administration->description}}</b></p>
        <p>Situação: <b>{{$appointment->situation->description}}</b></p>
        <p>Responsável: <b>{{$appointment->responsible}}</b></p>
        <p>Referência: <b>{{$appointment->reference}}</b></p>
        <p>Tipo: <b>{{$appointment->type->description}}</b></p>
    </div>

    <div class="card-action">
        <div class="center-align">
            <a class="btn transparent grey-text text-darken-3" href="/sie/list/appointment">Voltar à lista de agendamentos</a>
        </div>
    </div>
</div>

@endsection
