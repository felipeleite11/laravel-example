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
    </style>

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card animate__animated animate__fadeIn animate__faster">
        <div class="card-content">

            <h1>Dados populacionais por ano</h1>

            <div class="row">
                <div class="col s12">

                    @if(!isset($populations))
                        <p></p>
                    @elseif(count($populations) > 0)
                        @php
                            $state = $populations[0]->state;
                        @endphp

                        <h2>Dados Populacionais - {{$state->description}}</h2>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        @sortablelink('year', 'Ano')
                                    </th>
                                    <th scope="col">
                                        @sortablelink('quantity', 'População')
                                    </th>
                                    <th scope="col" class="hide-md">
                                        @sortablelink('men', 'Homens')
                                    </th>
                                    <th scope="col" class="hide-md">
                                        @sortablelink('women', 'Mulheres')
                                    </th>
                                    <th scope="col">
                                        @sortablelink('birth', 'Nascimentos')
                                    </th>
                                    <th scope="col">
                                        @sortablelink('death', 'Óbitos')
                                    </th>
                                    <th scope="col" class="hide-sm">Natalidade
                                        @sortablelink('birth_rate', 'Natalidade')
                                    </th>
                                    <th scope="col" class="hide-sm">
                                        @sortablelink('mortality_rate', 'Mortalidade')
                                    </th>
                                    <th class="action"></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($populations as $population)
                                    <tr>
                                        <td>{{$population->year}}</td>
                                        <td>{{number_format($population->quantity, 0, ',', '.')}}</td>
                                        <td class="hide-md">{{number_format($population->men, 0, ',', '.')}}</td>
                                        <td class="hide-md">{{number_format($population->women, 0, ',', '.')}}</td>
                                        <td>{{number_format($population->birth, 0, ',', '.')}}</td>
                                        <td>{{number_format($population->death, 0, ',', '.')}}</td>
                                        <td class="hide-sm">{{number_format($population->birth_rate, 2, ',', '.')}}</td>
                                        <td class="hide-sm">{{number_format($population->mortality_rate, 2, ',', '.')}}</td>
                                        <td class="action detail">
                                            <a href="/sie/population/{{$population->id}}/show">
                                                <i class="fa fa-search"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{$populations
                            ->appends(request()->input())
                            ->links('components.pagination', [
                                'paginator' => $populations
                            ])
                        }}
                    @else
                        <p class="empty-placeholder">Nenhum dado municipal cadastrado</p>
                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
