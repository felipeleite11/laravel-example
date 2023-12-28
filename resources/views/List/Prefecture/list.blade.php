@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consulta' ],
        [ 'link' => null, 'title' => 'Dados municipais' ]
    ];
@endphp

<x-notification :error="$errors" />

@section('main')

    <style>
        .empty-placeholder {
            padding-top: 80px;
        }
        table {
            margin-top: 24px;
        }
        h2 {
            font-size: 20px;
            font-weight: 600;
            text-align: center;
        }
        form button {
            margin-top: 16px;
        }

        @media(min-width: 992px) {
            .card {
                width: 80vw;
                margin-left: -5vw;
            }
        }
    </style>

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card animate__animated animate__fadeIn animate__faster">
        <div class="card-content">

            <h1>Dados municipais</h1>

            <form action="/sie/list/prefecture/filter" method="GET">
            @csrf
                <div class="row">
                    <div class="input-field col s12 m4 l4">
                        <select name="state">
                        </select>
                        <label>Estado</label>
                    </div>

                    <div class="input-field col s12 m5 l4" disabled>
                        <select name="city">
                        </select>
                        <label>Município</label>
                    </div>

                    <button type="submit" class="btn-small blue waves-effect waves-light col s12 m3 l2 hide-sm">Pesquisar</button>
                    <button type="submit" class="btn-small blue waves-effect waves-light col s12 m4 l3 right hide-on-med-and-up">Pesquisar</button>
                </div>
            </form>

            @if(!isset($prefectures))
                <p></p>
            @elseif(count($prefectures) > 0)
                @php
                    $city = count($prefectures) === 1 ? $prefectures[0]->city : null;
                    $state = $prefectures[0]->state;
                @endphp

                <h2>Dados Municipais - {{isset($city) ? $city->description : ''}} {{isset($city) ? '('.$state->initials.')' : $state->description}}</h2>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                @sortablelink('cities.description', 'Município')
                            </th>
                            <th scope="col" class="hide-sm">Atual prefeito</th>
                            <th scope="col" class="hide-sm">Endereço da Prefeitura</th>
                            <th scope="col" class="hide-md">Gentílico</th>
                            <th scope="col" class="hide-md">
                                @sortablelink('association', 'Associação')
                            </th>
                            <th scope="col" class="hide-md">
                                @sortablelink('birthdate', 'Aniversário da cidade')
                            </th>
                            <th scope="col">Telefones</th>
                            <th class="action"></th>
                            <th class="action"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($prefectures as $prefecture)
                            <tr>
                                <td>{{$prefecture->city->description}}</td>
                                <td class="hide-sm">{{$prefecture->mayor->name ?? 'Não informado'}}</td>
                                <td class="hide-sm">{{$prefecture->address}} - {{$prefecture->neighborhood}} - {{$prefecture->zipcode}}</td>
                                <td class="hide-md">{{$prefecture->gentilic}}</td>
                                <td class="hide-md">{{$prefecture->association}}</td>
                                <td class="hide-md">{{$prefecture->birthdate}}</td>
                                <td>{{$prefecture->phone}}</td>
                                <td class="action edit">
                                    <a href="/sie/prefecture/edit/{{$prefecture->id}}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                                <td class="action detail">
                                    <a href="/sie/prefecture/{{$prefecture->id}}/show">
                                        <i class="fa fa-search"></i>
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
                <p class="empty-placeholder">Nenhum dado municipal cadastrado</p>
            @endif

        </div>
    </div>

    <script>
        const stateSelect = $('select[name=state]')
        const citySelect = $('select[name=city]')

        if("{{isset($filters) ? $filters['state'] : ''}}" !== '') {
            stateSelect.val("{{isset($filters) ? $filters['state'] : ''}}")
            stateSelect.formSelect()

            setTimeout(() => {
                citySelect.val("{{isset($filters) ? $filters['city'] : ''}}")

                citySelect.formSelect()
            }, 1000)
        }
    </script>

@endsection
