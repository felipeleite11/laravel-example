@extends('_Layouts/default')

@php
    $breadcrumbs = [
        [ 'link' => null, 'title' => 'Consultas' ],
        [ 'link' => null, 'title' => 'Atendimentos' ]
    ];

    $modal = [
        'open' => false,
        'title' => '',
        'content' => []
    ];

    function resetModal() {
        $modal = [
            'open' => false,
            'title' => '',
            'content' => []
        ];
    }
@endphp

<x-notification :error="$errors" />

@section('main')

    <style>
        .empty-placeholder {
            padding-top: 80px;
        }

        #card-appointments {
            width: 86vw !important;
            margin-left: -8vw !important;
        }

        .buttons {
            margin-top: 16px;
        }

        @media(max-width: 992px) {
            #card-appointments {
                width: 86vw !important;
                margin-left: -1.5vw !important;
            }
        }

        @media(max-width: 600px) {
            #card-appointments {
                width: 86vw !important;
                margin-left: 0 !important;
            }
        }
    </style>

    <x-breadcrumb :pages="$breadcrumbs" />

    <div class="card animate__animated animate__fadeIn animate__faster" id="card-appointments">
        <div class="card-content">

            <h1>Atendimentos</h1>

            <form action="/sie/appointment/filter" method="GET" id="form">
            @csrf
                <div class="row">
                    <div class="input-field col s12 m6 l3">
                        <select name="state">
                        </select>
                        <label>Estado</label>
                    </div>

                    <div class="input-field col s12 m6 l3" disabled>
                        <select name="city">
                        </select>
                        <label>Município</label>
                    </div>

                    <div class="input-field col s12 m6 l3">
                        <label for="field-start-date" class="form-label">Data de início</label>
                        <input type="date" name="start_date" class="datepicker" id="field-start-date" />
                    </div>

                    <div class="input-field col s12 m6 l3">
                        <label for="field-end-date" class="form-label">Data de fim</label>
                        <input type="date" name="end_date" class="datepicker" id="field-end-date" />
                    </div>

                    <div class="input-field col s12 m6 l3">
                        <select name="type">
                            <option value="">Todos os tipos</option>
                            @foreach($types as $type)
                                <option value="{{$type->id}}">{{$type->description}}</option>
                            @endforeach
                        </select>
                        <label>Tipo</label>
                    </div>

                    <div class="input-field col s12 m6 l6">
                        <select name="administration">
                            <option value="">Todas as administrações</option>
                            @foreach($administrations as $administration)
                                <option value="{{$administration->id}}">{{$administration->description}}</option>
                            @endforeach
                        </select>
                        <label>Administração</label>
                    </div>

                    <div class="input-field col s12 m6 l3">
                        <select name="situation">
                            <option value="">Todas as situações</option>
                            @foreach($situations as $situation)
                                <option value="{{$situation->id}}">{{$situation->description}}</option>
                            @endforeach
                        </select>
                        <label>Solicitação</label>
                    </div>

                    <button
                        type="submit"
                        class="btn-small blue waves-effect waves-light right col s12 m4 l2"
                    >
                        Pesquisar
                    </button>

                    <button
                        type="button"
                        class="btn-small yellow black-text waves-effect waves-light right col s12 m4 l2"
                        onclick="handleGeneratePDF('appointment')"
                        style="margin-right: 12px"
                    >
                        Gerar PDF
                    </button>
                </div>
            </form>

            @if(count($appointments) > 0)

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="hide-md">Administração</th>
                            <th scope="col" class="hide-md">Tipo</th>
                            <th scope="col" class="hide-sm">
                                @sortablelink('cities.description', 'Município')
                            </th>
                            <th scope="col" class="hide-lg">
                                @sortablelink('date', 'Data da solicitação')
                            </th>
                            <th scope="col">
                                @sortablelink('name', 'Nome')
                            </th>
                            <th scope="col" class="hide-sm">Telefone</th>
                            <th scope="col">Situação</th>
                            <th scope="col" class="hide-lg">
                                @sortablelink('reference', 'Referência')
                            </th>
                            <th scope="col">
                                @sortablelink('responsible', 'Responsável')
                            </th>
                            <th class="action"></th>
                            <th class="action"></th>
                            <th class="action"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($appointments as $appointment)
                            @php
                                $isPast = $appointment->is_past;
                            @endphp

                            <tr class="{{$isPast ? 'past' : ''}}">
                                <td class="hide-md">{{$appointment->administration->description}}</td>
                                <td class="hide-md">{{$appointment->type->description}}</td>
                                <td class="hide-sm">{{$appointment->city->description}}</td>
                                <td class="hide-lg">{{$appointment->date}}</td>
                                <td>{{$appointment->name}}</td>
                                <td class="hide-sm">{{$appointment->phone}}</td>
                                <td>{{$appointment->situation->description}}</td>
                                <td class="hide-lg">{{$appointment->reference}}</td>
                                <td>{{$appointment->responsible}}</td>
                                <td class="action delete">
                                    <a href="/sie/destroy/appointment/{{$appointment->id}}" onclick="confirmation(event, this)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                                <td class="action edit">
                                    <a href="{{$isPast ? '#' : '/appointment/edit/'.$appointment->id}}" class="{{$isPast ? 'disabled' : ''}}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                                <td class="action detail">
                                    <a href="/sie/appointment/{{$appointment->id}}/show">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{$appointments
                    ->appends(request()->input())
                    ->links('components.pagination', [
                        'paginator' => $appointments
                    ])
                }}

            @else

                <p class="empty-placeholder">Nenhum atendimento agendado</p>

                <div class="center-align">
                    <a class="btn blue" href="/store/appointment">Cadastrar um atendimento</a>
                </div>

            @endif

        </div>
    </div>

    <script>
        setTimeout(() => {
            $('label[for=field-start-date]').addClass('active')
            $('label[for=field-end-date]').addClass('active')
        }, 200)

        const stateSelect = $('select[name=state]')
        const citySelect = $('select[name=city]')
        const startDateInput = $('input[name=start_date]')
        const endDateInput = $('input[name=end_date]')
        const typeSelect = $('input[name=type]')
        const administrationSelect = $('input[name=administration]')
        const situationSelect = $('input[name=situation]')

        if("{{isset($filters) ? $filters['state'] : ''}}" !== '') {
            startDateInput.val("{{$filters['start_date'] ?? ''}}")
            endDateInput.val("{{$filters['end_date'] ?? ''}}")
            stateSelect.val("{{$filters['state'] ?? ''}}")
            typeSelect.val("{{$filters['type'] ?? ''}}")
            administrationSelect.val("{{$filters['administration'] ?? ''}}")
            situationSelect.val("{{$filters['situation'] ?? ''}}")

            stateSelect.formSelect()
            typeSelect.formSelect()
            administrationSelect.formSelect()
            situationSelect.formSelect()

            setTimeout(() => {
                citySelect.val("{{isset($filters) ? $filters['city'] : ''}}")

                citySelect.formSelect()
            }, 1000)
        }
    </script>

@endsection

