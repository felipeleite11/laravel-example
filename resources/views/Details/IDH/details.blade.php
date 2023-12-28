@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => '/sie/list/idh', 'title' => 'IDH' ],
        [ 'link' => null, 'title' => $idh->city->description.' - '.$idh->state->initials ]
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
        <h1>{{$idh->city->description}} - {{$idh->state->initials}} - {{$idh->year}}</h1>

        <p>IDHm: <b>{{$idh->idhm}}</b></p>
        <p>IDHmE: <b>{{$idh->idhmE}}</b></p>
        <p>IDHmL: <b>{{$idh->idhmL}}</b></p>
        <p>IDHmR: <b>{{$idh->idhmR}}</b></p>
    </div>

    <div class="card-action">
        <div class="center-align">
            <a class="btn transparent grey-text text-darken-3" href="/sie/list/idh">Voltar à lista de IDH</a>
        </div>
    </div>
</div>

@endsection
