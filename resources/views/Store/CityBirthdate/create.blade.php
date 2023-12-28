@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Cadastros' ],
        [ 'link' => null, 'title' => 'Aniversário de Municípios' ]
    ];
@endphp

<x-notification :error="$errors" />

@section('main')

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card animate__animated animate__fadeIn animate__faster">

        <form action="{{isset($prefecture) ? '/sie/city_birthdate/update/'.$prefecture->id : '/sie/store/city_birthdate'}}" method="POST">
        @csrf

            <div class="card-content" style="height: 360px">

                <h1>{{isset($prefecture->id) ? 'Editar' : 'Novo'}} Aniversário de Município</h1>

                <div class="row">
                    <div class="input-field col s12 l4">
                        <select name="state" value="{{old('state') ?? (isset($prefecture) ? $prefecture->state : '')}}">
                        </select>
                        <label for="field-state">Estado</label>
                    </div>

                    <div class="input-field col s12 l4" disabled>
                        <select name="city" value="{{old('city') ?? (isset($prefecture) ? $prefecture->city : '')}}" >
                        </select>
                        <label>Cidade</label>
                    </div>

                    <div class="input-field col s12 l4">
                        <label for="field-date" class="form-label">Data</label>
                        <input type="date" name="date" class="datepicker" id="field-date" value="{{old('birthdate') ?? (isset($prefecture) ? $prefecture->birthdate_unix : '')}}" />
                    </div>
                </div>
            </div>

            <div class="card-action">

                @isset($prefecture)
                    <a href="/sie/list/city_birthdate" class="btn-flat btn-large waves-effect waves-light">
                        Voltar para Aniversários de municípios
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

    @if(isset($prefecture))
        <script type="text/javascript">
            window.addEventListener('loadCitiesReady', function() {
                window.setStateCity('{{$prefecture->state->id}}', '{{$prefecture->city->id}}')
            })
        </script>
    @endif

    <script>
        $(window).on('load', () => {
            $('label[for=field-date]').addClass('active')
        })
    </script>

@endsection
