@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Cadastros' ],
        [ 'link' => null, 'title' => 'Contatos' ]
    ];
@endphp

<x-notification :error="$errors" />

@section('main')

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card animate__animated animate__fadeIn animate__faster">

        <form action="{{isset($contact) ? '/sie/contact/update/'.$contact->id : '/sie/store/contact'}}" method="POST">
            @csrf

            <div class="card-content">

                <h1>{{isset($contact->id) ? 'Editar' : 'Novo'}} Contato</h1>

                <div class="row">
                    <div class="col s12 l4">
                        <div class="input-field col s12">
                            <label for="field-name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="field-name" name="name" value="{{old('name') ?? (isset($contact) ? $contact->name : '' ) }}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-nickname" class="form-label">Apelido/Lembrete</label>
                            <input type="text" class="form-control" id="field-nickname" name="nick" value="{{old('nick') ?? (isset($contact) ? $contact->nick : '' ) }}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-birthdate" class="form-label">Data de Nascimento</label>
                            <input type="date" class="datepicker birthdate" id="field-birthdate" name="birthdate" value="{{old('birthdate') ?? (isset($contact) ? $contact->birthdate_unix : '' ) }}" />
                        </div>

                        <div class="input-field col s12">
                            <select name="gender" value="{{old('gender') ?? (isset($contact) ? $contact->gender : '' ) }}">
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                                <option value="O">Outro</option>
                            </select>
                            <label>Selecione o Sexo</label>
                        </div>

                        <div class="input-field col s12">
                            <select name="type" value="{{old('type') ?? (isset($contact) ? $contact->type : '' ) }}">
                                <option value="1">Autoridade</option>
                                <option value="2">Assessor</option>
                                <option value="3">Agentes de Segurança Pública</option>
                                <option value="4">Capacitado-Gabinete Externo</option>
                                <option value="5">Deputado Estadual</option>
                                <option value="6">Deputado Federal</option>
                                <option value="7">Família/Amigo</option>
                                <option value="8">Liderança</option>
                                <option value="9">População</option>
                                <option value="10">Universal</option>
                            </select>
                            <label>Tipo de Cadastro</label>
                        </div>

                        <div class="input-field col s12">
                            <label for="field-job" class="form-label">Ocupação</label>
                            <input type="text" class="form-control" id="field-job" name="occupation" value="{{old('occupation') ?? (isset($contact) ? $contact->occupation : '' ) }}" />
                        </div>
                    </div>

                    <div class="col s12 l4">
                        <div class="input-field col s12">
                            <label for="field-cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="field-cep" name="cep" value="{{old('cep') ?? (isset($contact) ? $contact->cep : '' ) }}" />
                        </div>

                        <div class="input-field col s12">
                            <select name="state" value="{{old('state') ?? ''}}">
                            </select>
                            <label>Estado</label>
                        </div>

                        <div class="input-field col s12" disabled>
                            <select name="city" value="{{old('city') ?? ''}}">
                            </select>
                            <label>Cidade</label>
                        </div>

                        <div class="input-field col s12">
                            <label for="field-district" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="field-district" name="district" value="{{old('district') ?? (isset($contact) ? $contact->district : '' ) }}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-address" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="field-address" name="address" value="{{old('address') ?? (isset($contact) ? $contact->address : '' ) }}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-complement" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="field-complement" name="complement" value="{{old('complement') ?? (isset($contact) ? $contact->complement : '' ) }}" />
                        </div>
                    </div>

                    <div class="col s12 l4">
                        <div class="input-field col s12">
                            <label for="field-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="field-email" name="email" value="{{old('email') ?? (isset($contact) ? $contact->email : '' ) }}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-phone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="field-phone" name="landline" value="{{old('landline') ?? (isset($contact) ? $contact->landline : '' ) }}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-celular-1" class="form-label">Celular 1</label>
                            <input type="text" class="form-control" id="field-celular-1" name="phone" value="{{old('phone') ?? (isset($contact) ? $contact->phone : '' ) }}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-celular-2" class="form-label">Celular 2</label>
                            <input type="text" class="form-control" id="field-celular-2" name="phone_2" value="{{old('phone_2') ?? (isset($contact) ? $contact->phone_2 : '' ) }}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-observation" class="form-label">Observação</label>
                            <input type="text" class="form-control" id="field-observation" name="observation" value="{{old('observation') ?? (isset($contact) ? $contact->observation : '' ) }}" />
                        </div>

                        <div class="input-field col s12">
                            <label for="field-political-information" class="form-label">Informação Política</label>
                            <input type="text" class="form-control" id="field-political-information" name="political_info" value="{{old('political_info') ?? (isset($contact) ? $contact->political_info : '' ) }}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-action">

                @isset($contact)
                    <a href="/sie/list/contact" class="btn-flat btn-large waves-effect waves-light">
                        Voltar para Contatos
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
        $('input[name=landline]').mask('(00) 0000-0000')
        $('input[name=phone]').mask('(00) 00000-0000')
        $('input[name=phone_2]').mask('(00) 00000-0000')
        $('input[name=cep]').mask('00000-000')
    </script>

    @if(isset($contact))
        <script type="text/javascript">
            window.addEventListener('loadCitiesReady', function() {
                window.setStateCity('{{$contact->state->id}}', '{{$contact->city->id}}')
            })
        </script>
    @endif

    <script>
        $(window).on('load', () => {
            $('label[for=field-birthdate]').addClass('active')

            $('select').formSelect()
        })
    </script>

@endsection
