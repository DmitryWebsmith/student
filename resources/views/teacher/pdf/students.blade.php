<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table, th, td {
            font-size: 10px;
            overflow-x: auto;
            padding: 3px;
            border: 1px solid;
            border-collapse: collapse;
            border-color: #96D4D4;
            width: 100%;
            text-align: center;
        }

        body {
            font-family: DejaVu Sans
        }
    </style>

</head>

<body>
    <table>
        <thead>
        <tr>
            <th class="cell-sort">ФИО</th>
            <th class="cell-sort">Логин</th>
            <th class="cell-sort">Пароль</th>
        </tr>
        </thead>
        <tbody>
        @php
            $count = 0;
        @endphp
        @foreach($students as $student)
            @if ($count > 0)
                <tr>
                    @foreach($student as $column)
                        <td>{{ $column }}</td>
                    @endforeach
                </tr>
            @endif
            @php
                $count++;
            @endphp
        @endforeach
        </tbody>
    </table>
</body>

</html>
