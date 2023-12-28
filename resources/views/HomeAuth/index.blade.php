@extends('_Layouts/default')

<x-notification :error="$errors" />

@section('main')

    <style>
        .card-content {
            min-height: 450px;
        }

        .card h1 {
            font-size: 16px !important;
            font-weight: bold;
            color: #000;
            margin: 0 0 14px !important;
        }

        g[class$=creditgroup] {
            opacity: 0;
        }

        .empty-label {
            color: #0008;
            font-size: 13px;
        }
    </style>

    <div class="row">
        <div class="card animate__animated animate__fadeIn animate__faster col s12 m6 l6">
            <div class="card-content">
                <h1>Próximos compromissos</h1>

                @if(count($schedules) > 0)
                    <table>
                        <thead>
                            <tr>
                                <th>Compromisso</th>
                                <th>Local</th>
                                <th>Data / hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                                <tr>
                                    <td>{{$schedule->event}}</td>
                                    <td>{{$schedule->address}}</td>
                                    <td>{{$schedule->datetime.'h'}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="empty-label">Nenhum compromisso na sua agenda</p>
                @endif
            </div>
        </div>

        <div class="card animate__animated animate__fadeIn animate__faster col s12 m6 l6">
            <div class="card-content">

                {!! $barChart->container() !!}

            </div>
        </div>

        <div class="card animate__animated animate__fadeIn animate__faster col s12 m6 l6">
            <div class="card-content">

                {!! $lineChart->container() !!}

            </div>
        </div>

        <div class="card animate__animated animate__fadeIn animate__faster col s12 m6 l6">
            <div class="card-content">

                {!! $pieChart->container() !!}

            </div>
        </div>
    </div>

    {!! $barChart->script() !!}
    {!! $lineChart->script() !!}
    {!! $pieChart->script() !!}

@endsection
