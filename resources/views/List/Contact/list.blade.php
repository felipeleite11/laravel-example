@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => null, 'title' => 'Contatos' ]
    ];
@endphp

<x-notification :error="$errors" />

@section('main')
    <style>
        .past .edit {
            opacity: 0.5;
        }
        .empty-placeholder {
            padding-top: 40px;
        }
        .hide {
            display: none;
        }
        #empty-text {
            text-align: center;
            display: none;
        }
        form button {
            width: 120px !important;
            margin: 16px 12px !important;
        }
    </style>

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card animate__animated animate__fadeIn animate__faster">
        <div class="card-content">

            <h1>Contatos</h1>

            <div class="row">
                <form action="/sie/contact/filter" method="GET">
                @csrf
                    <div class="row">
                        <div class="input-field col s12 m4 l4">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" id="name" />
                        </div>

                        <div class="input-field col s12 m4 l4">
                            <select name="month">
                                <option value="0">Selecione...</option>
                                <option value="1">Janeiro</option>
                                <option value="2">Fevereiro</option>
                                <option value="3">Março</option>
                                <option value="4">Abril</option>
                                <option value="5">Maio</option>
                                <option value="6">Junho</option>
                                <option value="7">Julho</option>
                                <option value="8">Agosto</option>
                                <option value="9">Setembro</option>
                                <option value="10">Outubro</option>
                                <option value="11">Novembro</option>
                                <option value="12">Dezembro</option>
                            </select>
                            <label>Mês</label>
                        </div>

                        <button type="submit" class="btn-small blue waves-effect waves-light col s12 m4 l4 hide-sm">Pesquisar</button>
                        <button type="submit" class="btn-small blue waves-effect waves-light col s12 m4 l4 right hide-on-med-and-up">Pesquisar</button>
                    </div>
                </form>
            </div>

            @if(count($contacts) > 0)
                <table class="table" id="contact-table">
                    <thead>
                        <tr>
                            <th scope="col">@sortablelink('name', 'Nome')</th>
                            <th scope="col">Email</th>
                            <th scope="col" class="hide-sm">Telefone</th>
                            <th scope="col">Celular</th>
                            <th scope="col" class="hide-sm hide-md">Celular alternativo</th>
                            <th scope="col" class="hide-sm hide-md">@sortablelink('birthdate', 'Data aniversário')</th>
                            <th scope="col" class="hide-sm hide-md">@sortablelink('cities.description', 'Município - UF')</th>
                            <th class="action"></th>
                            <th class="action"></th>
                            <th class="action"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($contacts as $contact)
                            <tr>
                                <td>{{$contact->name}}</td>
                                <td>{{$contact->email}}</td>
                                <td class="hide-sm">{{$contact->landline}}</td>
                                <td>{{$contact->phone}}</td>
                                <td class="hide-sm hide-md">{{$contact->phone_2}}</td>
                                <td class="hide-sm hide-md">{{$contact->birthdate}}</td>
                                <td class="hide-sm hide-md">{{$contact->city->description}} - {{$contact->state->initials}}</td>
                                <td class="action delete">
                                    <a href="/sie/destroy/contact/{{$contact->id}}" onclick="confirmation(event, this)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                                <td class="action edit">
                                    <a href="/sie/contact/edit/{{$contact->id}}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                                <td class="action detail">
                                    <a href="/sie/contact/{{$contact->id}}/show">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{$contacts
                    ->appends(request()->input())
                    ->links('components.pagination', [
                        'paginator' => $contacts
                    ])
                }}

                <p id="empty-text">Nenhum item encontrado</p>
            @else
                <p class="empty-placeholder">Nenhum contato agendado</p>

                <div class="center-align">
                    <a class="btn blue" href="/sie/store/contact">Cadastrar um contato</a>
                </div>
            @endif
        </div>
    </div>

    <script type="text/javascript">
        const nameField = $('#name')
        const emptyText = $('#empty-text')
        const table = document.querySelector('#contact-table')
        const tableBody = table.querySelector('tbody')

        nameField.on('keyup', e => {
            const rows = tableBody.querySelectorAll('tr')

            let resultLength = 0

            for(const row of rows) {
                const cells = row.querySelectorAll('td')

                const found = Array.from(cells).some(cell => cell.innerHTML.toLowerCase().search(nameField.val().toLowerCase()) >= 0)

                if(found) {
                    row.style.display = 'table-row'
                    resultLength++
                } else {
                    row.style.display = 'none'
                }
            }

            if(!resultLength) {
                table.style.display = 'none'
                emptyText.css('display', 'block')
            } else {
                table.style.display = 'table'
                emptyText.css('display', 'none')
            }
        })
    </script>

    <script>
        $(window).on('load', () => {
            $('label[for=field-start-date]').addClass('active')
            $('label[for=field-end-date]').addClass('active')
        })
    </script>

@endsection
