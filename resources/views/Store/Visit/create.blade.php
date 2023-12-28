@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Cadastros' ],
        [ 'link' => null, 'title' => 'Visitas' ]
    ];
@endphp

<x-notification :error="$errors" />

@section('main')

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card col l12 animate__animated animate__fadeIn animate__faster">

        <form action="{{isset($visit) ? '/sie/visit/update/'.$visit->id : '/sie/store/visit'}}" method="POST">
        @csrf

            <div class="card-content">

                <h1>{{isset($contact->id) ? 'Editar' : 'Nova'}} Visita</h1>

                <div class="row">
                    <div class="col s12 m6 l6">
                        <div class="input-field">
                            <select name="state" value="{{old('state') ?? (isset($visit) ? $visit->state : '')}}">
                            </select>
                            <label for="field-state">Estado</label>
                        </div>

                        <div class="input-field" style="top: 10px">
                            <label for="field-place" class="form-label">Nome do local</label>
                            <input type="text" class="form-control" name="place" id="field-place" value="{{old('place') ?? (isset($visit) ? $visit->place : '')}}" />
                        </div>
                    </div>

                    <div class="col s12 m6 l6">
                        <div class="input-field" disabled>
                            <select name="city" value="{{old('city') ?? (isset($visit) ? $visit->city : '')}}" >
                            </select>
                            <label>Cidade</label>
                        </div>

                        <div class="input-field" style="top: 10px">
                            <label for="field-date" class="form-label">Data da visita</label>
                            <input type="date" name="date" class="datepicker" id="field-date" value="{{old('date') ?? (isset($visit) ? $visit->date_unix : '')}}" />
                        </div>
                    </div>

                    <div class="col s12">
                        <div class="input-field">
                            <label for="field-observation" class="form-label">Relatos da Visita</label>
                            <textarea type="text" class="form-control materialize-textarea" name="observation" id="field-observation">{{old('observation') ?? (isset($visit) ? $visit->observation : '')}}</textarea>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-action">

                @isset($visit)
                    <a href="/sie/list/visit" class="btn-flat btn-large waves-effect waves-light">
                        Voltar para Visitas
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

    @if(isset($visit))
        <script type="text/javascript">
            window.addEventListener('loadCitiesReady', function() {
                window.setStateCity('{{$visit->state->id}}', '{{$visit->city->id}}')
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
