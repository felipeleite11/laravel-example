@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => '/sie/list/contact', 'title' => 'Contatos' ],
        [ 'link' => null, 'title' => $contact->name ]
    ];
@endphp

<x-notification :error="$errors" />

@section('main')

<style>
    h1 {
        font-size: 26px;
        font-weight: 400;
    }
    h2 {
        font-size: 17px;
        font-weight: 700;
        padding-left: 10px;
        margin: 4px 0;
    }
    p {
        line-height: 36px;
        padding-left: 10px;
    }
</style>

<x-breadcrumb :pages="$breadcrumbs" />

<div class="card animate__animated animate__fadeIn animate__faster" id="card-appointments">
    <div class="card-content">
        <h1>{{$contact->name}}</h1>

        <h2>Pessoal</h2>
        <p>Apelido: <b>{{$contact->nick}}</b></p>
        <p>Aniversário: <b>{{$contact->birthdate}}</b></p>
        <p>Gênero: <b>{{$contact->gender}}</b></p>
        <p>Tipo: <b>{{$contact->type}}</b></p>
        <p>Ocupação: <b>{{$contact->occupation}}</b></p>

        <hr />

        <h2>Endereço</h2>
        <p>Cidade / UF: <b>{{$contact->city->description}} - {{$contact->state->description}}</b></p>
        <p>Endereço: <b>{{$contact->cep}} - {{$contact->address}} {{isset($contact->complement) ? $contact->complement.' ' : ''}}- {{$contact->district}}</b></p>
        <p>CEP: <b>{{$contact->cep}}</b></p>

        <hr />

        <h2>Contato</h2>
        <p>E-mail: <b>{{$contact->email}}</b></p>
        <p>Telefone fixo: <b>{{$contact->landline}}</b></p>
        <p>Fone: <b>{{$contact->phone}}</b></p>
        <p>Fone alternativo: <b>{{$contact->phone_2}}</b></p>

        <hr />

        <p>Observação: <b>{{$contact->observation}}</b></p>
        <p>Informações políticas: <b>{{$contact->political_info}}</b></p>
    </div>

    <div class="card-action">
        <div class="center-align">
            <a class="btn transparent grey-text text-darken-3" href="/sie/list/contact">Voltar à lista de contatos</a>
        </div>
    </div>
</div>

@endsection
