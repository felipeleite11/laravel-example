@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Relatórios' ],
        [ 'link' => null, 'title' => 'Aniversário de municípios' ]
    ];
@endphp

<x-notification :error="$errors" />

@section('main')

    <style>
        .past td:not(.edit, .delete) {
            opacity: 0.5;
        }
        .empty-placeholder {
            padding-top: 80px;
        }
        form button {
            margin-top: 16px;
        }
    </style>

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card animate__animated animate__fadeIn animate__faster">
        <div class="card-content">

            <h1>Aniversário de municípios</h1>

            <form action="/sie/city_birthdate/filter" method="GET">
            @csrf
                <div class="row">
                    <div class="input-field col s12 m6 l3">
                        <select name="state">
                        </select>
                        <label>Estado</label>
                    </div>

                    <div class="input-field col s12 m6 l3">
                        <select name="month">
                            <option value="0">Selecione...</option>
                            <option value="1">Janeiro</option>
                            <option value="2">Fevereiro</option>
                            <option value="3">Março</option>
                            <option value="4">Abril</option>
                            <option value="5">Maio</option>
                            <option value="6">Junho</option>
                            <option value="7">Julho</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezembro</option>
                        </select>
                        <label>Mês</label>
                    </div>

                    <button type="submit" class="btn-small blue waves-effect waves-light col s12 m6 l2 hide-md">Pesquisar</button>
                    <button type="submit" class="btn-small blue waves-effect waves-light col s12 m3 right hide-on-large-only">Pesquisar</button>
                </div>
            </form>

            @if(count($prefectures) > 0)

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                @sortablelink('cities.description', 'Município')
                            </th>
                            <th scope="col">
                                @sortablelink('birthdate', 'Data do aniversário')
                            </th>
                            <th class="action"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($prefectures as $prefecture)
                            <tr>
                                <td>{{$prefecture->city->description}}</td>
                                <td>{{$prefecture->birthdate}}</td>
                                <td class="action edit">
                                    <a href="/sie/city_birthdate/edit/{{$prefecture->id}}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{$prefectures
                    ->appends(request()->input())
                    ->links('components.pagination', [
                        'paginator' => $prefectures
                    ])
                }}

            @else
                <p class="empty-placeholder">Nenhum aniversário cadastrado</p>

                <div class="center-align">
                    <a class="btn blue" href="/sie/store/city_birthdate">Cadastrar um aniversário</a>
                </div>
            @endif

        </div>
    </div>

    <script>
        $(window).on('load', () => {
            $('label[for=field-start-date]').addClass('active')
            $('label[for=field-end-date]').addClass('active')
        })
    </script>

@endsection
