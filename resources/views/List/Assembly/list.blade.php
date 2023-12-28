@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => null, 'title' => 'Câmara Municipal' ]
    ];
@endphp

<x-notification :error="$errors" />

@section('main')

    <style>
        h1.subtitle {
            font-size: 20px;
            font-weight: 600;
            text-align: center;
        }
        form button {
            margin-top: 16px;
        }
        .assembly-data-container {
            line-height: 30px;
        }
        table {
            margin-top: 24px;
        }
    </style>

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card animate__animated animate__fadeIn animate__faster">
        <div class="card-content">

            <h1>Câmaras Municipais</h1>

            <form action="/sie/assembly/filter" method="GET">
            @csrf
                <div class="row">
                    <div class="input-field col s12 m4 l3">
                        <select name="state">
                        </select>
                        <label>Estado</label>
                    </div>

                    <div class="input-field col s12 m4 l3" disabled>
                        <select name="city">
                        </select>
                        <label>Município</label>
                    </div>

                    <button type="submit" class="btn-small blue waves-effect waves-light col s12 m4 l2">Pesquisar</button>
                </div>
            </form>

            @if(isset($assembly))
                <div class="assembly-data-container row">
                    <p class="col s12 m6 l4">
                        <span>Município:</span>
                        <b>{{$assembly->city->description}}</b>
                    </p>

                    <p class="col s12 m12 l8">
                        <span>Endereço:</span>
                        <b>{{$assembly->address}}</b>
                    </p>

                    <p class="col s12 m6 l4">
                        <span>Bairro:</span>
                        <b>{{$assembly->neighborhood}}</b>
                    </p>

                    <p class="col s12 m6 l4">
                        <span>CEP:</span>
                        <b>{{$assembly->zipcode}}</b>
                    </p>

                    <p class="col s12 m6 l4">
                        <span>Fone:</span>
                        <b>{{$assembly->phone}}</b>
                    </p>

                    <p class="col s12 m6 l4">
                        <span>E-mail:</span>
                        <b>{{$assembly->email}}</b>
                    </p>

                    <p class="col s12 m6 l8">
                        <span>Atual presidente:</span>
                        <b>{{$president->name ?? 'Não informado'}} {{isset($president) ? '('.$president->votes.' votos)' : ''}}</b>
                    </p>
                </div>
            @endif

            @if(!isset($assemblymen))
                <p></p>
            @elseif(count($assemblymen) > 0)
                <h1 class="subtitle">Vereadores de {{$assembly->city->description}} - {{$year}}</h1>

                <table class="table" id="contact-table">
                    <thead>
                        <tr>
                            <th scope="col">
                                @sortablelink('name', 'Nome')
                            </th>
                            <th scope="col" class="hide-md">
                                @sortablelink('nickname', 'Apelido')
                            </th>
                            <th scope="col" class="hide-sm">
                                @sortablelink('party', 'Partido')
                            </th>
                            <th scope="col">
                                @sortablelink('total_votes', 'Total votos')
                            </th>
                            <th class="action"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($assemblymen as $assemblyman)
                            <tr>
                                <td>{{$assemblyman->name}}</td>
                                <td class="hide-md">{{$assemblyman->nickname}}</td>
                                <td class="hide-sm">{{$assemblyman->party}}</td>
                                <td>{{$assemblyman->total_votes}}</td>
                                <td class="action detail">
                                    <a href="/sie/assembly/{{$assemblyman->year}}/{{$assemblyman->number}}/{{$assembly->city->id}}/show">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{$assemblymen
                    ->appends(request()->input())
                    ->links('components.pagination', [
                        'paginator' => $assemblymen
                    ])
                }}
            @else
                <p class="empty-placeholder">Nenhum dado de Câmaras Municipais cadastrado</p>
            @endif
        </div>
    </div>

    <script>
        const stateSelect = $('select[name=state]')
        const citySelect = $('select[name=city]')

        if("{{isset($filters) ? $filters['state'] : ''}}" !== '') {
            stateSelect.formSelect()

            setTimeout(() => {
                citySelect.val("{{isset($filters) ? $filters['city'] : ''}}")

                citySelect.formSelect()
            }, 1000)
        }
    </script>

@endsection
