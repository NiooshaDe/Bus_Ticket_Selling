<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />--}}
</head>

<body>
<div class="container mt-5">
    <h2 class="text-center mb-3">Your Receipt</h2><br>


    <table class="table table-bordered mb-5">
        <thead>
        <tr class="table-danger">
            <th scope="col">name</th>
            <th scope="col">number</th>
            <th scope="col">total_price</th>
            <th scope="col">payment_status</th>
        </thead>
        <tbody>

        <tr>


            <td>{{$name}}</td>
            <td>{{$number}}</td>
            <td>{{$total_price}}</td>
            <td>successful</td>

        </tr>
        </tbody>
    </table>

</div>

{{--<script src="{{ asset('js/app.js') }}" type="text/js"></script>--}}
</body>

</html>
