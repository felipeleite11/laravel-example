@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => '/sie/list/population', 'title' => 'População' ],
        [ 'link' => null, 'title' => $population->state->description ]
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
        <h1>{{$population->state->description}} - {{$population->year}}</h1>

        <p>População total: <b>{{$population->quantity}}</b></p>
        <p>Homens: <b>{{$population->men}}</b></p>
        <p>Mulheres: <b>{{$population->women}}</b></p>
        <p>Nascimentos: <b>{{$population->birth}}</b></p>
        <p>Mortes: <b>{{$population->death}}</b></p>
        <p>Taxa de natalidade: <b>{{$population->birth_rate}}</b></p>
        <p>Taxa de mortalidade: <b>{{$population->mortality_rate}}</b></p>
    </div>

    <div class="card-action">
        <div class="center-align">
            <a class="btn transparent grey-text text-darken-3" href="/sie/list/population">Voltar aos dados populacionais</a>
        </div>
    </div>
</div>

@endsection
