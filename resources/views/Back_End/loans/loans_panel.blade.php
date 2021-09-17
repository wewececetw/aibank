@extends('Back_End.layout.header')

@section('content')

<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<style>
    td {
        word-break: break-all !important;
    }
    .c3-axis-y > .tick{
fill: none;                // removes axis labels from y axis
}
</style>

    <section id="main-content">
      <section class="wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">貸款專區列表</h3>
                </div>
            </div>


            <div class="an-single-component with-shadow">
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
                                        <div class="form-group">
                                          <label class='col-sm-2 control-label l-h-34'>貸款人</label>
                                          <div class="col-sm-4">
                                            <input type='text' id="lender_name_search" name='name' placeholder='請輸入貸款人' class='an-form-control no-redius border-bottom m-0 text_color filter-name'>
                                          </div>
                                          <div class="clear"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group">
                                          <label class='col-sm-2 control-label l-h-34'>貸款人身分證</label>
                                          <div class="col-sm-4">
                                            <input type='text' id="lender_id_number_search" name='id_number' placeholder='請輸入貸款人身分證' class='an-form-control no-redius border-bottom m-0 text_color filter-id_number'>
                                          </div>
                                          <div class="clear"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class='form-group'>
                                          <label class='col-sm-2 control-label l-h-34'>貸款種類</label>
                                          <div class='col-sm-4'>
                                            <form novalidate="novalidate" class="simple_form new_loan" id="new_loan" action="/admin/loans" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" /><input type="hidden" name="authenticity_token" value="XIrVJQzCe58iBsrmbC7iSVsarqJpehCiA0VcSxSqCvZOqqPjE/9qvnKy/9uOvjTOD+m6RQ3LFqVLU+RiseFBOA==" />
                                              <select name="loan_type"  id="loan_type_search"class="select optional form-control select2 filter-loan_type" include_blank="true">
                                                <option value="" style="color:lightgray">選擇貸款種類</option>
                                                <option value="0">個人信用貸款</option>
                                                <option value="1">個人抵押貸(車貸)</option>
                                                <option value="2">商業貸</option>


                                              </select>
                                            </form>
                                          </div>
                                          <div class="clear"></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class='form-group'>
                                          <label class='col-sm-2 control-label l-h-34'>建立時間</label>
                                          <div class='col-sm-10'>
                                                <div class='col-sm-5 no-padding'>
                                                    <div class='col-sm-12 no-padding'>
                                                        <input type="text" class="datepicker form-control datepicker_style" name="created_at_start" id ="created_at_begin_search"  placeholder="開始時間">
                                                    </div>
                                                </div>
                                                <div class='col-sm-1 no-padding l-h-34 t-center'> ~ </div>
                                                <div class='col-sm-6 no-padding'>
                                                    <div class='col-sm-12 no-padding'>
                                                        <input type="text" class="datepicker form-control datepicker_style" name="created_at_end" id ="created_at_end_search"  placeholder="結束時間">
                                                    </div>
                                                </div>
                                          </div>
                                          <div class='clear'></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group pull-right">
                                          <div class="col-sm-12">
                                            <button class="btn btn-default reset-button" id="reset">
                                              清空
                                            </button>
                                            <button id="submit" class="btn btn-info filter-button">
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
                    {{-- <button class="btn btn-info filter-button">
                        匯出
                    </button> --}}
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <table id="customer_loan" class="table table-striped table-advance table-hover">
                            <thead>
                                <tr>

                                  <th style="width:130px"><i class="icon_profile"></i> 姓名</th>
                                    <th><i class="icon_calendar"></i> 出生年月日</th>
                                    <th><i class="icon_key"></i> 身分證字號</th>
                                    <th><i class="icon_mobile"></i> 行動電話</th>
                                    <th><i class="icon_star_alt"></i> 貸款種類</th>
                                    <th><i class="icon_cogs"></i> 金額</th>
                                    <th><i class="icon_cogs"></i> 期數</th>
                                    <th><i class="icon_cogs"></i> 已連繫</th>
                                    <th><i class="icon_cogs"></i> 備註</th>
                                    <th><i class="icon_cogs"></i> 操作</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($datasets as $dataset)
                              <tr>
                                <td>{{$dataset->lender_name}}</td>
                                <td>{{$dataset->dob}}</td>
                                <td>{{$dataset->lender_id_number}}</td>
                                <td>{{$dataset->cellphone_number}}</td>
                                <td>{{$dataset->loan_type}}</td>
                                <td>{{$dataset->amount}}</td>
                                <td>{{$dataset->periods}}</td>
                                <td>{{$dataset->connected}}</td>
                                <td>{{$dataset->comment}}</td>
                                <td>
                                  <div class="btn-group">
                                      <a class="btn btn-info" href="/admin/loans/loans_edit/{{$dataset->loan_id}}"><i class="fa fa-eye"></i></a>
                                      {{-- <button class="btn btn-danger" name="changeValue" onClick="#" ><i class="fa fa-trash-o"></i></button> --}}
                                  </div>
                              </td>

                              </tr>
                              @endforeach
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
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<script>


$(document).ready( function () {

  $(function() {
    $('.datepicker').daterangepicker({
      autoUpdateInput: false,
      locale: {
            format: "YYYY-MM-DD" ,
        },
      // autoUpdateInput: false,
      singleDatePicker: true,
      showDropdowns: true,
      minYear: 1901,
      maxYear: 3000,
    });

    $('.datepicker').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('YYYY-MM-DD'));
      });
});


    var table = $('#customer_loan').DataTable({
        sDom: 'lrtip',
        dom: 'Bfrtip',
        lengthChange: false,
        buttons: [
          { extend: 'excel', className: 'btn btn-info', text:'匯出' },
        ],
        iDisplayLength: 8,
        responsive: true,
        "autoWidth": false,
        searching: false,
        paging: true,
        info: false,
        order: [0, "asc"],
        "language": {
                      "emptyTable": "------無相關資料符合------"
                    }
    });

    // table.buttons().container()
    //     .insertBefore( '#customer_loan_filter' );
    $("#submit").click(function(){
          let lender_name = $("#lender_name_search").val();
          let lender_id_number = $("#lender_id_number_search").val();
          let loan_type = $("#loan_type_search").val();
          let created_at_begin = $('#created_at_begin_search').val();
          let created_at_end = $('#created_at_end_search').val();
          let data = {
            lender_name:lender_name,
            lender_id_number:lender_id_number,
            loan_type:loan_type,
            created_at_begin:created_at_begin,
            created_at_end: created_at_end,
          }
          $.ajax({
            url:"{{ url('/admin/loans/search') }}",
            type: 'post',
            headers:{
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:data,
            success: function(d){
              var table = $("#customer_loan").DataTable();
              table.clear().rows.add(d).draw();
            },
            error: function(e){
              console.log(e);
            }
          })
});


 });


$(function(){
    $('#reset').click(function(){
      $("#lender_name_search").val("");
      $("#lender_id_number_search").val("");
      $("#loan_type_search").val("");
      $('#created_at_begin_search').val("");
      $('#created_at_end_search').val("");
   });
 });

</script>

@endsection
