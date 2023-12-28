<!DOCTYPE html>
<html>
<head>
    <title>Relatório</title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .date {
            font-size: 12px;
        }

        table {
            width: 100%;
            border-spacing: 0;
            border-collapse: separate;
        }

        table th,
        table td {
            border: solid 1px gray;
            padding: 3px;
            font-size: 10px;
        }

        table tfoot td {
            font-weight: 600;
        }

        table tfoot td.total {
            text-align: right;
        }
    </style>
</head>
<body>

    <h1>{{ $title }}</h1>

    <p class="date">{{ $date }}</p>

    <table>
        <thead>
            <tr>
                @foreach($headers as $item)
                    <th>{{$item}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    @foreach($item as $attr)
                        <td>{{$attr}}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="{{count($headers) - 1}}">Total</td>
                <td class="total">{{count($data)}}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
