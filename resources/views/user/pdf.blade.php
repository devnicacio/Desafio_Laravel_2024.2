@php
    $user = Auth::guard('web')->user()
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #006eff2f;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #006eff2f;
        }
        .month-title {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <p>Safebank</p>
    <p>Usuário: {{$user->name}}</p>
    <p>Data da emissão: {{$endDate->format('d/m/Y')}}</p>

    @php
        $groupedTransfers = $transfers->groupBy(function ($transfer) {
            return \Carbon\Carbon::parse($transfer->date)->format('Y-m');
        });
    @endphp

    @foreach ($groupedTransfers as $month => $transfers)
        @php
            $dateParts = explode('-', $month);
            $year = $dateParts[0];
            $monthNumber = $dateParts[1];
            $atualMonth = DateTime::createFromFormat('!m', $monthNumber);
            $monthName = strftime('%B', $atualMonth->getTimestamp());
        @endphp

        <div class="month-title">{{ucfirst($monthName)}}</div>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Remetente</th>
                    <th>Destinatário</th>
                    <th>Valor</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transfers as $transfer)
                    <tr>
                        <td>{{ $transfer->title }}</td>
                        <td>@if($transfer->senderAccount == null)
                            -
                        @else
                            {{$transfer->senderAccount}}
                        @endif</td>
                        <td>@if($transfer->recipientAccount == null)
                            -
                        @else
                            {{$transfer->recipientAccount}}
                        @endif</td>
                        <td>{{ "R$" . number_format($transfer->value, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($transfer->date)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>