<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>繳款通知書</title>
    {{-- <link rel="stylesheet" href="scss/a.css"> --}}
    <style>
        *{
            font-family: 'simsun';
        }
        .wd-1 {
            width: 10%;
        }

        .wd-2 {
            width: 20%;
        }

        .wd-3 {
            width: 30%;
        }

        .wd-4 {
            width: 40%;
        }

        .wd-5 {
            width: 50%;
        }

        .wd-6 {
            width: 60%;
        }

        .wd-7 {
            width: 70%;
        }

        .wd-8 {
            width: 80%;
        }

        .wd-9 {
            width: 90%;
        }

        .wd-10 {
            width: 100%;
        }

        .center {
            text-align: center;
            font-family: 'simsun';
        }

        .container {
            font-family: 'simsun';
            /* font-weight: 600; */
            font-weight: bold;
            width: 100%;
        }

        .container .row {
            width: 90%;
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
        /*# sourceMappingURL=a.css.map */

    </style>
</head>

<body style="font-family: simsun;">
    <div class="container">
        <div class="row center">
            <h1><strong>信任豬股份有限公司</strong></h1>
        </div>
        <div class="row">
            <small>客服信箱:service@pponline.com.tw</small>
        </div>
        <div class="row">
            <small>
                客服專線:02-55629111
            </small>
        </div>
        <div class="row">
            <small>
                104 台北市中山區南京東路二段216號6樓
            </small>
        </div>
        <div class="row center">
            <h2><strong>繳款通知書</strong></h2>
        </div>
        <div class="row">
            <table class="table">
                <tr>
                    <td class="wd-4">
                        會員編號
                    </td>
                    <td>
                        {{ $user['member_number'] }}
                    </td>
                </tr>
                <tr>
                    <td class="wd-4">
                        會員姓名
                    </td>
                    <td>
                        {{ $user['user_name'] }}
                    </td>
                </tr>
                <tr>
                    <td class="wd-4">
                        結標時間
                    </td>
                    <td>
                        {{ date('Y-m-d',strtotime($user['estimated_close_date'])) }}
                    </td>
                </tr>
                <tr>
                    <td class="wd-4">
                        應繳總金額
                    </td>
                    <td>
                        {{ $totalAmount }}
                    </td>
                </tr>
                <tr>
                    <td class="wd-4">
                        繳款戶名
                    </td>
                    <td>
                        信任豬股份有限公司
                    </td>
                </tr>
                <tr>
                    <td class="wd-4">
                        繳款銀行(代碼)
                    </td>
                    <td>
                        {{-- {{ $user['bank_name'] }}({{ $user['bank_code'] }}) --}}
                        彰化銀行(009)
                    </td>
                </tr>
                <tr>
                    <td class="wd-4">
                        分行(代碼)
                    </td>
                    <td>
                        {{-- {{ $user['bank_branch_name'] }}({{ $user['bank_branch_code'] }}) --}}
                        中山北路分行(5081)
                    </td>
                </tr>
                <tr>
                    <td class="wd-4">
                        繳款帳號
                    </td>
                    <td>
                        {{ $user['virtual_account'] }}
                    </td>
                </tr>
                <tr>
                    <td class="wd-4">
                        購買債權
                    </td>
                    <td>
                        請參考債權明細表
                    </td>
                </tr>
                <tr>
                    <td class="wd-4">
                        繳款截止日
                    </td>
                    <td>
                        {{ date('Y-m-d 18:00',strtotime($tenders[0]['should_paid_at'])) }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="row center">
            <h2><strong>債權明細表</strong></h2>
        </div>
        <div class="row">
            <table class="table">
                <tr>
                    <td class="wd-7">
                        <strong>債權憑證號</strong>
                    </td>
                    <td>
                        購買金額
                    </td>
                </tr>
                    @foreach($tenders as $t)
                    <tr>
                        <td class="wd-7">
                            {{ $t['claim_certificate_number'] }}
                        </td>
                        <td>
                            {{ $t['amount'] }} 元
                        </td>
                    </tr>
                    @endforeach

            </table>
        </div>
    </div>
</body>

</html>
