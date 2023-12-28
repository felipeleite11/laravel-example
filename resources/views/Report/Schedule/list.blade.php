@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Relatórios' ],
        [ 'link' => null, 'title' => 'Agenda' ]
    ];

    $years = [];
    $initialYear = 2021;
    $currentYear = date('Y');

    for($i = $initialYear; $i <= $currentYear; $i++) {
        $years[$i] = $i;
    }
@endphp

<x-notification :error="$errors" />

@section('main')

    <style>
        .past {
            opacity: 0.5;
        }
        .empty-placeholder {
            padding-top: 80px;
        }
        .inline-form {
            display: flex;
            gap: 14px;
            align-items: baseline;
        }
        .inline-form .input-field > label {
            left: 0;
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

            <h1>Agenda anual</h1>

            <form action="/report/schedule/filter" method="POST" class="inline-form">
            @csrf

                <div class="input-field col s12">
                    <select name="year">
                        <option value="0">Todos os anos</option>

                        @foreach($years as $year)
                            @if(isset($searched_year) && $searched_year == $year)
                                <option value="{{$year}}" selected>{{$year}}</option>
                            @else
                                <option value="{{$year}}">{{$year}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label>Ano</label>
                </div>

                <button type="submit" class="btn-small blue waves-effect waves-light">Pesquisar</button>
            </form>

            @if(count($schedules) > 0)
                <h2>Agenda - {{isset($searched_year) && $searched_year != 0 ? $searched_year : 'Todos os anos'}}</h2>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Evento</th>
                            <th scope="col">Município</th>
                            <th scope="col">Endereço</th>
                            <th scope="col">Data / hora</th>
                            <th scope="col">Observação</th>
                            <th style="width: 34px"></th>
                            <th style="width: 34px"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($schedules as $schedule)
                            @php
                                $isPast = $schedule->is_past;
                            @endphp

                            <tr>
                                <td>{{$schedule->event}}</td>
                                <td>{{$schedule->city->description}}</td>
                                <td>{{$schedule->address}}</td>
                                <td>{{$schedule->date}} {{$schedule->time}}h</td>
                                <td>{{$schedule->observation}}</td>
                                <td class="delete">
                                    @if(!$isPast)
                                        <a href="/sie/destroy/schedule/{{$schedule->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    @endif
                                </td>
                                <td class="edit">
                                    @if(!$isPast)
                                        <a href="/sie/edit/schedule/{{$schedule->id}}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                @if(!isset($searched_year))
                    <p class="empty-placeholder">Nenhum compromisso agendado</p>
                @else
                    <p class="empty-placeholder">Nenhum compromisso agendado para {{$searched_year}}</p>
                @endif

                <div class="center-align">
                    <a class="btn blue" href="/sie/store/schedule">Cadastrar um compromisso</a>
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
