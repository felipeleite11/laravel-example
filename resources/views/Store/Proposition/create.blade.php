@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Cadastros' ],
        [ 'link' => null, 'title' => 'Proposições' ]
    ];

    $currentYear = date("Y");

    $minYear = 2018;
    $maxYear = $currentYear + 10;
@endphp

<x-notification :error="$errors" />

@section('main')

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card col animate__animated animate__fadeIn animate__faster">

        <form action="{{isset($proposition) ? '/sie/proposition/update/'.$proposition->id : '/sie/store/proposition'}}" method="POST" enctype="multipart/form-data">
        @csrf

            <div class="card-content">

                <h1>{{isset($proposition->id) ? 'Editar' : 'Novo'}} Proposição</h1>

                <div class="row">
                    <div class="col s12 l6">
                        <div class="input-field col s12">
                            <select name="type" value="{{old('type') ?? (isset($proposition) ? $proposition->type : '' ) }}">
                                <option value="1">PROJETO DE DECRETO LEGISLATIVO</option>
                                <option value="2">PROJETO DE EMENDA CONSTITUCIONAL</option>
                                <option value="3">PROJETO DE DECRETO LEGISLATIVO</option>
                                <option value="4">PROJETO DE INDICAÇÃO</option>
                                <option value="5">PROJETO DE LEI</option>
                                <option value="6">PROJETO DE LEI COMPLEMENTAR</option>
                                <option value="7">PROJETO DE RESOLUÇÃO</option>
                                <option value="8">MOÇÃO</option>
                                <option value="9">REQUERIMENTO</option>
                            </select>
                            <label>Tipo de proposição</label>
                        </div>

                        <div class="input-field col s12">
                            <label for="field-number" class="form-label">Número</label>
                            <input type="text" class="form-control" name="number" id="field-number" value="{{old('number') ?? (isset($proposition) ? $proposition->number : '' ) }}" />
                        </div>

                        <div class="input-field col s12">
                            <select name="year" value="{{old('year') ?? (isset($proposition) ? $proposition->year : '' ) }}">

                                @for($i = $minYear; $i < $maxYear; $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor

                            </select>
                            <label>Selecione o ano</label>
                        </div>

                        <div class="input-field col s12">
                            <label for="field-date" class="form-label">Data de entrada</label>
                            <input type="date" name="date" class="datepicker" id="field-date" value="{{old('date') ?? (isset($proposition) ? $proposition->date_unix : '')}}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-description" class="form-label">Descrição</label>
                            <input type="text" class="form-control" name="description" id="field-description" value="{{old('description') ?? (isset($proposition) ? $proposition->description : '')}}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-observation" class="form-label">Observação</label>
                            <input type="text" class="form-control" name="observation" id="field-observation" value="{{old('observation') ?? (isset($proposition) ? $proposition->observation : '')}}" />
                        </div>
                    </div>

                    <div class="col s12 l6">
                        <div class="input-field col s12">
                            <label for="field-reference" class="form-label">Referência</label>
                            <input type="text" class="form-control" id="field-reference" name="reference" value="{{old('reference') ?? (isset($proposition) ? $proposition->reference : '')}}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-area" class="form-label">Área de Atendimento</label>
                            <input type="text" class="form-control" name="area" id="field-area" value="{{old('area') ?? (isset($proposition) ? $proposition->area : '')}}" />
                        </div>

                        <div class="input-field col s12">
                            <select name="state" value="{{old('state') ?? ''}}">
                            </select>
                            <label for="field-state">Estado</label>
                        </div>

                        <div class="input-field col s12">
                            <select name="city" value="{{old('city') ?? ''}}">
                            </select>
                            <label>Cidade</label>
                        </div>

                        <div class="input-field col s12">
                            <select name="situation" value="{{old('situation') ?? (isset($proposition) ? $proposition->situation : '')}}">
                                <option value="1">Aprovado</option>
                                <option value="2">Arquivado</option>
                                <option value="3">Em Trâmite</option>
                            </select>
                            <label>Situação da proposição</label>
                        </div>

                        <div class="input-field file-field col s12">
                            <div class="btn grey lighten-3 grey-text text-darken-2">
                                <span>Anexar</span>
                                <i class="material-icons right">cloud_upload</i>
                                <input type="file" name="document" />
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path" type="text" placeholder="Anexe o documento aqui" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-action">

                @isset($proposition)
                    <a href="/sie/list/proposition" class="btn-flat btn-large waves-effect waves-light">
                        Voltar para Proposições
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

    @if(isset($proposition))
        <script type="text/javascript">
            window.addEventListener('loadCitiesReady', function() {
                this.setStateCity('{{$proposition->state->id}}', '{{$proposition->city->id}}')
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
