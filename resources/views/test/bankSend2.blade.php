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
        彰銀模擬POST密文內容
    </h2>
    <form id="f1" action="{{ url('test/bankSendDecrypt') }}" method="POST">
        @csrf
        {{-- result<input type="text" id="result"
          value="cXeK8t7zbNhWS3pukcFdidFG1vJAEeEHx7xPcVVzS6T5vhEQWrQE9t8LFz2OZXwkAkRmCvEG/DkJRpTzCLK+59W4KXQWX2KZGSm8fi2Z+8ozatC94xfsgg=="> --}}
        <div class="form-group">
            <label>加密後資料</label>
            {{-- <textarea class="form-control" type="text" name="result" value="{{$v}}" rows="10" cols="10" readonly>{{$v}}</textarea> --}}
            <input class="form-control" id="result" type="text" value="{{$v}}" name="result">
        </div>

        <button class="btn btn-outline-primary" type="submit">送出解密</button>
    </form>

</body>

</html>
