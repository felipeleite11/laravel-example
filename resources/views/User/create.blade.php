@extends('_Layouts/default')

<x-notification :error="$errors" />

@section('main')

    <div class="row">
        <div class="card col l6 offset-l3">

            @if(isset($user))
                <form action="/sie/users/edit/{{$user->id}}" method="POST">
            @else
                <form action="/sie/users" method="POST">
            @endif

            @csrf

                <div class="card-content">

                    <h4>Cadastro de Usuários</h4>

                    <div class="row">
                        <div class="col s12 input-field">
                            <label for="field-name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="field-name" name="name" value="{{isset($user->name) ? $user->name : ''}}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 input-field">
                            <label for="field-login" class="form-label">Login</label>
                            <input type="text" class="form-control" id="field-login" name="login" value="{{isset($user->login) ? $user->login : ''}}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 input-field">
                            <label for="field-password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="field-password" name="password" value="{{isset($user->password) ? $user->password : ''}}" />
                        </div>
                    </div>

                </div>

                <div class="card-action">
                    <button type="submit" class="btn blue waves-effect waves-light">
                        {{isset($user) ? 'Salvar alterações' : 'Cadastrar'}}
                    </button>
                </div>

            </form>

        </div>
    </div>

@endsection
