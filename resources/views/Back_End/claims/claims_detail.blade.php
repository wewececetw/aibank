@extends('Back_End.layout.header')

@section('content')
    <style>
        #description p{
            margin: 0px
        }
        @media (max-width: 768px)
        {
            .conten img{
                height: unset !important;
                width: 95% !important;
            }
        }
    </style>

    <section id="main-content">
        <section class="wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">債權 {{$row->claim_number}}</h3>
                </div>
            </div>

            <div class="col-md-12">
                <div style="border:solid 1px #1a2732">
                    <div style="padding:10px;background-color:#394a59;">
                        <h4 style="color:white;">標單</h4>
                        <a class="last_page" href="/admin/claims">回上一頁</a>
                    </div>
                    <div class="panel-body">
                        @php
                            $check = DB::select("select a_l_l_seq from admin_lv_log where user_id ='".Auth::user()->user_id."' and a_l_l_seq = 2");  
                        @endphp
                        @if(!empty($check))
                        <?php if ($row->getOriginal('claim_state') ==0 || $row->getOriginal('claim_state') ==1 ): ?>
                        <div class="form-group">
                        <a href='{{url("/admin/claims_edit/$row->claim_id")}}' class="btn btn-info" name="" onClick="#" >編輯債權</a>
                        </div>
                        <?php endif; ?>
                        @endif

                        <div class='form-group'>
                            <div class="form_table_area">
                                <table class="table table-bordered">

                                    <thead>
                                        <tr>
                                            <th scope="row">物件編號</th>
                                            <td>{{$row->claim_number}}</td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <th scope="row">狀態</th>
                                            <td>{{$row->claim_state}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">統一編號</th>
                                            <td>{{$row->tax_id}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">對應流水號</th>
                                            <td>{{$row->serial_number}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">分期起始日</th>
                                            <td>{{$row->staged_at}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">分期總金額</th>
                                            <td>{{$row->staging_amount}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">原始期數</th>
                                            <td>{{$row->periods}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">剩餘期數</th>
                                            <td>{{$row->remaining_periods}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">年利率</th>
                                            <td>{{$row->annual_interest_rate}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">最低標額</th>
                                            <td>{{$row->min_amount}}</td>
                                        </tr>

                                        {{-- <tr>
                                            <th scope="row">得標總利息</th>
                                            <td>{{$row->bid_interest}}</td>
                                        </tr> --}}
                                        <tr>
                                            <th scope="row">管理費費率</th>
                                            <td>{{$row->management_fee_rate}}</td>
                                        </tr>

                                        {{-- <tr>
                                            <th scope="row">總管理費</th>
                                            <td>{{$row->management_fee_amount}}</td>
                                        </tr> --}}

                                        <tr id = 'description'>
                                            <th scope="row">債權說明</th>
                                            <td class="conten">
                                                @if(strtotime($row->created_at)<=strtotime('2020-11-13 12:30:00'))
                                                {!! nl2br($row->description) !!} 
                                                @else
                                                <?php echo($row->description); ?>
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th scope="row">約定買回方</th>
                                            <td>{!! nl2br($row->agreement_buyer) !!}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">上架日</th>
                                            <td>{{$row->launched_at}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">預計結標日</th>
                                            <td>{{$row->estimated_close_date}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">還款方式</th>
                                            <td>{{$row->repayment_method}}</td>
                                        </tr>

                                        <tr>

                                            <th scope="row">累標總額</th>
                                            <td>{{(isset($total_amount[0]->total_amount))?$total_amount[0]->total_amount:0}} 待確認</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">標售率</th>
                                            <td>{{$progress}}%</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">標單數</th>
                                            <td>{{ $tenderNum }}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">是否結標</th>
                                            <td>{{$endtender}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">結/流標日</th>
                                            <td>{{$row->closed_at}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">帳單繳款期限</th>
                                            <td>{{$row->payment_final_deadline}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">已收款</th>
                                            <td>{{$isPaidMoney['amount']}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">收款率</th>
                                            <td>{{$isPaidMoney['percent']}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">起息還款日</th>
                                            <td>{{$row->value_date}}</td>
                                        </tr>

                                        <tr>

                                            <th scope="row">流標投資款匯回日</th>
                                            <td>待定義</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">債權轉讓人</th>
                                            <td>{{$row->debtor_transferor}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">貸款人</th>
                                            <td>{{$row->borrower}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">身分證號</th>
                                            <td>{{$row->id_number}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">性別</th>
                                            <td>{{$row->gender}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">年齡</th>
                                            <td>{{$row->age}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">學歷</th>
                                            <td>{{$row->education}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">婚姻狀況</th>
                                            <td>{{$row->marital_state}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">居住地</th>
                                            <td>{{$row->place_of_residence}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">居住狀況</th>
                                            <td>{{$row->living_state}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">行業別</th>
                                            <td>{{$row->industry}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">職稱</th>
                                            <td>{{$row->job_title}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">年資</th>
                                            <td>{{$row->seniority}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">月薪</th>
                                            <td>{{$row->monthly_salary}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">連帶保證人</th>
                                            <td>{{$row->guarantor}}</td>
                                        </tr>

                                        <tr>

                                            <th scope="row">風險評級</th>
                                            <td>{{$row->risk_category}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">有效身分證</th>
                                            <td>{{$row->id_number_effective}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">同業黑名單</th>
                                            <td>{{$row->peer_blacklist}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">更生清算戶</th>
                                            <td>{{$row->rehabilitated_settlement}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">票信狀況</th>
                                            <td>{{$row->ticket_state}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">重大交通罰款</th>
                                            <td>{{$row->major_traffic_fines}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">一年內同業查詢次數</th>
                                            <td>{{$row->peer_query_count}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">報稅/不報稅</th>
                                            <td>{{$row->foreign}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">國內/海外</th>
                                            <td>{{$row->foreign_t}}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">週週排程日</th>
                                            <td>{{$row->weekly_time?$row->weekly_time:'非週週投債權'}}</td>
                                        </tr>


                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </section>
    </section>


@endsection
