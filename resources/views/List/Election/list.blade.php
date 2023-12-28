@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consulta' ],
        [ 'link' => null, 'title' => 'Eleições' ]
    ];

    $currentYear = date('Y');

    $minYear = 2014;
    $maxYear = $currentYear;
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

        form .checkbox {
            margin-bottom: 18px !important;
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

            <h1>Dados eleitorais</h1>

            <form action="/sie/list/election/filter" method="GET">
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
                        <select name="job">
                            <option value="0">Selecione</option>
                            <option value="Governador">Governador</option>
                            <option value="Senador">Senador</option>
                            <option value="Deputado Federal">Deputado Federal</option>
                            <option value="Deputado Estadual">Deputado Estadual</option>
                            <option value="Prefeito">Prefeito</option>
                            <option value="Vereador">Vereador</option>
                        </select>
                        <label>Cargo eleitoral</label>
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

                    <label class="checkbox col s12 m6 l3">
                        <input name="elected_only" id="elected-only" type="checkbox" class="filled-in" />
                        <span>Apenas eleitos</span>
                    </label>

                    <button type="submit" class="btn-small blue waves-effect waves-light col s12 m6 l2 right">Pesquisar</button>
                </div>
            </form>

            @if(count($election) > 0)
                @php
                    $year = $election[0]->year;
                    $job = $election[0]->job;
                    $city = $election[0]->city;
                    $state = $election[0]->state;
                @endphp

                <h2>Eleição {{$year}} - {{$job}} - {{$city->description}} ({{$state->initials}})</h2>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                @sortablelink('name', 'Candidato / número')
                            </th>
                            <th scope="col">
                                @sortablelink('round', 'Turno')
                            </th>
                            <th scope="col">
                                @sortablelink('round_votes', 'Nº votos')
                            </th>
                            <th scope="col">
                                @sortablelink('party', 'Partido')
                            </th>
                            <th scope="col">
                                @sortablelink('situation_candidate', 'Situação')
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($election as $electionItem)
                            @php
                                $situationClass = '';

                                switch($electionItem->situation_candidate) {
                                    case 'ELEITO': $situationClass = 'elected'; break;
                                    case 'ELEITO POR QP': $situationClass = 'elected'; break;
                                    case 'ELEITO POR MÉDIA': $situationClass = 'elected'; break;
                                    case '2º TURNO': $situationClass = 'round-2'; break;
                                    case 'NÃO ELEITO': $situationClass = 'not-elected'; break;
                                    default: $$situationClass = '';
                                }
                            @endphp

                            <tr>
                                <td class="number-and-name">
                                    <span>{{$electionItem->number}}</span>
                                    <span>{{$electionItem->name}}</span>
                                </td>
                                <td>{{$electionItem->round}}º</td>
                                <td>{{number_format($electionItem->round_votes, 0, ',', '.')}}</td>
                                <td>{{$electionItem->party}}</td>
                                <td class="{{$situationClass}}">
                                    @if($situationClass === 'round-2')
                                        <div>
                                            <span>Classificado</span>
                                            <span>
                                                {{$electionItem->situation_candidate}}
                                            </span>
                                        </div>
                                    @else
                                        <span>{{$electionItem->situation_candidate}}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{$election
                    ->appends(request()->input())
                    ->links('components.pagination', [
                        'paginator' => $election
                    ])
                }}
            @endif

        </div>
    </div>

    <script>
        const yearSelect = $('select[name=year]')
        const jobSelect = $('select[name=job]')
        const stateSelect = $('select[name=state]')
        const citySelect = $('select[name=city]')

        if("{{isset($filters) ? $filters['year'] : ''}}" !== '') {
            yearSelect.val("{{isset($filters) ? $filters['year'] : ''}}")
            jobSelect.val("{{isset($filters) ? $filters['job']: ''}}")
            stateSelect.val("{{isset($filters) ? $filters['state'] : ''}}")

            yearSelect.formSelect()
            jobSelect.formSelect()
            stateSelect.formSelect()

            setTimeout(() => {
                citySelect.val("{{isset($filters) ? $filters['city'] : ''}}")

                citySelect.formSelect()
            }, 1000)
        }

        const jobGroups = [
            ['Governador', 'Senador', 'Deputado Federal', 'Deputado Estadual'],
            ['Prefeito', 'Vereador']
        ]

        yearSelect.change(function() {
            const disabledGroup = Number($(this).val()) % 4 === 0 ? 0 : 1
            const enabledGroup = disabledGroup === 1 ? 0 : 1

            // Desabilitando jobs
            for(const job of jobGroups[disabledGroup]) {
                $(`option[value='${job}']`).prop('disabled', true)
            }

            // Habilitando jobs
            for(const job of jobGroups[enabledGroup]) {
                $(`option[value='${job}']`).prop('disabled', false)
            }

            jobSelect.find('option:eq(0)').prop('selected', true)
            jobSelect.formSelect()
        })
    </script>

@endsection
