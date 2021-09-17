<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
    *{
        font-family: 'simsun';
    }
    .wd-4 {
        width: 40%;
    }
    .container {
        font-family: 'simsun';
        /* font-weight: 600; */
        font-weight: bold;
        width: 100%;
    }
    .container .row {
        width: 45%;
        margin-left: 5%;
        font-family: 'simsun';
    }

    .table {
        border: 2px black solid;
        width: 100%;
        border-collapse: collapse;
    }

    .table tr {
        width: 100%;
    }

    .table tr td {
        padding-left: 4px;
        border: 2px black solid;
        font-family: 'simsun';
    }
    td{
        font-family: 'simsun';
    }
    @media (max-width: 768px){
    .container .row {
        width: 90%;
        margin-left: 5%;
        font-family: 'simsun';
    }
    }
</style>
<body>
    @foreach ($ctx as $v)
        <p><?php echo $v ?></p>
    @endforeach
</body>
</html>
