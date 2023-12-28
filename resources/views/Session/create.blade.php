@extends('_Layouts/default')

<x-notification :error="$errors" />

@section('main')
    <style>
        .card {
            height: 360px;
        }
    </style>

    <div class="row">
        <div class="card col s12 m8 offset-m2 l6 offset-l3">

            <form action="/sie/session" method="POST" class="mt-4">
            @csrf
                <div class="card-content">

                    <h4>Login</h4>

                    <div class="row">
                        <div class="col s12 input-field">
                            <label for="field-login" class="form-label">Login</label>
                            <input type="text" id="field-login" name="login" value="seusystem" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 input-field">
                            <label for="field-password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="field-password" name="password" value="seusystem" />
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn blue waves-effect waves-light">
                        Entrar
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
