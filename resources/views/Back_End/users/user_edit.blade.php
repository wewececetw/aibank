@extends('Back_End.layout.header')

@section('content')

<style>
    input[type="file"] {
        color: transparent;
        position: absolute;
        width: 100%;
        z-index: 9999;
        left: 0px;
        margin: auto;
        top: 0;
        height: 100%;
        outline: none;
        color: transparent;
        display: block;
        cursor: pointer;
        opacity: 0;
    }

</style>

    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header">編輯使用者</h3>
          </div>
        </div>

        <div class="col-md-12">
            <div style="border:solid 1px #1a2732">
                <div style="padding:10px;background-color:#394a59;">
                    <h4 style="color:white;"> {{$row->user_name}} </h4>
                </div>
            <div class="panel-body">
                <form novalidate="novalidate" class="simple_form new_match_performance" id="update_user_form" enctype="multipart/form-data" action="/admin/match_performances" accept-charset="UTF-8" method="post"><input name="utf8" type="hidden" value="&#x2713;" />
                    @csrf
                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">會員編號</label>
                                <input type="text" class="form-control" name="user_id" value="{{$row->user_id}}" autocomplete="off" readonly>
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">Email</label>
                                <input type="text" class="form-control" name="email" value="{{$row->email}}" autocomplete="off">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">姓名</label>
                                <input type="text" class="form-control" name="user_name" value="{{$row->user_name}}" autocomplete="off">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">身分證字號</label>
                                <input type="text" class="form-control" name="id_card_number" value="{{$row->id_card_number}}" autocomplete="off">
                            </div>
                        </div>
                    
                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">護照號碼</label>
                                <input type="text" class="form-control" name="passport_number" value="{{$row->passport_number}}" >
                            </div>
                        </div>
                    

                        <div class="row m-b-15">

                            <div class='col-sm-3'>
                                <label for="exampleFormControlTextarea1">通訊地址</label>
                                <select data-type="contact" class="select optional select optional form-control  add_select" name="contact_country" id="contact_country">

                                </select>
                            </div>
                            <div class='col-sm-3'>
                                <label for="exampleFormControlTextarea1">&nbsp;</label>
                                
                                <select class="select optional select optional form-control" name="contact_district" id="contact_district">
                                <option value="0">請選擇</option>
                            </select>
                            </div>

                            <div class='col-sm-6'>
                                <input style="margin-top:23px" type="text" class="form-control" name="contact_address" placeholder="詳細地址" value="{{$row->contact_address}}">
                            </div>

                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-3'>
                                <label for="exampleFormControlTextarea1">戶籍地址</label>
                                <select data-type="residence"
                                    class="select optional select optional form-control add_select"
                                    name="residence_country" id="residence_country">
                                </select>
                            </div>
                            <div class='col-sm-3'>
                                <label for="exampleFormControlTextarea1">&nbsp;</label>
                                <select class="select optional select optional form-control" name="residence_district"
                                    id="residence_district" >
                                    <option value="0">請選擇</option>
                                </select>
                            </div>

                            <div class='col-sm-6'>
                                <input style="margin-top:23px" type="text" class="form-control" name="residence_address" placeholder="詳細地址" value="{{$row->residence_address}}">
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">出生日期</label>
                                <input type="text" class="datepicker form-control datepicker_style" name="birthday" value="{{$row->birthday}}"  autocomplete="off"  value="<?=date('Y/m/d')?>">
                            </div>

                            <div class='col-sm-6'>
                                <label for="exampleFormControlTextarea1">電話</label>
                                <input type="text" class="form-control" name="phone_number" autocomplete="off" value="{{$row->phone_number}}" >
                            </div>
                        </div>

                        <div class="row m-b-15">
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">身分證照片上傳(正面)</label>
                                
                                <div style="overflow:hidden;text-align: center;">

                                    <img class="image" id="preview-new-cert1" style="width:50%;" src="/users/font_img_r?g={{$row->user_id}}" alt=""  >

                                </div>

                                <div class="form-group file required user_id_back">
                                    <input class="m_t_2" name="id_front_file_name" data-type="cert1" onchange="readURL(this)" type="file" required>
            
                                </div>
                                <div class="btn btn-secondary" style="display: block; margin: auto;background-color:#394a59;color:#fff">點擊上傳</div>

                            </div>
                            
                            <div class="col-sm-6">
                                <label for="exampleFormControlTextarea1">身分證照片上傳(背面)</label>
                                
                                <div style="overflow:hidden;text-align: center;">

                                    <img class="image" id="preview-new-cert2" style="width:50%;" src="/users/back_img_r?g={{$row->user_id}}" alt=""  >

                                </div>

                                <div class="form-group file required user_id_back">
                                    <input class="m_t_2" name="id_back_file_name" data-type="cert2" onchange="readURL(this)" type="file" required>
                                
                                </div>
                                <div class="btn btn-secondary" style="display: block; margin: auto;background-color:#394a59;color:#fff">點擊上傳</div>

                            </div>
                            
                        </div>


                        <div class="row m-b-15">
                            <div class='col-sm-12'>
                                <label for="exampleFormControlTextarea1">備註</label>
                                <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3">{{$row->note}}</textarea>
                            </div>
                        </div>

                        <div class="col-sm-12" style="margin-top:40px;">
                            <a class="btn btn-info pull-right" href="/admin/users">返回</a>
                            <button type="button" onclick="update_item();" class="btn btn-info pull-right m-r-5">儲存</button>
                        </div>
                    
                </form>
            </div>
        </div>
    </div>

      </section>
    </section>


    <script type="text/javascript" src="/js/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="/js/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/js/daterangepicker/daterangepicker.css"/>

</section>

    <script>


    var datepicker_setting = {
        autoUpdateInput: false,
        singleDatePicker: true,
        opens: "center",
        drops: "up",
        locale: {
            format: "YYYY/MM/DD",
            applyLabel : "確定",
            cancelLabel : "取消",
            fromLabel : "開始日期",
            toLabel : "結束日期",
            customRangeLabel : "自訂日期區間",
            daysOfWeek : [ "日", "一", "二", "三", "四", "五", "六" ],
            monthNames : [ "1月", "2月", "3月", "4月", "5月", "6月",
            "7月", "8月", "9月", "10月", "11月", "12月" ],
            firstDay : 1,
        }
    };

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview-new-' + $(input).data('type')).attr('src', e.target.result);
                $('#preview-new-' + $(input).data('type')).show();
                $('#preview-new-' + $(input).data('type')).attr('hidden', false);
                $('#preview-' + $(input).data('type')).hide();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    $(document).ready(function(){
        $('.datepicker').daterangepicker(datepicker_setting);

        $('.datepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD'));
        });

        let districtList = {
            "請選擇": [],
            "臺北市": [],
            "新北市": [],
            "桃園市": [],
            "臺中市": [],
            "臺南市": [],
            "高雄市": [],
            "基隆市": [],
            "新竹市": [],
            "嘉義市": [],
            "新竹縣": [],
            "苗栗縣": [],
            "彰化縣": [],
            "南投縣": [],
            "雲林縣": [],
            "嘉義縣": [],
            "屏東縣": [],
            "宜蘭縣": [],
            "花蓮縣": [],
            "臺東縣": [],
            "澎湖縣": [],
            "金門縣": [],
            "連江縣": []
        }




        districtList["基隆市"].push("仁愛區");
        districtList["基隆市"].push("信義區");
        districtList["基隆市"].push("中正區");
        districtList["基隆市"].push("中山區");
        districtList["基隆市"].push("安樂區");
        districtList["基隆市"].push("暖暖區");
        districtList["基隆市"].push("七堵區");

        districtList["臺北市"].push("中正區");
        districtList["臺北市"].push("大同區");
        districtList["臺北市"].push("中山區");
        districtList["臺北市"].push("松山區");
        districtList["臺北市"].push("大安區");
        districtList["臺北市"].push("萬華區");
        districtList["臺北市"].push("信義區");
        districtList["臺北市"].push("士林區");
        districtList["臺北市"].push("北投區");
        districtList["臺北市"].push("內湖區");
        districtList["臺北市"].push("南港區");
        districtList["臺北市"].push("文山區");


        districtList["新北市"].push("萬里區");
        districtList["新北市"].push("金山區");
        districtList["新北市"].push("板橋區");
        districtList["新北市"].push("汐止區");
        districtList["新北市"].push("深坑區");
        districtList["新北市"].push("石碇區");
        districtList["新北市"].push("瑞芳區");
        districtList["新北市"].push("平溪區");
        districtList["新北市"].push("雙溪區");
        districtList["新北市"].push("貢寮區");
        districtList["新北市"].push("新店區");
        districtList["新北市"].push("坪林區");
        districtList["新北市"].push("烏來區");
        districtList["新北市"].push("永和區");
        districtList["新北市"].push("中和區");
        districtList["新北市"].push("土城區");
        districtList["新北市"].push("三峽區");
        districtList["新北市"].push("樹林區");
        districtList["新北市"].push("鶯歌區");
        districtList["新北市"].push("三重區");
        districtList["新北市"].push("新莊區");
        districtList["新北市"].push("泰山區");
        districtList["新北市"].push("林口區");
        districtList["新北市"].push("蘆洲區");
        districtList["新北市"].push("五股區");
        districtList["新北市"].push("八里區");
        districtList["新北市"].push("淡水區");
        districtList["新北市"].push("三芝區");
        districtList["新北市"].push("石門區");

        districtList["桃園市"].push("中壢區");
        districtList["桃園市"].push("平鎮區");
        districtList["桃園市"].push("龍潭區");
        districtList["桃園市"].push("楊梅區");
        districtList["桃園市"].push("新屋區");
        districtList["桃園市"].push("觀音區");
        districtList["桃園市"].push("桃園區");
        districtList["桃園市"].push("龜山區");
        districtList["桃園市"].push("八德區");
        districtList["桃園市"].push("大溪區");
        districtList["桃園市"].push("復興區");
        districtList["桃園市"].push("大園區");
        districtList["桃園市"].push("蘆竹區");

        districtList["新竹市"].push("東區");
        districtList["新竹市"].push("北區");
        districtList["新竹市"].push("香山區");

        districtList["新竹縣"].push("竹北市");
        districtList["新竹縣"].push("湖口鄉");
        districtList["新竹縣"].push("新豐鄉");
        districtList["新竹縣"].push("新埔鎮");
        districtList["新竹縣"].push("關西鎮");
        districtList["新竹縣"].push("芎林鄉");
        districtList["新竹縣"].push("寶山鄉");
        districtList["新竹縣"].push("竹東鎮");
        districtList["新竹縣"].push("五峰鄉");
        districtList["新竹縣"].push("橫山鄉");
        districtList["新竹縣"].push("尖石鄉");
        districtList["新竹縣"].push("北埔鄉");
        districtList["新竹縣"].push("峨眉鄉");

        districtList["苗栗縣"].push("竹南鎮");
        districtList["苗栗縣"].push("頭份市");
        districtList["苗栗縣"].push("三灣鄉");
        districtList["苗栗縣"].push("南庄鄉");
        districtList["苗栗縣"].push("獅潭鄉");
        districtList["苗栗縣"].push("後龍鎮");
        districtList["苗栗縣"].push("通霄鎮");
        districtList["苗栗縣"].push("苑裡鎮");
        districtList["苗栗縣"].push("苗栗市");
        districtList["苗栗縣"].push("造橋鄉");
        districtList["苗栗縣"].push("頭屋鄉");
        districtList["苗栗縣"].push("公館鄉");
        districtList["苗栗縣"].push("大湖鄉");
        districtList["苗栗縣"].push("泰安鄉");
        districtList["苗栗縣"].push("銅鑼鄉");
        districtList["苗栗縣"].push("三義鄉");
        districtList["苗栗縣"].push("西湖鄉");
        districtList["苗栗縣"].push("卓蘭鎮");

        districtList["臺中市"].push("中區");
        districtList["臺中市"].push("東區");
        districtList["臺中市"].push("南區");
        districtList["臺中市"].push("西區");
        districtList["臺中市"].push("北區");
        districtList["臺中市"].push("北屯區");
        districtList["臺中市"].push("西屯區");
        districtList["臺中市"].push("南屯區");
        districtList["臺中市"].push("太平區");
        districtList["臺中市"].push("大里區");
        districtList["臺中市"].push("霧峰區");
        districtList["臺中市"].push("烏日區");
        districtList["臺中市"].push("豐原區");
        districtList["臺中市"].push("后里區");
        districtList["臺中市"].push("石岡區");
        districtList["臺中市"].push("東勢區");
        districtList["臺中市"].push("和平區");
        districtList["臺中市"].push("新社區");
        districtList["臺中市"].push("潭子區");
        districtList["臺中市"].push("大雅區");
        districtList["臺中市"].push("神岡區");
        districtList["臺中市"].push("大肚區");
        districtList["臺中市"].push("沙鹿區");
        districtList["臺中市"].push("龍井區");
        districtList["臺中市"].push("梧棲區");
        districtList["臺中市"].push("清水區");
        districtList["臺中市"].push("大甲區");
        districtList["臺中市"].push("外埔區");
        districtList["臺中市"].push("大安區");

        districtList["彰化縣"].push("彰化市");
        districtList["彰化縣"].push("芬園鄉");
        districtList["彰化縣"].push("花壇鄉");
        districtList["彰化縣"].push("秀水鄉");
        districtList["彰化縣"].push("鹿港鎮");
        districtList["彰化縣"].push("福興鄉");
        districtList["彰化縣"].push("線西鄉");
        districtList["彰化縣"].push("和美鎮");
        districtList["彰化縣"].push("伸港鄉");
        districtList["彰化縣"].push("員林市");
        districtList["彰化縣"].push("社頭鄉");
        districtList["彰化縣"].push("永靖鄉");
        districtList["彰化縣"].push("埔心鄉");
        districtList["彰化縣"].push("溪湖鎮");
        districtList["彰化縣"].push("大村鄉");
        districtList["彰化縣"].push("埔鹽鄉");
        districtList["彰化縣"].push("田中鎮");
        districtList["彰化縣"].push("北斗鎮");
        districtList["彰化縣"].push("田尾鄉");
        districtList["彰化縣"].push("埤頭鄉");
        districtList["彰化縣"].push("溪州鄉");
        districtList["彰化縣"].push("竹塘鄉");
        districtList["彰化縣"].push("二林鎮");
        districtList["彰化縣"].push("大城鄉");
        districtList["彰化縣"].push("芳苑鄉");
        districtList["彰化縣"].push("二水鄉");

        districtList["南投縣"].push("南投市");
        districtList["南投縣"].push("中寮鄉");
        districtList["南投縣"].push("草屯鎮");
        districtList["南投縣"].push("國姓鄉");
        districtList["南投縣"].push("埔里鎮");
        districtList["南投縣"].push("仁愛鄉");
        districtList["南投縣"].push("名間鄉");
        districtList["南投縣"].push("集集鎮");
        districtList["南投縣"].push("水里鄉");
        districtList["南投縣"].push("魚池鄉");
        districtList["南投縣"].push("信義鄉");
        districtList["南投縣"].push("竹山鎮");
        districtList["南投縣"].push("鹿谷鄉");

        districtList["雲林縣"].push("斗南鎮");
        districtList["雲林縣"].push("大埤鄉");
        districtList["雲林縣"].push("虎尾鎮");
        districtList["雲林縣"].push("土庫鎮");
        districtList["雲林縣"].push("褒忠鄉");
        districtList["雲林縣"].push("東勢鄉");
        districtList["雲林縣"].push("臺西鄉");
        districtList["雲林縣"].push("崙背鄉");
        districtList["雲林縣"].push("麥寮鄉");
        districtList["雲林縣"].push("斗六市");
        districtList["雲林縣"].push("林內鄉");
        districtList["雲林縣"].push("古坑鄉");
        districtList["雲林縣"].push("莿桐鄉");
        districtList["雲林縣"].push("西螺鎮");
        districtList["雲林縣"].push("二崙鄉");
        districtList["雲林縣"].push("北港鎮");
        districtList["雲林縣"].push("水林鄉");
        districtList["雲林縣"].push("口湖鄉");
        districtList["雲林縣"].push("四湖鄉");
        districtList["雲林縣"].push("元長鄉");

        districtList["嘉義市"].push("東區");
        districtList["嘉義市"].push("西區");

        districtList["嘉義縣"].push("番路鄉");
        districtList["嘉義縣"].push("梅山鄉");
        districtList["嘉義縣"].push("竹崎鄉");
        districtList["嘉義縣"].push("阿里山鄉");
        districtList["嘉義縣"].push("中埔鄉");
        districtList["嘉義縣"].push("大埔鄉");
        districtList["嘉義縣"].push("水上鄉");
        districtList["嘉義縣"].push("鹿草鄉");
        districtList["嘉義縣"].push("太保市");
        districtList["嘉義縣"].push("朴子市");
        districtList["嘉義縣"].push("東石鄉");
        districtList["嘉義縣"].push("六腳鄉");
        districtList["嘉義縣"].push("新港鄉");
        districtList["嘉義縣"].push("民雄鄉");
        districtList["嘉義縣"].push("大林鎮");
        districtList["嘉義縣"].push("溪口鄉");
        districtList["嘉義縣"].push("義竹鄉");
        districtList["嘉義縣"].push("布袋鎮");

        districtList["臺南市"].push("中西區");
        districtList["臺南市"].push("東區");
        districtList["臺南市"].push("南區");
        districtList["臺南市"].push("北區");
        districtList["臺南市"].push("安平區");
        districtList["臺南市"].push("安南區");
        districtList["臺南市"].push("永康區");
        districtList["臺南市"].push("歸仁區");
        districtList["臺南市"].push("新化區");
        districtList["臺南市"].push("左鎮區");
        districtList["臺南市"].push("玉井區");
        districtList["臺南市"].push("楠西區");
        districtList["臺南市"].push("南化區");
        districtList["臺南市"].push("仁德區");
        districtList["臺南市"].push("關廟區");
        districtList["臺南市"].push("龍崎區");
        districtList["臺南市"].push("官田區");
        districtList["臺南市"].push("麻豆區");
        districtList["臺南市"].push("佳里區");
        districtList["臺南市"].push("西港區");
        districtList["臺南市"].push("七股區");
        districtList["臺南市"].push("將軍區");
        districtList["臺南市"].push("學甲區");
        districtList["臺南市"].push("北門區");
        districtList["臺南市"].push("新營區");
        districtList["臺南市"].push("後壁區");
        districtList["臺南市"].push("白河區");
        districtList["臺南市"].push("東山區");
        districtList["臺南市"].push("六甲區");
        districtList["臺南市"].push("下營區");
        districtList["臺南市"].push("柳營區");
        districtList["臺南市"].push("鹽水區");
        districtList["臺南市"].push("善化區");
        districtList["臺南市"].push("大內區");
        districtList["臺南市"].push("山上區");
        districtList["臺南市"].push("新市區");
        districtList["臺南市"].push("安定區");

        districtList["高雄市"].push("新興區");
        districtList["高雄市"].push("前金區");
        districtList["高雄市"].push("苓雅區");
        districtList["高雄市"].push("鹽埕區");
        districtList["高雄市"].push("鼓山區");
        districtList["高雄市"].push("旗津區");
        districtList["高雄市"].push("前鎮區");
        districtList["高雄市"].push("三民區");
        districtList["高雄市"].push("楠梓區");
        districtList["高雄市"].push("小港區");
        districtList["高雄市"].push("左營區");
        districtList["高雄市"].push("仁武區");
        districtList["高雄市"].push("大社區");
        districtList["高雄市"].push("東沙群島");
        districtList["高雄市"].push("南沙群島");
        districtList["高雄市"].push("岡山區");
        districtList["高雄市"].push("路竹區");
        districtList["高雄市"].push("阿蓮區");
        districtList["高雄市"].push("田寮區");
        districtList["高雄市"].push("燕巢區");
        districtList["高雄市"].push("橋頭區");
        districtList["高雄市"].push("梓官區");
        districtList["高雄市"].push("彌陀區");
        districtList["高雄市"].push("永安區");
        districtList["高雄市"].push("湖內區");
        districtList["高雄市"].push("鳳山區");
        districtList["高雄市"].push("大寮區");
        districtList["高雄市"].push("林園區");
        districtList["高雄市"].push("鳥松區");
        districtList["高雄市"].push("大樹區");
        districtList["高雄市"].push("旗山區");
        districtList["高雄市"].push("美濃區");


        var add_opt = '';

        $.each(districtList, function (k, v) {

            add_opt += "<option value='" + k + "'>" + k + "</option>";

        });

        $('#residence_country').html(add_opt);
        $('#contact_country').html(add_opt);



        $('.add_select').change(function () {

            var add = $(this).attr('data-type');

            var re_cou = $("#" + add + "_country").val();
            var cou_opt = '';

            $.each(districtList[re_cou], function (k, v) {

                cou_opt += "<option value='" + v + "'>" + v + "</option>";


            });

            $("#" + add + "_district").html(cou_opt);


        })



    });


    function update_item(){
        var form =document.getElementById("update_user_form");
        var formData = new FormData(form);
      $.ajax({
            type:"POST",
            url:"/admin/users_update/{{ $row->user_id }}",
            dataType:"json",
            data:formData,
            contentType:false,
            cache: false,
            processData:false,
            
            success:function(data){
                if(data.success){
                    alert("更新成功");
                    location.href='/admin/users';
                }else{
                    
                }
            }
        });
      

  }
  function getExtension(filename){
           var parts = filename.split('.');
           return parts[parts.length-1];
       }
       function isImg(filename){
           var ext =  getExtension(filename);
           switch(ext.toLowerCase()){
               case 'jpg':
               return true;
           }
           return false;
       }
       $(function() {
        $('#id_front_file_name, #id_back_file_name').on('change',function() {
            
            function failValidation(msg) {
            alert(msg); // just an alert for now but you can spice this up later
            return false;
            }

            var file = $('#id_front_file_name, #id_back_file_name');
            if (!isImg(file.val())) {
            return failValidation('您所選擇上傳的檔案格式有誤，請選擇JPG檔進行上傳');
            } 
            

           
            // alert('您所選擇上傳的檔案格式有誤，請選擇PDF檔進行上傳');
            // return false; 
        });

        });

  
                


        
    </script>
    


    @if(isset($row->residence_country))
    {{-- 當residence_country有資料 --}}
    <script>
        setTimeout(function(){
            
            var user_residence_country = '{{ $row->residence_country }}';
            var user_residence_district = '{{ $row->residence_district}}';
    
            var user_contact_country = '{{ $row->contact_country }}';
            var user_contact_district = '{{ $row->contact_district}}';
    
            $("#residence_country").val(user_residence_country).change();
            $("#residence_district").val(user_residence_district);
    
            $("#contact_country").val(user_contact_country).change();
            $("#contact_district").val(user_contact_district);
    
    
        },100);
    </script>
    @else
    
    @endif

@endsection             