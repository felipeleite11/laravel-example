@extends('_Layouts/default')

<x-notification :error="$errors" />

@section('main')

    <div class="card">
        <div class="card-content">

            <h4>Lista de Usuários</h4>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Login</th>
                        <th style="width: 34px"></th>
                        <th style="width: 34px"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->login}}</td>
                            <td class="delete">
                                <a href="/sie/users/destroy/{{$user->id}}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                            <td class="edit">
                                <a href="/sie/users/edit/{{$user->id}}">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection
