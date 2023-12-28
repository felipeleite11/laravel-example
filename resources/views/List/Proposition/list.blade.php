@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => null, 'title' => 'Proposições' ]
    ];

    $currentYear = date("Y");

    $minYear = 2020;
    $maxYear = $currentYear + 2;
@endphp

<x-notification :error="$errors" />

@section('main')

    <style>
        .empty-placeholder {
            padding-top: 80px;
        }
    </style>

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card animate__animated animate__fadeIn animate__faster">
        <div class="card-content">

            <h1>Proposições</h1>

            <form action="/sie/proposition/filter" method="GET">
            @csrf
                <div class="row">
                    <div class="input-field col s12 m6 l3">
                        <select name="year">
                            <option value="">Todos os anos</option>
                            @for($i = $minYear; $i < $maxYear; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        <label>Ano</label>
                    </div>

                    <div class="input-field col s12 m6 l3">
                        <select name="situation">
                            <option value="">Todas as situações</option>
                            @foreach($situations as $situation)
                                <option value="{{$situation->id}}">{{$situation->description}}</option>
                            @endforeach
                        </select>
                        <label>Situação</label>
                    </div>

                    <div class="input-field col s12 m6 l3">
                        <label for="field-start-date" class="form-label">Data de início</label>
                        <input type="date" name="start_date" class="datepicker" id="field-start-date" />
                    </div>

                    <div class="input-field col s12 m6 l3">
                        <label for="field-end-date" class="form-label">Data de fim</label>
                        <input type="date" name="end_date" class="datepicker" id="field-end-date" />
                    </div>

                    <div class="input-field col s12 m6 l3">
                        <select name="type">
                            <option value="">Todos os tipos</option>
                            @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->description}}</option>
                            @endforeach
                        </select>
                        <label>Tipo</label>
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

                    <div class="input-field col s12 m6 l3">
                        <label for="field-number" class="form-label">Número</label>
                        <input type="number" name="number" id="field-number" />
                    </div>

                    <button type="submit" class="btn-small blue waves-effect waves-light right col s12 m3 l2">Pesquisar</button>
                </div>
            </form>

            @if(count($propositions) > 0)

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Tipo</th>
                            <th scope="col">@sortablelink('cities.description', 'Município')</th>
                            <th scope="col" class="hide-sm">@sortablelink('number', 'Numero')</th>
                            <th scope="col">@sortablelink('year', 'Ano')</th>
                            <th scope="col" class="hide-md">@sortablelink('date', 'Data de entrada')</th>
                            <th scope="col" class="hide-sm">Situação da Proposição</th>
                            <th class="action"></th>
                            <th class="action"></th>
                            <th class="action"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($propositions as $proposition)
                            @php
                                $isPast = $proposition->is_past;
                            @endphp

                            <tr class="{{$isPast ? 'past' : ''}}">
                                <td>{{$proposition->type->description}}</td>
                                <td>{{$proposition->city->description}}</td>
                                <td class="hide-sm">{{$proposition->number}}</td>
                                <td>{{$proposition->year}}</td>
                                <td class="hide-md">{{$proposition->date}}</td>
                                <td class="hide-sm">{{$proposition->situation->description}}</td>
                                <td class="action delete">
                                    <a href="/sie/destroy/proposition/{{$proposition->id}}" onclick="confirmation(event, this)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                                <td class="action edit">
                                    <a href="{{$isPast ? '#' : '/sie/proposition/edit/'.$proposition->id}}" class="{{$isPast ? 'disabled' : ''}}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                                <td class="action detail">
                                    <a href="/sie/proposition/{{$proposition->id}}/show">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{$propositions
                    ->appends(request()->input())
                    ->links('components.pagination', [
                        'paginator' => $propositions
                    ])
                }}
            @else
                <p class="empty-placeholder">Nenhuma proposição cadastrada</p>

                <div class="center-align">
                    <a class="btn blue" href="/sie/store/proposition">Cadastrar uma proposição</a>
                </div>
            @endif

        </div>
    </div>

    <script>
        setTimeout(() => {
            $('label[for=field-start-date]').addClass('active')
            $('label[for=field-end-date]').addClass('active')
        }, 200)

        const stateSelect = $('select[name=state]')
        const citySelect = $('select[name=city]')
        const startDateInput = $('input[name=start_date]')
        const endDateInput = $('input[name=end_date]')
        const yearSelect = $('select[name=year]')
        const situationSelect = $('select[name=situation]')
        const typeSelect = $('select[name=type]')
        const numberInput = $('input[name=number]')

        if("{{isset($filters) ? $filters['state'] : ''}}" !== '') {
            stateSelect.val("{{isset($filters) ? $filters['state'] : ''}}")
            startDateInput.val("{{isset($filters) ? $filters['start_date'] : ''}}")
            endDateInput.val("{{isset($filters) ? $filters['end_date'] : ''}}")
            citySelect.val("{{isset($filters) ? $filters['city'] : ''}}")
            yearSelect.val("{{isset($filters) ? $filters['year'] : ''}}")
            typeSelect.val("{{isset($filters) ? $filters['type'] : ''}}")
            numberInput.val("{{isset($filters) ? $filters['number'] : ''}}")

            stateSelect.formSelect()
            yearSelect.formSelect()
            typeSelect.formSelect()

            setTimeout(() => {
                citySelect.val("{{isset($filters) ? $filters['city'] : ''}}")
                situationSelect.val("{{isset($filters) ? $filters['situation'] : ''}}")

                citySelect.formSelect()
                situationSelect.formSelect()
            }, 1000)
        }
    </script>

@endsection
