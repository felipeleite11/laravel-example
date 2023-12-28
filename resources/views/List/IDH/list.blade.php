@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Dados municipais' ],
        [ 'link' => null, 'title' => 'IDH' ]
    ];
@endphp

<x-notification :error="$errors" />

@section('main')

    <style>
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

            <h1>IDH</h1>

            <form action="/sie/idh/filter" method="">
            @csrf
                <div class="row">
                    <div class="input-field col s12 m6 l3">
                        <select name="state">
                        </select>
                        <label>Estado</label>
                    </div>

                    <div class="input-field col s12 m6 l3" disabled>
                        <select name="city">
                        </select>
                        <label>Município</label>
                    </div>

                    <div class="input-field col s12 m6 l3">
                        <select name="year">
                            <option value="0">Todos os anos</option>
                            <option value="2000">2000</option>
                            <option value="2010">2010</option>
                        </select>
                        <label>Ano</label>
                    </div>

                    <button type="submit" class="btn-small blue waves-effect waves-light col s12 m6 l2 hide-md">Pesquisar</button>
                    <button type="submit" class="btn-small blue waves-effect waves-light right col s12 m3 hide-on-large-only">Pesquisar</button>
                </div>
            </form>

            @if(count($idhs) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                @sortablelink('cities.description', 'Município')
                            </th>
                            <th scope="col">
                                @sortablelink('year', 'Ano')
                            </th>
                            <th scope="col">
                                @sortablelink('idhm', 'idhm')
                            </th>
                            <th scope="col">
                                @sortablelink('idhmE', 'idhmE')
                            </th>
                            <th scope="col">
                                @sortablelink('idhmL', 'idhmL')
                            </th>
                            <th scope="col">
                                @sortablelink('idhmR', 'idhmR')
                            </th>
                            <th class="action"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($idhs as $idh)
                            <tr>
                                <td>{{$idh->city->description}}</td>
                                <td>{{$idh->year}}</td>
                                <td>{{$idh->idhm}}</td>
                                <td>{{$idh->idhmE}}</td>
                                <td>{{$idh->idhmL}}</td>
                                <td>{{$idh->idhmR}}</td>
                                <td class="action detail">
                                    <a href="/sie/idh/{{$idh->city->id}}/{{$idh->year}}/show">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{$idhs
                    ->appends(request()->input())
                    ->links('components.pagination', [
                        'paginator' => $idhs
                    ])
                }}
            @else
                <p class="empty-placeholder">Nenhum IDH cadastrado</p>
            @endif

        </div>
    </div>

    <script>
        const stateSelect = $('select[name=state]')
        const citySelect = $('select[name=city]')
        const yearSelect = $('select[name=year]')

        if("{{isset($filters) ? $filters['state'] : ''}}" !== '') {
            stateSelect.val("{{isset($filters) ? $filters['state'] : ''}}")
            yearSelect.val("{{isset($filters) ? $filters['year'] : ''}}")

            stateSelect.formSelect()
            yearSelect.formSelect()

            setTimeout(() => {
                citySelect.val("{{isset($filters) ? $filters['city'] : ''}}")

                citySelect.formSelect()
            }, 1000)
        }
    </script>
@endsection
