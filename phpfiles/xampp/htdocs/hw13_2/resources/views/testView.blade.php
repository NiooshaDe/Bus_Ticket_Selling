<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table style="border: 1px solid black; width: 600px">
<tr>
    <th style="border: 1px solid black; width: 300px">file name</th>
    <th style="border: 1px solid black; width: 300px">file path</th>
</tr>

@foreach($results as $result)

    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; width: 300px">{{$result->name}}</td>
        <td style="border: 1px solid black; width: 300px"><img src="{{URL::asset($result->file_path)}}" height="50px" width="50px"></td>
    </tr>
@endforeach
</table>
</body>
</html>
