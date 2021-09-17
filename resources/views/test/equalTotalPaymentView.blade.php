<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
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

    <title>本息攤還</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <h3>本息攤還</h3>
        <a href="{{ url('test/equalPrincipalPaymentView') }}" class="btn btn-outline-success">本金攤還試算</a>
        </div>
        <div class="row">
            <div class="col align-self-center">
                <div class="card">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <form id="myForm">
                            {{-- @csrf --}}
                            <div class="form-group">
                                <label>貸款金額:</label>
                                <input type="text" name="amount" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>貸款利率:</label>
                                <input type="text" name="rate" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>分期數(月):</label>
                                <input type="text" name="totalMonth" class="form-control">
                            </div>

                            <div class="form-group">
                                <a id="send" class="btn btn-outline-success">試算</a>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
        <div class="row">
            <div class="col align-self-center">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <th>期次</th>
                                <th>應攤還本金</th>
                                <th>應攤還利息</th>
                                <th>本息合計</th>
                                <th>貸款餘額</th>
                            </thead>
                            <tbody id="tbd">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#send").click(function () {
            let data = $("#myForm").serializeArray();

            $("#tbd").empty();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('test/equalTotalPayment') }}",
                data: data,
                type: 'POST',
                success: function (d) {
                    console.log(d);
                    let totalA = 0;
                    let totalB = 0;
                    let totalC = 0;
                    let totalD = 0;
                    let x = 0,
                        xlen = d.everyMonthPrincipal.length;
                    for (x; x < xlen; x++) {
                        let td = ``;
                        td += `
                            <td>${x}</td>
                            <td>${d.everyMonthPrincipal[x]}</td>
                            <td>${d.everyMonthInterest[x]}</td>
                            <td>${d.everyMonthPaidTotal[x]}</td>
                            <td>${d.everyMonthPrincipalBalance[x]}</td>
                        `
                        let tr = `<tr>${td}</tr>`
                        $("#tbd").append(tr);
                        totalA += d.everyMonthPrincipal[x];
                        totalB += d.everyMonthInterest[x];
                        totalC += d.everyMonthPaidTotal[x];
                        totalD += d.everyMonthPrincipalBalance[x];
                    }
                    let sumTd = `
                        <td>總和:</td>
                        <td><strong>${totalA}</strong></td>
                        <td><strong>${totalB}</strong></td>
                        <td><strong>${totalC}</strong></td>
                        <td><strong>${totalD}</strong></td>
                    `;
                    $("#tbd").append(`<tr>${sumTd}</tr>`);

                    // $("#tbd").a
                },
                error: function (e) {
                    console.log(e);

                }
            })
        })

    </script>

</body>

</html>
