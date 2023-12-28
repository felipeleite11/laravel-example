@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => '/sie/list/prefecture', 'title' => 'Dados municipais' ],
        [ 'link' => null, 'title' => $prefecture->city->description.' - '.$prefecture->state->description ]
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
        <h1>{{$prefecture->city->description}} - {{$prefecture->state->initials}}</h1>

        <p>Endereço: <b>{{$prefecture->address}} - {{$prefecture->neighborhood}} - {{$prefecture->zipcode}}</b></p>
        <p>Gentílico: <b>{{$prefecture->gentilic}}</b></p>
        <p>Data de nascimento: <b>{{$prefecture->birthdate}}</b></p>
        <p>Phone: <b>{{$prefecture->phone}}</b></p>
        <p>Associação: <b>{{$prefecture->association}}</b></p>
    </div>

    <div class="card-action">
        <div class="center-align">
            <a class="btn transparent grey-text text-darken-3" href="/sie/list/prefecture">Voltar aos dados municipais</a>
        </div>
    </div>
</div>

@endsection
