<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js">
    </script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />

    <title>傳簡訊</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <h3>傳送簡訊TEST</h3>
        </div>
        <div class="row">
            <div class="col align-self-center">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <form action="{{ url('test/sendPhoneMsg') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>簡訊號碼:</label>
                                <input type="text" name="dstaddr" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>簡訊內容:</label>
                                <input type="text" name="smbody" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>預約發送時間: (不選立即發送)</label>
                                <input type="text" class="form-control datetimepicker-input"  name="dlvtime" id="datetimepicker1" data-toggle="datetimepicker" data-target="#datetimepicker1"/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-success">發送</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'YYYYMMDDHHmmss'
            });
        });

    </script>
</body>

</html>
