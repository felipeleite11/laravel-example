@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Cadastros' ],
        [ 'link' => null, 'title' => 'Agenda' ]
    ];
@endphp

<x-notification :error="$errors" />

@section('main')

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card col l12 animate__animated animate__fadeIn animate__faster">

        <form action="{{
            isset($schedule) ?
                '/sie/schedule/update/'.$schedule->id :
                '/sie/store/schedule'
            }}"
            method="POST"
        >
        @csrf

            <div class="card-content">

                <h1>{{isset($contact->id) ? 'Editar' : 'Novo'}} Compromisso</h1>

                <div class="row">
                    <div class="col s12 l6">
                        <div class="input-field col s12">
                            <select name="state" required>
                            </select>
                            <label>Estado</label>
                        </div>

                        <div class="input-field col s12" disabled>
                            <select name="city" required>
                            </select>
                            <label>Cidade</label>
                        </div>

                        <div class="input-field col s12">
                            <label for="field-event" class="form-label">Evento</label>
                            <input type="text" class="form-control" id="field-event" name="event" required value="{{old('event') ?? (isset($schedule) ? $schedule->event : '')}}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-location" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="field-location" name="address" required value="{{old('address') ?? (isset($schedule) ? $schedule->address : '')}}" />
                        </div>
                    </div>

                    <div class="col s12 l6">
                        <div class="input-field col s12">
                            <label for="field-date" class="form-label">Data do evento</label>
                            <input type="date" name="date" class="datepicker" id="field-date" required value="{{old('date') ?? (isset($schedule) ? $schedule->date_unix : '')}}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-time" class="form-label">Horário</label>
                            <input type="text" class="timepicker" name="time" id="field-time" required value="{{old('time') ?? (isset($schedule) ? $schedule->time : '')}}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-observation" class="form-label">Observação</label>
                            <input type="text" class="form-control" id="field-observation" name="observation" value="{{old('observation') ?? (isset($schedule) ? $schedule->observation : '')}}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-action">

                @if(isset($schedule))
                    <a href="/sie/list/schedule" class="btn-flat btn-large waves-effect waves-light">
                        Voltar para a Agenda
                    </a>

                    <button type="submit" class="btn-large blue waves-effect waves-light">
                        Salvar alterações
                    </button>
                @else
                    <button type="submit" class="btn-large blue waves-effect waves-light">
                        Cadastrar
                    </button>
                @endif

            </div>

        </form>

    </div>

    @if(isset($schedule))
        <script type="text/javascript">
            window.addEventListener('loadCitiesReady', function() {
                window.setStateCity('{{$schedule->state->id}}', '{{$schedule->city->id}}')
            })
        </script>
    @endif

    <script>
        $(window).on('load', () => {
            $('label[for=field-date]').addClass('active')

            $('select').formSelect()
        })
    </script>

@endsection
