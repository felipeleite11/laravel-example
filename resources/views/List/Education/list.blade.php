@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consulta' ],
        [ 'link' => null, 'title' => 'Educação' ]
    ];

    $currentYear = date('Y');

    $minYear = 2007;
    $maxYear = $currentYear;
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

        table {
            margin-top: 24px;
        }

        h2 {
            font-size: 20px;
            font-weight: 600;
            text-align: center;
        }

        td:first-child {
            display: flex;
        }
        td.number-and-name > span:first-child {
            font-size: 10px;
            background-color: gray;
            color: #fff;
            padding: 2px;
            border-radius: 20%;
            width: auto;
            min-width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 8px;
        }

        .elected > span {
            background-color: #4caf50;
            color: #fff;
            padding: 6px 10px;
            border-radius: 6px;
        }

        .not-elected > span {
            background-color: #ffebee;
            padding: 6px 10px;
            border-radius: 6px;
        }

        .round-2 {
            padding: 0 5px;
        }
        .round-2 > div {
            background-color: #fff59d;
            padding: 6px 10px;
            border-radius: 6px;
            display: flex;
            flex-direction: column;
            width: fit-content;
            line-height: 11px;
        }
        .round-2 > div > span:first-child {
            font-size: 9px;
        }
        .round-2 > div > span:last-child {
            font-size: 13px;
        }
    </style>

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card animate__animated animate__fadeIn animate__faster">
        <div class="card-content">

            <h1>Dados educacionais (IDEB)</h1>

            <form action="/sie/list/education/filter" method="GET">
            @csrf
                <div class="row">
                    <div class="input-field col s12 m6 l3">
                        <select name="year">
                            <option value="0">Selecione...</option>

                            @for($i = $minYear; $i < $maxYear; $i = $i + 2)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        <label>Ano</label>
                    </div>

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

                    <button type="submit" class="btn-small blue waves-effect waves-light col s12 m6 l2 hide-md">Pesquisar</button>
                    <button type="submit" class="btn-small blue waves-effect waves-light right col s12 m3 hide-on-large-only">Pesquisar</button>
                </div>
            </form>

            @if(!isset($education))
                <p></p>
            @elseif(count($education) > 0)
                @php
                    $year = $education[0]->year;
                    $city = count($education) === 1 ? $education[0]->city : null;
                    $state = $education[0]->state;
                @endphp

                <h2>IDEB {{$year}} - {{isset($city) ? $city->description : ''}} {{isset($city) ? '('.$state->initials.')' : $state->initials}}</h2>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                @sortablelink('cities.description', 'Município')
                            </th>
                            <th scope="col">
                                @sortablelink('ideb_initials', 'IDEB anos iniciais')
                            </th>
                            <th scope="col">
                                @sortablelink('ideb_finals', 'IDEB anos finais')
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($education as $educationItem)
                            <tr>
                                <td>{{$educationItem->city->description}}</td>
                                <td>{{$educationItem->ideb_initials}}</td>
                                <td>{{$educationItem->ideb_finals}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="empty-placeholder">Nenhum dado educacional cadastrado</p>
            @endif
        </div>
    </div>

    <script>
        const yearSelect = $('select[name=year]')
        const stateSelect = $('select[name=state]')
        const citySelect = $('select[name=city]')

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
