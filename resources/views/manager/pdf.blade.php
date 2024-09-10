@php
    $manager = Auth::guard('manager')->user()
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>Safebank</p>
    <p>Usuário: {{$manager->name}}</p>
    <p>Data da emissão: {{$endDate->format('d/m/Y')}}</p>

    @php
        $atualMonth = $transfer->date->format('m');
        foreach ($transfers as $transfer) {
            $month = $transfer->date->format('m');
            
            if($month != $atualMonth)
                $atualMonth = $month;
        }
        $monthName = DateTime::createFromFormat('!m', $atualMonth->format('m'))->format('F');
    @endphp


    {{$monthName}}
</body>
</html>