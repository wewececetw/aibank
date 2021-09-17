<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>彰銀模擬POST</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</head>

<body>
    <h2>
        彰銀模擬POST 表單輸入
    </h2>
    {{-- <form id="f1" action="{{ url('test/bankSendEncrypt') }}" method="POST"> --}}
        <form id="f1" action="{{ url('/bankSendPlanText') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>INACCTNO</label>
            <input class="form-control" type="text" name="INACCTNO" value="123456789">
        </div>
        <div class="form-group">
            <label>AMT</label>
            <input class="form-control" type="text" name="AMT" value="900">
        </div>
        <div class="form-group">
            <label>ENTDATE</label>
            <input class="form-control" type="text" name="ENTDATE" value="20090210">
        </div>
        <div class="form-group">
            <label>TXDATE</label>
            <input  class="form-control" type="text" name="TXDATE" value="20090210">
        </div>
        <div class="form-group">
            <label>TXTIME</label>
            <input  class="form-control" type="text" name="TXTIME" value="103737">
        </div>
        <div class="form-group">
            <label>HCODE</label>
            <input  class="form-control" type="text" name="HCODE" value="0">
        </div>
        <div class="form-group">
            <label>SOURCE</label>
            <input  class="form-control" type="text" name="SOURCE" value="20">
        </div>
        {{-- INACCTNO<input type="text" name="INACCTNO" value="89489720110699"> --}}
        {{-- AMT<input type="text" name="AMT" value="900"> --}}
        {{-- ENTDATE<input type="text" name="ENTDATE" value="20090210"> --}}
        {{-- TXDATE<input type="text" name="TXDATE" value="20090210">
        TXTIME<input type="text" name="TXTIME" value="103737"> --}}
        {{-- HCODE<input type="text" name="HCODE" value="0"> --}}
        <button class="btn btn-outline-primary" type="submit">送出</button>
    </form>

</body>

</html>
