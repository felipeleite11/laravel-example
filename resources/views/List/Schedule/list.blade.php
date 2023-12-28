@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => null, 'title' => 'Agenda' ]
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

            <h1>Agenda</h1>

            <form action="/sie/schedule/filter" method="GET">
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

                    <div class="input-field col s12 m6 l2">
                        <label for="field-start-date" class="form-label">Data de início</label>
                        <input type="date" name="start_date" class="datepicker" id="field-start-date" />
                    </div>

                    <div class="input-field col s12 m6 l2">
                        <label for="field-end-date" class="form-label">Data de fim</label>
                        <input type="date" name="end_date" class="datepicker" id="field-end-date" />
                    </div>

                    <button type="submit" class="btn-small blue waves-effect waves-light right col s12 m3 l2">Pesquisar</button>
                </div>
            </form>

            @if(count($schedules) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">
                                @sortablelink('event', 'Evento')
                            </th>
                            <th scope="col" class="hide-sm">
                                @sortablelink('cities.description', 'Município')
                            </th>
                            <th scope="col" class="hide-sm">Endereço</th>
                            <th scope="col">
                                @sortablelink('datetime', 'Data/hora')
                            </th>
                            <th scope="col" class="hide-md">Observação</th>
                            <th class="action"></th>
                            <th class="action"></th>
                            <th class="action"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($schedules as $schedule)
                            @php
                                $isPast = $schedule->is_past;
                            @endphp

                            <tr class="{{$isPast ? 'past' : ''}}">
                                <td>{{$schedule->event}}</td>
                                <td class="hide-sm">{{$schedule->city->description}}</td>
                                <td class="hide-sm">{{$schedule->address}}</td>
                                <td>{{$schedule->datetime.'h'}}</td>
                                <td class="hide-md">{{$schedule->observation}}</td>
                                <td class="action delete">
                                    <a href="/sie/destroy/schedule/{{$schedule->id}}" onclick="confirmation(event, this)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                                <td class="action edit">
                                    <a href="{{$isPast ? '#' : '/sie/schedule/edit/'.$schedule->id}}" class="{{$isPast ? 'disabled' : ''}}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                                <td class="action detail">
                                    <a href="/sie/schedule/{{$schedule->id}}/show">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{$schedules
                    ->appends(request()->input())
                    ->links('components.pagination', [
                        'paginator' => $schedules
                    ])
                }}
            @else
                <p class="empty-placeholder">Nenhum compromisso agendado</p>

                <div class="center-align">
                    <a class="btn blue" href="/sie/store/schedule">Cadastrar um compromisso</a>
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
            startDateInput.val("{{$filters['start_date'] ?? ''}}")
            endDateInput.val("{{$filters['end_date'] ?? ''}}")
            stateSelect.val("{{$filters['state'] ?? ''}}")

            stateSelect.formSelect()

            setTimeout(() => {
                citySelect.val("{{isset($filters) ? $filters['city'] : ''}}")

                citySelect.formSelect()
            }, 1000)
        }
    </script>

@endsection
