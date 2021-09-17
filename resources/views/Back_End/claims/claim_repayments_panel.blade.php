@extends('Back_End.layout.header')

@section('content')


    <section id="main-content">
      <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">債權帳務列表</h3>
                </div>
            </div>


            <div class="an-single-component with-shadow">
                <a href="/admin/claim_repayments_insert" class="btn btn-info filter-button" style="margin: 10px 0px 0px 20px;">
                    新增債權帳務
                </a>
                <div class="an-component-header search_wrapper">
                    <div class="panel panel-default an-sidebar-search">
                        <div class="collapsed panel-heading"  data-toggle="collapse" href="#search_panel" style="cursor:pointer;">
                            <h4 class="panel-title">
                                篩選條件
                            </h4>
                        </div>
                        <div id="search_panel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <form class="form-group" id="insert_product_form">
                                    @csrf
                                    
                                    <div class="row">
                                        <div class='form-group'>
                                          <label class='col-sm-2 control-label l-h-34'>物件編號</label>
                                          <div class='col-sm-4'>
                                              <select name="loan_type" class="select optional form-control select2 filter-loan_type" include_blank="true" id="loan_loan_type">
                                                <option value=""></option>
                                                <option value="0">11111</option>
                                                <option value="1">111111</option>
                                                <option value="2">111111</option>
                                                <option value="3">111111</option>
                                              </select>
                                          </div>

                                          <label class='col-sm-2 control-label l-h-34'>狀態</label>
                                          <div class='col-sm-4'>
                                              <select name="loan_type" class="select optional form-control select2 filter-loan_type" include_blank="true" id="loan_loan_type">
                                                <option value=""></option>
                                                <option value="0">11111</option>
                                                <option value="1">111111</option>
                                                <option value="2">111111</option>
                                                <option value="3">111111</option>
                                              </select>
                                          </div>
                                          <div class="clear"></div>
                                        </div>
                                    </div>
                            
                                    <div class="row">
                                        <div class="form-group">
                                            <label class='col-sm-2 control-label l-h-34'>銀行帳號</label>
                                            <div class="col-sm-4">
                                                <input type='text' name='name' placeholder='請輸入銀行帳號' class='an-form-control no-redius border-bottom m-0 text_color filter-name'>
                                            </div>

                                            <label class='col-sm-2 control-label l-h-34'>銀行代碼</label>
                                            <div class="col-sm-4">
                                                <input type='text' name='name' placeholder='請輸入銀行代碼' class='an-form-control no-redius border-bottom m-0 text_color filter-name'>
                                            </div>
                                          <div class="clear"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class='form-group'>
                                          <label class='col-sm-2 control-label l-h-34'>備註</label>
                                            <div class='col-sm-10'>
                                                <div class='col-sm-5 no-padding'>
                                                    <div class='col-sm-12 no-padding'>
                                                        <input type='text' name='created_at_start' placeholder='請輸入備註' class='an-form-control no-redius border-bottom m-0 text_color datetimepicker filter-created_at'>
                                                    </div>
                                                </div>
                                            </div>
                                          <div class='clear'></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class='form-group'>
                                          <label class='col-sm-2 control-label l-h-34'>繳款時間</label>
                                          <div class='col-sm-10'>
                                                <div class='col-sm-5 no-padding'>
                                                    <div class='col-sm-12 no-padding'>
                                                        <input type="text" class="datepicker form-control datepicker_style" name="" id =""  placeholder="開始時間">
                                                    </div>
                                                </div>
                                                <div class='col-sm-1 no-padding l-h-34 t-center'> ~ </div>
                                                <div class='col-sm-6 no-padding'>
                                                    <div class='col-sm-12 no-padding'>
                                                        <input type="text" class="datepicker form-control datepicker_style" name="" id =""  placeholder="結束時間">
                                                    </div>
                                                </div>
                                          </div>
                                          <div class='clear'></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class='form-group'>
                                          <label class='col-sm-2 control-label l-h-34'>入帳日</label>
                                          <div class='col-sm-10'>
                                                <div class='col-sm-5 no-padding'>
                                                    <div class='col-sm-12 no-padding'>
                                                        <input type="text" class="datepicker form-control datepicker_style" name="" id =""  placeholder="開始時間">
                                                    </div>
                                                </div>
                                                <div class='col-sm-1 no-padding l-h-34 t-center'> ~ </div>
                                                <div class='col-sm-6 no-padding'>
                                                    <div class='col-sm-12 no-padding'>
                                                        <input type="text" class="datepicker form-control datepicker_style" name="" id =""  placeholder="結束時間">
                                                    </div>
                                                </div>
                                          </div>
                                          <div class='clear'></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class='form-group'>
                                          <label class='col-sm-2 control-label l-h-34'>還款金額</label>
                                          <div class='col-sm-10'>
                                                <div class='col-sm-5 no-padding'>
                                                    <div class='col-sm-12 no-padding'>
                                                        <input type='text' name='created_at_start' placeholder='請輸入開始數值' class='an-form-control no-redius border-bottom m-0 text_color datetimepicker filter-created_at'>
                                                    </div>
                                                </div>
                                                <div class='col-sm-1 no-padding l-h-34 t-center'> ~ </div>
                                                <div class='col-sm-6 no-padding'>
                                                    <div class='col-sm-12 no-padding'>
                                                        <input type='text' name='created_at_end' placeholder='請輸入結束數值' class='an-form-control no-redius border-bottom m-0 text_color datetimepicker filter-created_at'>
                                                    </div>
                                                </div>
                                          </div>
                                          <div class='clear'></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class='form-group'>
                                          <label class='col-sm-2 control-label l-h-34'>期數</label>
                                          <div class='col-sm-10'>
                                                <div class='col-sm-5 no-padding'>
                                                    <div class='col-sm-12 no-padding'>
                                                        <input type='text' name='created_at_start' placeholder='請輸入開始數值' class='an-form-control no-redius border-bottom m-0 text_color datetimepicker filter-created_at'>
                                                    </div>
                                                </div>
                                                <div class='col-sm-1 no-padding l-h-34 t-center'> ~ </div>
                                                <div class='col-sm-6 no-padding'>
                                                    <div class='col-sm-12 no-padding'>
                                                        <input type='text' name='created_at_end' placeholder='請輸入結束數值' class='an-form-control no-redius border-bottom m-0 text_color datetimepicker filter-created_at'>
                                                    </div>
                                                </div>
                                          </div>
                                          <div class='clear'></div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group pull-right">
                                          <div class="col-sm-12">
                                            <button class="btn btn-default reset-button">
                                              清空
                                            </button>
                                            <button class="btn btn-info filter-button">
                                              查詢
                                            </button>
                                          </div>
                                          <div class="clear"></div>
                                        </div>
                                    </div>
                                     
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <table id="customer" class="table table-striped table-advance table-hover">
                            <thead>
                                <tr>
                                    <th>物件編號</th>
                                    <th>物件狀態</th>
                                    <th>繳款時間</th>
                                    <th>行動電話</th>
                                    <th>還款金額</th>
                                    <th>備註</th>
                                    <th>狀態</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr>
                                    <td>q</td>
                                    <td>q</td>
                                    <td>q</td>
                                    <td>q</td>
                                    <td>100,000</td>
                                    <td>24</td>
                                    <td>q</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-info" href="#">內容</a>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <div class="paging"></div>

                    </section>
                </div>
            </div>
      </section>
    </section>

  </section>

<script type="text/javascript" src="/js/daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/js/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="/js/daterangepicker/daterangepicker.css"/>

<script>

     $(document).ready(function() {

        $(function() {
            $('.datepicker').daterangepicker({
            autoUpdateInput: false,
            locale: {
                    format: "YYYY-MM-DD" ,
                },
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: 3000,
            });

            $('.datepicker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD'));
            });
        });
    })

    

</script>





@endsection        