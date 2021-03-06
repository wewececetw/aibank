@extends('Back_End.layout.header')

@section('content')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css">
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.zh-TW.min.js">
</script>

<script type="text/javascript" src="/js/daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/js/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="/js/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />


<style>
     td.details-control {
        background: url(https://twww.pponline.com.tw/images/details_open.png) no-repeat center center;
        cursor: pointer;
    }

     td.details-control-red {
        background: url(https://twww.pponline.com.tw/images/details_close.png) no-repeat center center;
        cursor: pointer;
    }

    td {
        word-break: break-all !important;
    }

    .c3-axis-y>.tick {
        fill: none; // removes axis labels from y axis
    }
    input {
        border: none;
    }

    .date_input {
        border: solid 1px #ddd;
        margin: auto 15px auto 5px;
    }

    .status_edit_inp {
        border: solid 1px #eee;
    }

    td {
        word-break: break-all !important;
    }

    .c3-axis-y>.tick {
        fill: none; // removes axis labels from y axis
    }
    .push_lightbox2 {
        padding: 30px;
        padding-top: 60px;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(51, 51, 51, 0.85);
        z-index: 9999;
        overflow-y: scroll;
    }
    /*??????div?????????????????????*/
    .page-icon{
		margin:20px 0 0 0;/*??????????????????20??????*/
		/* font-size:5;???????????????????????????????????? */
		text-align:center;/*????????????????????????*/
	}
    #background{
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        overflow: hidden;
        outline: 0;
        -webkit-overflow-scrolling: touch;
        background-color: rgb(0, 0, 0);  
        filter: alpha(opacity=60);  
        background-color: rgba(0, 0, 0, 0.6); 
        z-index: 9999;
    }
    .btn-info:hover , .btn-info:active , .btn-info:focus{
        background-color: #f00;
    }
</style>


<section id="main-content">
    <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">???????????????</h3>
            </div>
        </div>
        <div class="an-single-component with-shadow">
            <div class="">

                <br />


                <div class="an-component-header search_wrapper">

                    <div class="m-b-10" style="width: 100%; background-color: white; padding: 10px; border: 1px dotted">
                        <form class="form-inline">
                            <div class="form-group">
                                <a class="btn btn-info form-control" id="downloadBtn">?????????????????????</a>
                                <span style="margin-left: 50px;">???????????????????????????{{$claims_sum[0]->staging_amount ? $claims_sum[0]->staging_amount : '0'}}???</span>
                                <span style="margin-left: 25px;">????????????????????????{{$weekly_sum[0]->l_e_amount ? $weekly_sum[0]->l_e_amount : '0'}}???</span>
                                <span style="margin-left: 25px;">???????????????????????????{{$un_weekly_sum[0]->un_amount ? $un_weekly_sum[0]->un_amount : '0'}}???</span>
                                <span style="margin-left: 25px;">???????????????????????????{{$user_count_sum[0]->user_count ? $user_count_sum[0]->user_count : '0'}}???</span>
                            </div>
                        </form>
                    </div>

                    <div class="panel panel-default an-sidebar-search">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" href="#search_panel">????????????</a>
                            </h4>
                        </div>
                        <div id="search_panel" class="panel-collapse collapse" role="tabpanel"
                            aria-labelledby="headingTwo">
                            <div class="panel-body" id="target_panel">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label l-h-34">?????????</label>
                                    <div class="col-sm-4">
                                        <input type="hidden" id="now_page">
                                        <input type="hidden" id="count_page">
                                        <input type="hidden" id="sequence">
                                        <input type="text" name="user_name" id="user_name_search"
                                            placeholder="??????????????????"
                                            class="an-form-control no-redius border-bottom m-0 text_color filter-claim_number">
                                    </div>
                                    <label class="col-sm-2 control-label l-h-34">??????</label>
                                    <div class="col-sm-4">
                                            <select name="l_e_check" id="l_e_check_search"
                                                class="select required form-control select2 filter-state"
                                                include_blank="true" id="l_e_check">
                                                <option value="" style="color:lightgray">??????????????????</option>
                                                @foreach ($checkArray as $item => $val)
                                                <option value="{{$item}}">{{$val}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label l-h-34">????????????</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="member_number" id="member_number_search"
                                            placeholder="?????????????????????"
                                            class="an-form-control no-redius border-bottom m-0 text_color filter-claim_number">
                                    </div>
                                    <div class="clear"></div>
                                </div>    

                                <div class="form-group">
                                    <label class="col-sm-2 control-label l-h-34">????????????</label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5 no-padding">
                                            <div class="col-sm-12 no-padding">
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="l_e_time_start" id="l_e_time_start_search"
                                                    placeholder="????????????">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 no-padding l-h-34 t-center"> ~ </div>
                                        <div class="col-sm-6 no-padding">
                                            <div class="col-sm-12 no-padding">
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="l_e_time_end" id="l_e_time_end_search"
                                                    placeholder="????????????">
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label l-h-34">????????????</label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-5 no-padding">
                                            <div class="col-sm-12 no-padding">
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="l_e_updated_at_start" id="l_e_updated_at_start_search"
                                                    placeholder="????????????">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 no-padding l-h-34 t-center"> ~ </div>
                                        <div class="col-sm-6 no-padding">
                                            <div class="col-sm-12 no-padding">
                                                <input type="text" class="datepicker form-control datepicker_style"
                                                    name="l_e_updated_at_end" id="l_e_updated_at_end_search" placeholder="????????????">
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="form-group pull-right">
                                    <div class="col-sm-12">
                                        <button class="btn btn-default reset-button" id="reset">
                                            ??????
                                        </button>
                                        <button class="btn btn-info filter-button" id="submit">
                                            ??????
                                        </button>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clear">
                    </div>
                </div>
            </div>

            <div class="panel" style="margin-left: 20px;">
                <label>????????????</label>
                <select onchange="number_page_change()" name="number_page" id="number_page">
                    <option value="">?????????</option>
                    <option value="25">25</option>
                    <option value="100">100</option>
                </select>
                <label>???</label>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <button id="btn-show-all-children" type="button" class="btn btn-success">????????????</button>
                        <button id="btn-hide-all-children" type="button" class="btn btn-danger">????????????</button>
                        <table id="weekly_table" class="table table-striped table-advance table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th style="cursor: pointer" onclick="change_sort('u_n')" class="all">?????????</th>
                                    <th style="cursor: pointer" onclick="change_sort('m_n')" class="all">????????????</th>
                                    <th style="cursor: pointer" onclick="change_sort('l_e_a')" class="all">????????????</th>
                                    <th style="cursor: pointer" onclick="change_sort('a_a')" class="all">?????????????????????</th>
                                    <th style="cursor: pointer" onclick="change_sort('c')" class="all">??????????????????</th>
                                    <th class="all">??????????????????</th>
                                    <th style="cursor: pointer" onclick="change_sort('l_e_t')" class="all">????????????</th>
                                    <th style="cursor: pointer" onclick="change_sort('l_e_u_a')" class="all">????????????</th>
                                </tr>
                            </thead>
                            <tbody id='weekly_tbody'>
                                @foreach($weekly as $weeklys)
                                <tr>
                                    @if($weeklys->l_e_check == 2)
                                    <td id = "user_button{{$weeklys->l_e_id}}" onclick="show_user_detail({{$weeklys->l_e_id}})" class="details-control sorting_1"></td>
                                    
                                    @else
                                    <td></td>
                                    @endif
                                    <!-- ????????? -->
                                    <td>{{$weeklys->user_name}}</td>
                                    <!-- ???????????? -->
                                    <td>{{$weeklys->member_number}}</td>
                                    <!-- ???????????? -->
                                    <td>{{$weeklys->l_e_amount}}</td>
                                     <!-- ??????????????? -->
                                    <td>{{$weeklys->all_amount?$weeklys->all_amount:'0'}}</td>
                                    <!-- ???????????? -->
                                    <td>{{$weeklys->count_c_c}}</td>
                                    <!-- ?????????????????? -->
                                    <td>
                                        <span id="reason_word{{$weeklys->l_e_id}}" style="font-size: 14px">{{$checkArray[$weeklys->l_e_check]}}</span>
                                        @if($weeklys->l_e_check == 0)
                                        <button id="button_reject{{$weeklys->l_e_id}}" style="margin-left:5px;font-size: 12px;padding: 4px 10px;" class="btn btn-info"
                                            onclick="update_check_type({{$weeklys->l_e_id}},1)">?????????</button>
                                        <button id="button_agree{{$weeklys->l_e_id}}" style="margin-left:5px;font-size: 12px;padding: 4px 10px;" class="btn btn-info"
                                            onclick="update_check_type({{$weeklys->l_e_id}},2)">??????</button> 
                                        <button id="button_cancel{{$weeklys->l_e_id}}" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                            onclick="update_check_type({{$weeklys->l_e_id}},3)">??????</button>
                                        <button id="button_stop{{$weeklys->l_e_id}}" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                            onclick="update_check_type({{$weeklys->l_e_id}},4)">??????</button>       
                                        @elseif($weeklys->l_e_check == 2)  
                                        <button id="button_cancel{{$weeklys->l_e_id}}" style="margin-left:5px;font-size: 12px;padding: 4px 10px;" class="btn btn-info"
                                            onclick="update_check_type({{$weeklys->l_e_id}},3)">??????</button>  
                                        <button id="button_stop{{$weeklys->l_e_id}}" style="margin-left:5px;font-size: 12px;padding: 4px 10px;" class="btn btn-info"
                                            onclick="update_check_type({{$weeklys->l_e_id}},4)">??????</button>  
                                        <button id="button_reject{{$weeklys->l_e_id}}" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                            onclick="update_check_type({{$weeklys->l_e_id}},1)">?????????</button>
                                        <button id="button_agree{{$weeklys->l_e_id}}" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                            onclick="update_check_type({{$weeklys->l_e_id}},2)">??????</button> 
                                        @elseif($weeklys->l_e_check == 4)
                                        <button id="button_agree{{$weeklys->l_e_id}}" style="margin-left:5px;font-size: 12px;padding: 4px 10px;" class="btn btn-info"
                                            onclick="update_check_type({{$weeklys->l_e_id}},2)">??????</button> 
                                        <button id="button_cancel{{$weeklys->l_e_id}}" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                            onclick="update_check_type({{$weeklys->l_e_id}},3)">??????</button>  
                                        <button id="button_stop{{$weeklys->l_e_id}}" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                            onclick="update_check_type({{$weeklys->l_e_id}},4)">??????</button>  
                                        <button id="button_reject{{$weeklys->l_e_id}}" style="margin-left:5px;font-size: 12px;padding: 4px 10px;display:none;" class="btn btn-info"
                                            onclick="update_check_type({{$weeklys->l_e_id}},1)">?????????</button>
                                        @endif    
                                    </td>
                                    <!-- ???????????? -->
                                    <td>{{$weeklys->l_e_time}}</td>
                                    <!-- ???????????? -->
                                    <td>{{$weeklys->l_e_updated_at}}</td>
                                </tr>
                                <tr style="display: none" class ="c_weekly_detail" id = "weekly_detail{{$weeklys->l_e_id}}">
                                    <td colspan="7">
                                    <table  class="table table-bordered" cellpadding="10" cellspacing="0" border="0" style="padding-left:100px;">
                                        @if(!empty($weekly_detail[$weeklys->l_e_id]['claim_certificate_number']))
                                            @php
                                                $count = 1; 
                                                $table = '<tr>';          
                                            @endphp
                                            @foreach ($weekly_detail[$weeklys->l_e_id]['claim_certificate_number'] as $item)
                                                @php
                                                    
                                                    $table .= '<td>
                                                                ????????????:&nbsp;&nbsp;&nbsp;'.$item->claim_certificate_number.'
                                                                </td>
                                                            ';                
                                                    $count++;
                                                    if($count%7 == 0){
                                                        $table .= '</tr><tr>';
                                                    }           
                                                @endphp
                                            @endforeach
                                            @php
                                                $table .= '</tr>' ;
                                                echo $table;
                                            @endphp
                                        @endif
                                    </table>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
            <div class="page-icon">
                <ul class="pagination">
                </ul>                            
            </div>
            <div style="display: none;" id="background">
                <p style="margin-top:25%;margin-left:50%;color:white;font-size:25px">???????????????</p>
            </div>
    </section>
</section>


{{--
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> --}}

<script>

    function format(d) {
        let table =  `<tr style="display: none" class ="c_weekly_detail" id = "weekly_detail${d.id}">
            <td colspan="7">
            <table  class="table table-bordered" cellpadding="10" cellspacing="0" border="0" style="padding-left:100px;">`;
            if(d.claim_certificate_number){

                table += `<tr>`;
                    let y = 1 ;
                    $.each(d.claim_certificate_number,function(k,v){
                        table+= `<td>
                                ????????????:&nbsp;&nbsp;&nbsp;${v.claim_certificate_number}
                            </td>`;
                        y++;    
                        if(y%7 == 0){
                            table += `</tr><tr>`;
                        }   
                    })
                table += `</tr>`;
                            
            }
            table += `</table>
                                    </td>
                                </tr>` ;
            return table;    
    }

    //TR ?????????
    function trTemp(d){
            let t = `
            <tr>
                ${d.button}
                <td>${d.user_name}</td>
                <td>${d.member_number}</td>
                <td>${d.l_e_amount}</td>
                <td>${d.all_amount}</td>
                <td>${d.count}</td>
                <td>${d.button2}</td>
                <td>${d.l_e_time}</td>
                <td>${d.l_e_updated_at}</td>
            </tr>
            `;
            return t;
        }


    $(document).ready(function () {
        $(function () {
            $('.datepicker').datepicker({
                autoUpdateInput: false,
                format: "yyyy-mm-dd",
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 1901,
                maxYear: 3000,
                language: 'zh-TW',
            });
        });

        $('#btn-show-all-children').on('click', function () {

            $(".details-control").attr('class', 'details-control-red sorting_1');

            $(".c_weekly_detail").show();
        });


        $('#btn-hide-all-children').on('click', function () {

            $(".details-control-red").attr('class', 'details-control sorting_1');

            $(".c_weekly_detail").hide();
        });

        

         //????????????
        show_page();
        function show_page(){
            $("#now_page").val(1);
            $(".pagination").empty();
            let count = {{$page_count}};
            $("#count_page").val(count);
            let tmp = count_page(count);
            $(".pagination").append(tmp);
            $(".a_color").css("background-color","#fff");
            $("#a_color1").css("background-color","#EFF0ED");
        }
        //??????????????????
        function count_page(count){
            //????????????
            let now_page = parseInt($("#now_page").val());
            let t = `<li><a class="a_color-1" onclick = "back_page()" href="#">&laquo;?????????</a></li>
                                    <li onclick ="change_page(1)"><a class="a_color" id="a_color1" href="#">1</a></li>`;
            if(count>10){
                //????????????????????????4
                if(now_page<4){
                    for(let x=2 ; x <= 4; x++){
                        t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                    }
                    t+=`<li><a href="#">....</a></li>`;
                    for(let y=count-4 ; y <= count; y++){
                        t+=`<li onclick = "change_page(${y})"><a class="a_color" id="a_color${y}" href="#">`+y+`</a></li>`;
                    }
                }else if(now_page>=count-4){
                    t+=`<li><a href="#">....</a></li>`;
                    for( let x=count-5 ; x <= count; x++){
                        t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                    }
                }else{
                    let x1 = now_page-2;
                    let x2 = now_page+2;
                    t+=`<li><a href="#">....</a></li>`;
                    for( let x=x1 ; x <= x2; x++){
                        t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                    }
                    t+=`<li><a href="#">....</a></li>`;
                    
                    t+=`<li onclick = "change_page(${count})"><a href="#">`+count+`</a></li>`;
                    
                }
            }else if(count>=2){
                for(let x=2 ; x <= count; x++){
                    t+=`<li onclick = "change_page(${x})"><a href="#" class="a_color" id="a_color${x}" >`+x+`</a></li>`;
                }
            }                    
            
            t+=`<li><a class="a_color-2" onclick = "next_page()" href="#">?????????&raquo;</a></li>`;
            return t;
        }
        $("#downloadBtn").click(function () {
            let data = getFliterData();
            let url = "{{ url('/admin/weekly_audited/export/yes') }}" + "?" + $.param(data);
            window.location = url;
        })

        $("#submit").click(function () {
            $("#background").show();
            //??????????????????
            $("#now_page").val(1);
            let data = getFliterData();
            $.ajax({
                url: "{{ url('/admin/weekly_audited/search') }}",
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function (d) {
                    redrawTable(d.data);
                    //??????????????????
                    $("#now_page").val(1);
                    //????????????
                    $("#count_page").val(d.count);
                    //????????????
                    $(".pagination").empty();
                    let tmp = count_page(d.count);
                    $(".pagination").append(tmp);
                    $(".a_color").css("background-color","#fff");
                    $("#a_color1").css("background-color","#EFF0ED");
                    $("#background").hide();
                },
                error: function (e) {
                    console.log(e);
                }
            })
        });

        //??????Table
        function redrawTable(obj){
            $("#weekly_tbody").empty();
            let tmp = '';
            $.each(obj,function(k,v){
                tmp += trTemp(v)+format(v);
            })
            $("#weekly_tbody").append(tmp);
        }

        
    });

    function show_user_detail(c){

        var weekly_detail = document.getElementById('weekly_detail'+c);

        if (weekly_detail.style.display == 'none') {
            weekly_detail.style.display = '';
            $("#user_button"+c).attr('class', 'details-control-red sorting_1');
        } else {
            weekly_detail.style.display = 'none';
            $("#user_button"+c).attr('class', 'details-control sorting_1');
        }

    }   

    //?????????
    function back_page(){
        let now_page =  parseInt($("#now_page").val());
        if(now_page == 1){
            $(".a_color-1").css("background-color","#fff");
        }else{
            change_page(now_page-1);
        }
    }
    //?????????
    function next_page(){
        let now_page =  parseInt($("#now_page").val());
        let count_page = parseInt($("#count_page").val());
        if(now_page == count_page){
            $(".a_color-2").css("background-color","#fff");
        }else{
            change_page(now_page+1);
        }
    }

    
    //????????????
    function change_page(c){
        $("#background").show();
        $("#now_page").val(c);
        let data = getFliterData();
        $.ajax({
            url: "{{ url('/admin/weekly_audited/search') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (d) {
                redrawTable(d.data);
                //??????????????????
                $("#now_page").val("");
                $("#now_page").val(c);
                //??????????????????
                $("#count_page").val(d.count);
                //????????????
                $(".pagination").empty();
                let tmp = count_page2(d.count);
                $(".pagination").append(tmp);
                $(".a_color").css("background-color","#fff");
                $("#a_color"+c+"").css("background-color","#EFF0ED");
                $("#background").hide();
            },
            error: function (e) {
                console.log(e);
            }
        })
    };
     //??????Table
     function redrawTable(obj){
                $("#weekly_tbody").empty();
                let tmp = '';
                $.each(obj,function(k,v){
                    tmp += trTemp(v)+format(v);
                })
                $("#weekly_tbody").append(tmp);
    }

    //??????????????????
    function count_page2(count){
        //????????????
        let now_page = parseInt($("#now_page").val());
        let t = `<li><a class="a_color-1" onclick = "back_page()" href="#">&laquo;?????????</a></li>
                                <li onclick ="change_page(1)"><a class="a_color" id="a_color1" href="#">1</a></li>`;
        if(count>10){
            //????????????????????????4
            if(now_page<4){
                for(let x=2 ; x <= 4; x++){
                    t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                }
                t+=`<li><a href="#">....</a></li>`;
                for(let y=count-4 ; y <= count; y++){
                    t+=`<li onclick = "change_page(${y})"><a class="a_color" id="a_color${y}" href="#">`+y+`</a></li>`;
                }
            }else if(now_page>=count-4){
                t+=`<li><a href="#">....</a></li>`;
                for( let x=count-5 ; x <= count; x++){
                    t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                }
            }else{
                let x1 = now_page-2;
                let x2 = now_page+2;
                t+=`<li><a href="#">....</a></li>`;
                for( let x=x1 ; x <= x2; x++){
                    t+=`<li onclick = "change_page(${x})"><a class="a_color" id="a_color${x}" href="#">`+x+`</a></li>`;
                }
                t+=`<li><a href="#">....</a></li>`;
                
                t+=`<li onclick = "change_page(${count})"><a href="#">`+count+`</a></li>`;
                
            }
        }else if(count>=2){
            for(let x=2 ; x <= count; x++){
                t+=`<li onclick = "change_page(${x})"><a href="#" class="a_color" id="a_color${x}" >`+x+`</a></li>`;
            }
        }                    
        
        t+=`<li><a class="a_color-2" onclick = "next_page()" href="#">?????????&raquo;</a></li>`;
        return t;
    }

    //????????????
    function change_sort(th){
        let sequence = $("#sequence").val();
        $("#background").show();
        
        //??????????????????
        if(th == "u_n"){
            //??????????????????????????????
            if(sequence != 1 && sequence != -1){
                $("#sequence").val(1);

            }else if(sequence == 1){
                $("#sequence").val(-1);

            }else if(sequence == -1){
                $("#sequence").val(1);

            }   
        }else if(th == "l_e_a"){
            if(sequence != 2 && sequence != -2){
                $("#sequence").val(2);

            }else if(sequence == 2){
                $("#sequence").val(-2);

            }else if(sequence == -2){
                $("#sequence").val(2);

            }    
        }else if(th == "c"){
            if(sequence != 3 && sequence != -3){
                $("#sequence").val(3);

            }else if(sequence == 3){
                $("#sequence").val(-3);

            }else if(sequence == -3){
                $("#sequence").val(3);

            }   
        }else if(th == "l_e_t"){
            if(sequence != 4 && sequence != -4){
                $("#sequence").val(4);

            }else if(sequence == 4){
                $("#sequence").val(-4);

            }else if(sequence == -4){
                $("#sequence").val(4);

            }    
        }else if(th == "l_e_u_a"){
            if(sequence != 5 && sequence != -5){
                $("#sequence").val(5);

            }else if(sequence == 5){
                $("#sequence").val(-5);

            }else if(sequence == -5){
                $("#sequence").val(5);

            }   
        }else if(th == "a_a"){
            if(sequence != 6 && sequence != -6){
                $("#sequence").val(6);

            }else if(sequence == 6){
                $("#sequence").val(-6);

            }else if(sequence == -6){
                $("#sequence").val(6);

            }   
        }else if(th == "m_n"){
            if(sequence != 7 && sequence != -7){
                $("#sequence").val(7);

            }else if(sequence == 7){
                $("#sequence").val(-7);

            }else if(sequence == -7){
                $("#sequence").val(7);

            }   
        }

        let now_page = $("#now_page").val();
        let data = getFliterData();
        $.ajax({
            url: "{{ url('/admin/weekly_audited/search') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (d) {
                redrawTable(d.data);
                //??????????????????
                $("#count_page").val(d.count);
                //????????????
                $(".pagination").empty();
                let tmp = count_page2(d.count);
                $(".pagination").append(tmp);
                $(".a_color").css("background-color","#fff");
                $("#a_color"+now_page+"").css("background-color","#EFF0ED");
                $("#background").hide();
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    function number_page_change(){
        $("#background").show();
        let now_page = $("#now_page").val();
        let data = getFliterData();
        $.ajax({
            url: "{{ url('/admin/weekly_audited/search') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function (d) {
                redrawTable(d.data);
                //??????????????????
                $("#count_page").val(d.count);
                //????????????
                $(".pagination").empty();
                let tmp = count_page2(d.count);
                $(".pagination").append(tmp);
                $(".a_color").css("background-color","#fff");
                $("#a_color"+now_page+"").css("background-color","#EFF0ED");
                $("#background").hide();
                if($("#now_page").val() > $("#count_page").val()){$("#now_page").val(d.count);number_page_change()}
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
    //????????????
    function getFliterData() {
        let sequence = $("#sequence").val();
        let number_page = $("#number_page").val();
        if(number_page==''){ number_page = 25;}
        let now_page = $("#now_page").val();
        let user_name = $("#user_name_search").val();
        let l_e_check = $("#l_e_check_search").val();
        let l_e_time_start = $('#l_e_time_start_search').val();
        let l_e_time_end = $('#l_e_time_end_search').val();
        let l_e_updated_at_start = $('#l_e_updated_at_start_search').val();
        let l_e_updated_at_end = $('#l_e_updated_at_end_search').val();
        let member_number = $("#member_number_search").val();
        
        let data = {
            user_name:user_name,
            l_e_check:l_e_check,
            l_e_time_start:l_e_time_start,
            l_e_time_end:l_e_time_end,
            l_e_updated_at_start:l_e_updated_at_start,
            l_e_updated_at_end:l_e_updated_at_end,
            member_number:member_number,
            sequence:sequence,
            number_page:number_page,
            page:now_page
        }
        return data;
    }

    $(function () {
        $('#reset').click(function () {
            $("#user_name_search").val("");
            $("#l_e_check_search").val("");
            $('#l_e_time_start_search').val("");
            $('#l_e_time_end_search').val("");
            $('#l_e_updated_at_start_search').val("");
            $('#l_e_updated_at_end_search').val("");
        });
    });

    let array = {
        1:"?????????",
        2:"??????",
        3:"??????",
        4:"??????"
    };
    function update_check_type(target,l_e_check) {
        if (window.confirm('????????????????????????????')) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/admin/weekly_audited/update",
                dataType: "json",
                data: {
                    id: target,
                    l_e_check: l_e_check
                },
                success: function (data) {
                    if (data.success) {
                        alert("???????????????");
                        if(l_e_check == 1){
                            $("#button_reject"+target).hide();
                            $("#button_agree"+target).hide();
                            $("#button_cancel"+target).hide();
                            $("#button_stop"+target).hide();
                        }else if(l_e_check == 2){
                            $("#button_reject"+target).hide();
                            $("#button_agree"+target).hide();
                            $("#button_cancel"+target).show();
                            $("#button_stop"+target).show();
                        }else if(l_e_check == 3){
                            $("#button_cancel"+target).hide();
                            $("#button_stop"+target).hide();
                        }else if(l_e_check == 4){
                            $("#button_stop"+target).hide();
                            $("#button_cancel"+target).hide();
                            $("#button_agree"+target).show();
                        }
                        $("#reason_word"+target).html(array[l_e_check]);
                    }else{
                        alert("????????????????????????");
                    }
                }
            });
        }

    }

</script>
@endsection
