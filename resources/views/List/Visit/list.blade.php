@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => null, 'title' => 'Visitas' ]
    ];
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

            <h1>Visitas</h1>

            <form action="/sie/visit/filter" method="GET">
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
                        <label for="field-start-date" class="form-label">Data de início</label>
                        <input type="date" name="start_date" class="datepicker" id="field-start-date" />
                    </div>

                    <div class="input-field col s12 m6 l3">
                        <label for="field-end-date" class="form-label">Data de fim</label>
                        <input type="date" name="end_date" class="datepicker" id="field-end-date" />
                    </div>

                    <button type="submit" class="btn-small blue waves-effect waves-light right col s12 m3 l2">Pesquisar</button>
                </div>
            </form>

            @if(count($visits) > 0)

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">@sortablelink('cities.description', 'Município')</th>
                            <th scope="col">@sortablelink('place', 'Local')</th>
                            <th scope="col">@sortablelink('date', 'Data')</th>
                            <th scope="col" class="hide-md">Relatos da Visita</th>
                            <th class="action"></th>
                            <th class="action"></th>
                            <th class="action"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($visits as $visit)
                            @php
                                $isPast = $visit->is_past;
                            @endphp

                            <tr>
                                <td>{{$visit->city->description}}</td>
                                <td>{{$visit->place}}</td>
                                <td>{{$visit->date}}</td>
                                <td class="hide-md">{{$visit->observation}}</td>
                                <td class="action delete">
                                    <a href="/sie/destroy/visit/{{$visit->id}}" onclick="confirmation(event, this)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                                <td class="action edit">
                                    <a href="{{$isPast ? '#' : '/sie/visit/edit/'.$visit->id}}" class="{{$isPast ? 'disabled' : ''}}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                                <td class="action detail">
                                    <a href="/sie/visit/{{$visit->id}}/show">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{$visits
                    ->appends(request()->input())
                    ->links('components.pagination', [
                        'paginator' => $visits
                    ])
                }}
            @else
                <p class="empty-placeholder">Nenhuma visita cadastrada</p>

                <div class="center-align">
                    <a class="btn blue" href="/sie/store/visit">Cadastrar uma visita</a>
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

        if("{{isset($filters) ? $filters['state'] : ''}}" !== '') {
            stateSelect.val("{{isset($filters) ? $filters['state'] : ''}}")
            startDateInput.val("{{isset($filters) ? $filters['start_date'] : ''}}")
            endDateInput.val("{{isset($filters) ? $filters['end_date'] : ''}}")

            stateSelect.formSelect()

            setTimeout(() => {
                citySelect.val("{{isset($filters) ? $filters['city'] : ''}}")

                citySelect.formSelect()
            }, 1000)
        }
    </script>

@endsection
