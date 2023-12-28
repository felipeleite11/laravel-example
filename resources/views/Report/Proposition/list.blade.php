@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => null, 'title' => 'Proposições' ]
    ];

    $currentYear = date('Y');

    $minYear = 2020;
    $maxYear = $currentYear + 2;
@endphp

<x-notification :error="$errors" />

@section('main')

    <style>
        .empty-placeholder {
            padding-top: 80px;
        }
        .form {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 14px;
            align-items: baseline;
        }
        .form .input-field > label {
            left: 0;
        }
    </style>

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card animate__animated animate__fadeIn animate__faster">
        <div class="card-content">

            <h1>Proposições</h1>

            <form action="/report/proposition/filter" method="POST" class="form">
            @csrf

                <div class="input-field col s12">
                    <select name="year">
                        <option value="0">Todos os anos</option>

                        @for($i = $minYear; $i < $maxYear; $i++)
                            @if(isset($searched_year) && $searched_year == $i)
                                <option value="{{$i}}" selected>{{$i}}</option>
                            @else
                                <option value="{{$i}}">{{$i}}</option>
                            @endif
                        @endfor
                    </select>
                    <label>Ano</label>
                </div>

                <button type="submit" class="btn-small blue waves-effect waves-light">Pesquisar</button>
            </form>

            @if(count($propositions) > 0)

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Tipo</th>
                            <th scope="col">Número</th>
                            <th scope="col">Ano</th>
                            <th scope="col">Data de entrada</th>
                            <th scope="col">Situação da Proposição</th>
                            <th style="width: 34px"></th>
                            <th style="width: 34px"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($propositions as $proposition)
                            <tr>
                                <td>{{$proposition->type->description}}</td>
                                <td>{{$proposition->number}}</td>
                                <td>{{$proposition->year}}</td>
                                <td>{{$proposition->date}}</td>
                                <td>{{$proposition->situation->description}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @else
                @if(isset($searched_year))
                    <p class="empty-placeholder">Nenhuma proposição cadastrada para {{$searched_year}}</p>
                @else
                    <p class="empty-placeholder">Nenhuma proposição cadastrada</p>
                @endif

                <div class="center-align">
                    <a class="btn blue" href="/sie/store/proposition">Cadastrar uma proposição</a>
                </div>

            @endif

        </div>
    </div>

@endsection
