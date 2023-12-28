@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Cadastros' ],
        [ 'link' => null, 'title' => 'Dados Municipais' ]
    ];
@endphp

<x-notification :error="$errors" />

@section('main')

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card col l12 animate__animated animate__fadeIn animate__faster">

        <form action="{{isset($prefecture) ? '/sie/prefecture/update/'.$prefecture->id : '/sie/store/prefecture'}}" method="POST">
        @csrf

            <div class="card-content">

                <h1>{{isset($prefecture->id) ? 'Editar' : 'Novo'}} Dados Municipais</h1>

                <div class="row">
                    <div class="col s12">
                        <div class="input-field col l3 m6 s12">
                            <label for="field-zipcode" class="form-label">CEP</label>
                            <input type="text" class="form-control" name="number" id="field-zipcode" value="{{old('zipcode') ?? (isset($prefecture) ? $prefecture->zipcode : '' ) }}" />
                        </div>

                        <div class="input-field col l3 m6 s12">
                            <select name="state" value="{{old('state') ?? ''}}">
                            </select>
                            <label for="field-state">Estado</label>
                        </div>

                        <div class="input-field col l3 m6 s12">
                            <select name="city" value="{{old('city') ?? ''}}">
                            </select>
                            <label>Cidade</label>
                        </div>

                        <div class="input-field col l3 m6 s12">
                            <label for="field-neighborhood" class="form-label">Bairro</label>
                            <input type="text" class="form-control" name="neighborhood" id="field-neighborhood" value="{{old('neighborhood') ?? (isset($prefecture) ? $prefecture->neighborhood : '')}}" />
                        </div>

                        <div class="input-field col l6 m6 s12">
                            <label for="field-address" class="form-label">Endereço</label>
                            <input type="text" class="form-control" name="address" id="field-address" value="{{old('address') ?? (isset($prefecture) ? $prefecture->address : '')}}" />
                        </div>

                        <div class="input-field col l3 m6 s12">
                            <label for="field-association" class="form-label">Associação</label>
                            <input type="text" class="form-control" name="association" id="field-association" value="{{old('association') ?? (isset($prefecture) ? $prefecture->association : '')}}" />
                        </div>

                        <div class="input-field col l3 m6 s12">
                            <label for="field-birthdate" class="form-label">Data de aniversário</label>
                            <input type="date" name="birthdate" class="datepicker" id="field-birthdate" required value="{{old('birthdate') ?? (isset($prefecture) ? $prefecture->birthdate_unix : '')}}" />
                        </div>

                        <div class="input-field col l3 m6 s12">
                            <label for="field-phone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" name="phone" id="field-phone" value="{{old('phone') ?? (isset($prefecture) ? $prefecture->phone : '')}}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-action">

                @isset($prefecture)
                    <a href="/sie/list/prefecture" class="btn-flat btn-large waves-effect waves-light">
                        Voltar para Dados Municipais
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
                this.setStateCity('{{$prefecture->state_id}}', '{{$prefecture->city_id}}')
            })
        </script>
    @endif

    <script type="text/javascript">
        const zipcodeField = $('#field-zipcode')
        const addressField = $('#field-address')
        const neighborhoodField = $('#field-neighborhood')
        const stateField = $('#field-state')
        const cityField = $('#field-city')

        zipcodeField.keyup(function(e) {
            const zipcode = zipcodeField.val().replace('-', '')

            if(zipcode.length === 8) {
                addressField.val('')
                neighborhoodField.val('')
                window.resetStateCity()

                window.getAddressByZipcode(zipcode)
            }
        })

        window.addEventListener('loadStateCityReady', function(e) {
            const { stateData, cityData } = e

            window.setStateCity(stateData.id, cityData.id)
        })

        window.addEventListener('loadAddressReady', function(e) {
            const {
                bairro: neighborhood,
                logradouro: address,
                uf: state,
                localidade: city
            } = e.addressData

            window.getStateCityData(state, city)

            neighborhoodField.val(neighborhood)
            addressField.val(address)
        }, false)
    </script>

    <script>
        $(window).on('load', () => {
            $('label[for=field-birthdate]').addClass('active')
        })
    </script>

@endsection
