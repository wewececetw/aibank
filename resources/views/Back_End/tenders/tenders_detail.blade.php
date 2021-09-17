@extends('Back_End.layout.header')

@section('content')

    <section id="main-content">
        <section class="wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">檢視標單</h3>
                </div>
            </div>

            <div class="col-md-12">
                <div style="border:solid 1px #1a2732">
                    <div style="padding:10px;background-color:#394a59;">
                        <h4 style="color:white;">標單</h4>
                        <a class="last_page" href="/admin/tender_documents">回上一頁</a>
                    </div>
                    <div class="panel-body">

                        <div class='form-group'>
                            <div class="form_table_area">
                                <table style="table-layout: fixed;" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>債權憑證號</th>
                                            <th>得標人編號</th>
                                            <th>得標序號</th>
                                            <th>物件編號</th>
                                            <th>標單金額</th>
                                            <th>狀態</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>{{$row->claim_certificate_number}}</td>
                                            <td>{{$row->tenders_user->member_number}}</td>
                                            <td>{{$row->order_number}}</td>
                                            <td>{{(isset($row->tenders_claim->claim_number))?$row->tenders_claim->claim_number:''}}</td>
                                            <td>{{$row->amount}}</td>
                                            <td>{{$row->tender_document_state}}</td>
                                        </tr>
                                    </tbody>

                                    <thead>
                                        <tr>
                                            <th>得標人</th>
                                            <th colspan="2">虛擬帳號</th>
                                            <th>原始期數</th>
                                            <th>年化利率</th>
                                            <th>還款方式</th>
                                            <th>標單購買日</th>
                                            <th>結/流日</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>{{$row->tenders_user->user_name}}</td>
                                            <td colspan="2">{{$row->tenders_user->virtual_account}}</td>
                                            <td>{{isset($row->tenders_claim->periods)?$row->tenders_claim->periods:''}}</td>
                                            <td>{{isset($row->tenders_claim->annual_interest_rate)?$row->tenders_claim->annual_interest_rate:''}}</td>
                                            <td>{{isset($row->tenders_claim->repayment_method)?$row->tenders_claim->repayment_method:''}}</td>
                                            <td>{{isset($row->created_at)?$row->created_at:''}}</td>
                                            <td>{{isset($row->tenders_claim->estimated_close_date)?$row->tenders_claim->estimated_close_date:''}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="form_table_Subscript_day">
                                <table style="table-layout: fixed;" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>投資人下標日</th>
                                            <th>繳款截止日</th>
                                            <th>債權實際結/流標日</th>
                                            <th>存入日期</th>
                                            <th>起息日</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>{{isset($row->created_at)?$row->created_at:''}}</td>
                                            <td>{{$row->should_paid_at}}</td>
                                            <td></td>
                                            <td>{{$row->paid_at}}</td>
                                            <td>{{isset($row->tenders_claim->value_date)?$row->tenders_claim->value_date:''}}</td>



                                            {{-- <td> {{$return_interest['already'][0]->return_interest}}</td>
                                            <td> {{$management_fee['total'][0]->management_fee}}</td>
                                            <td> {{$management_fee['already'][0]->management_fee}}</td>
                                            <td>{{$row->tenders_claim->debtor_transferor}}</td>
                                            <td> {{$income_amount['total'][0]->income_amount}}</td>
                                            <td> {{$income_amount['already'][0]->income_amount}}</td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>

                            <div class="form_table_Investment">
                                <table style="table-layout: fixed;" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>總應實現利潤</th>
                                            <th>總應付手續費</th>
                                            <th>總應實現淨利</th>
                                            <th>總應實現投資額</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td> {{(isset($return_interest['total'][0]->return_interest))?$return_interest['total'][0]->return_interest:0}}</td>    
                                            <td> {{(isset($management_fee['total'][0]->management_fee))?$management_fee['total'][0]->management_fee:0}}</td>
                                            <td> {{(isset($income_amount['total'][0]->income_amount))?$income_amount['total'][0]->income_amount:0}}</td>
                                            <td> {{(isset($return_principal['total'][0]->return_principal))?$return_principal['total'][0]->return_principal:0}}</td>
                                        </tr>
                                    </tbody>

                                    <thead>
                                        <tr>
                                            <th>總已實現利潤</th>
                                            <th>總已付手續費</th>
                                            <th>總已實現淨利</th>
                                            <th>總已實現投資額</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td> {{(isset($return_interest['already'][0]->return_interest))?$return_interest['already'][0]->return_interest:0}}</td>
                                            <td> {{(isset($management_fee['already'][0]->management_fee))?$management_fee['already'][0]->management_fee:0}}</td> 
                                            <td> {{(isset($income_amount['already'][0]->income_amount))?$income_amount['already'][0]->income_amount:0}}</td>      
                                            <td> {{(isset($return_principal['already'][0]->return_principal))?$return_principal['already'][0]->return_principal:0}}</td> 
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="form_table_Refund_date">
                                <table style="table-layout: fixed;" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>流標退款日期</th>
                                            <th>投資者提前贖回日</th>
                                            <th>轉讓人提前解約日</th>
                                            <th>債權轉讓人</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>{{isset($someDate->floating_return_at) ?$someDate->floating_return_at:'0'  }}</td>
                                            <td>{{isset($someDate->transferer_cancel_date) ?$someDate->transferer_cancel_date:'無'  }}</td>
                                            <td>{{isset($someDate->tender_withdraw_date) ?$someDate->tender_withdraw_date:'無'  }}</td>
                                            <td>{{isset($row->tenders_claim->debtor_transferor)?$row->tenders_claim->debtor_transferor:''}}</td>
                                        </tr>
                                    </tbody>

                                    <thead>
                                        <tr>
                                            <th>流標退款金額</th>
                                            <th>投資者提前贖回總金額</th>
                                            <th>轉讓人提前贖回總金額</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>{{ isset($someDate->amount) ? number_format($someDate->amount,2,'.',','):'0'  }}</td>   
                                            <td>{{ isset($someDate->tender_withdraw_amount) ?$someDate->tender_withdraw_amount:'0'  }}</td>   
                                            <td>{{ isset($someDate->trasferer_cancel_amount) ?$someDate->trasferer_cancel_amount:'0'  }}</td>  
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        <table class="table table-bordered table_breaking">
                            <thead>
                                <tr>
                                    <th colspan="5">投資應收明細</th>
                                    <th colspan="3">實際付款明細</th>
                                </tr>
                                <tr>
                                    <th>期數</th>
                                    <th>應返還日</th>
                                    <th>應收投資金額</th>
                                    <th>應收利潤</th>
                                    <th>應付手續費</th>
                                    <th>返還投資金額</th>
                                    <th>實際到帳日</th>
                                    <th>實際返還日</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($row->tenders_repayment as $data)
                                <tr>
                                    <td>{{$data->period_number}}</td>
                                    <td>{{$data->target_repayment_date}}</td>
                                    <td>{{$data->per_return_principal}}</td>
                                    <td>{{$data->per_return_interest}}</td>
                                    <td>{{$data->management_fee}}</td>
                                    <td>{{$data->real_return_amount}}</td>
                                    <td>{{(isset($data->paid_at))? $data->paid_at:''}}</td>
                                    <td>{{(isset($data->credited_at))? $data->credited_at : '' }}</td>

                                </tr>

                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </section>
    </section>


@endsection
