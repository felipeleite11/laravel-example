@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Cadastros' ],
        [ 'link' => null, 'title' => 'Atendimento' ]
    ];
@endphp

<x-notification :error="$errors" />

@section('main')

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card col s12 animate__animated animate__fadeIn animate__faster">

        <form action="{{isset($appointment) ? '/sie/appointment/update/'.$appointment->id : '/sie/store/appointment'}}" method="POST">
        @csrf

            <div class="card-content">

                <h1>{{isset($appointment->id) ? 'Editar' : 'Novo'}} Atendimento</h1>

                <div class="row">
                    <div class="col s12 l6">
                        <div class="input-field col s12">
                            <select name="administration" value="{{old('administration') ?? (isset($appointment) ? $appointment->administration : '')}}">
                                @foreach($administrations as $administration)
                                    <option value="{{$administration->id}}">{{$administration->description}}</option>
                                @endforeach
                            </select>
                            <label>Administração do Atendimento</label>
                        </div>

                        <div class="input-field col s12">
                            <select name="type" value="{{old('type') ?? (isset($appointment) ? $appointment->type : '')}}">
                                @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->description}}</option>
                                @endforeach
                            </select>
                            <label>Tipo de Atendimento</label>
                        </div>

                        <div class="input-field col s12">
                            <label for="field-date" class="form-label">Data da Solicitação</label>
                            <input type="date" name="date" class="datepicker" id="field-date" value="{{old('date') ?? (isset($appointment) ? $appointment->date_unix : '')}}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-name" class="form-label">Nome do atendido</label>
                            <input type="text" class="form-control" id="field-name" name="name" value="{{old('name') ?? (isset($appointment) ? $appointment->name : '')}}" />
                        </div>

                        <div class="input-field col s12">
                            <select name="state" value="{{old('state') ?? (isset($appointment) ? $appointment->state : '')}}">
                            </select>
                            <label>Estado</label>
                        </div>

                        <div class="input-field col s12">
                            <select name="city" disabled value="{{old('city') ?? (isset($appointment) ? $appointment->city : '')}}">
                            </select>
                            <label>Cidade</label>
                        </div>
                    </div>

                    <div class="col s12 l6">
                        <div class="input-field col s12">
                            <label for="field-phone" class="form-label">Celular</label>
                            <input type="text" class="form-control" id="field-phone" name="phone" value="{{old('phone') ?? (isset($appointment) ? $appointment->phone : '')}}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-observation" class="form-label">Observação</label>
                            <input type="text" class="form-control" id="field-observation" name="observation" value="{{old('observation') ?? (isset($appointment) ? $appointment->observation : '')}}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-reference" class="form-label">Referência</label>
                            <input type="text" class="form-control" id="field-reference" name="reference" value="{{old('reference') ?? (isset($appointment) ? $appointment->reference : '')}}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-appointment-responsible" class="form-label">Responsável pelo Atendimento</label>
                            <input type="text" class="form-control" id="field-appointment-responsible" name="responsible" value="{{old('responsible') ?? (isset($appointment) ? $appointment->responsible : '')}}" />
                        </div>

                        <div class="input-field col s12">
                            <select name="situation" value="{{old('situation') ?? (isset($appointment) ? $appointment->situation : '')}}">
                                @foreach($situations as $situation)
                                    <option value="{{$situation->id}}">{{$situation->description}}</option>
                                @endforeach
                            </select>
                            <label>Situação do Atendimento</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-action">

                @isset($appointment)
                    <a href="/sie/list/appointment" class="btn-flat btn-large waves-effect waves-light">
                        Voltar para Atendimentos
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

    <script type="text/javascript">
        $('input[name=phone]').mask('(00) 00000-0000')
    </script>

    @if(isset($appointment))
        <script type="text/javascript">
            window.addEventListener('loadCitiesReady', function() {
                window.setStateCity('{{$appointment->state->id}}', '{{$appointment->city->id}}')
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
