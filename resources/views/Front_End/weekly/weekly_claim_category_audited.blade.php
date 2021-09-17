@extends('Front_End.layout.header')

@section('content')

<div id="main-page">
    <link rel="stylesheet" media="screen" href="/table/css/table.css" />
    <link rel="stylesheet" media="screen" href="/css/list.css" />
    <link rel="stylesheet" media="screen" href="/css/list_modal.css" />
    <link rel="stylesheet" media="screen" href="/css/modal.css" />
    <link rel="stylesheet" media="screen" href="/css/member.css?v=20191016" />
    <link rel="stylesheet" media="screen" href="/css/member2.css?v=20181027" />
    <link rel="stylesheet" media="screen" href="/css/cumstom_style.css" />
    <link rel="stylesheet" media="screen" href="/css/tender.css" />
    <link rel="stylesheet" media="screen" href="/css/sliderbar.css" />
    <link rel="stylesheet" media="screen" href="/css/claim.css" />
    <link rel="stylesheet" media="screen"
        href="/assets/front/match-ab00adde9a2208fa12a33b86a261b34d9ea621b0ceed421ed9fd13204e088bb4.css" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        .hideloading {
            display: none;
        }

        #submitBtn {
            display: none;
        }
        #larbar_type1,#larbar_type2,#larbar_type3,#larbar_type4,#larbar_type5{
            display: none;
        }
        #labarchange{
            width: 135%;
        }
        .member_banner{
            width: 100%;
            min-height: 450px;
            background-image: url(../images/member_banner.jpg);
            background-size: cover;
        }
        .btn_padding{
            padding: 0;
            float: left;
        }
        .btn_width{
            width: 70% !important;
        }
        @media screen and (max-width: 1024px){
            #labarchange{
                width: 100%;
            }
        }
        @media screen and (max-width: 768px){
            #word15{
                bottom: 15px;
                position: absolute;
                display: inline-block;
                padding-left: 101px;
            }
            #input_amount{
                width: 111px;
                margin-left: 30px;
            }
            .btn_padding{
                margin-top: 5px;
                float: none;
            }
            .btn_width{
                width: 80% !important;
            }
        }
        @media screen and (max-width: 576px){
            .btn_padding{
                padding-left: 15px;
            }
        }
        @media screen and (max-width: 568px){
            #word15{
                padding-left: 11px;
            }
        }@media screen and (max-width: 480px){
            #word15{
                padding-left: 101px;
            }
        }
    </style>



    <div class="container-fluid none" id="loadingBlock">
        <div class="row" style="margin-top:15%">
            <div class="col-md-12  text-center">
                <div class="loader">
                    <div class="loader-inner box1"></div>
                    <div class="loader-inner box2"></div>
                    <div class="loader-inner box3"></div>
                    <div class="loader-inner box4"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="loadingText">豬豬在線努力中</h1>
                <h2 class="loadingText" id="loadText">
                    Loading ...
                </h2>
            </div>
        </div>
    </div>

    <div class="member_banner">
        <div class="container">
            <div class="row">
                <div class="banner_content">

                </div>
            </div>
        </div>
    </div>

    <div class="push_lightbox" id="clause" style="display: none">
        <div class="contract_info">
            <h2 style="margin-bottom:20px;">週週投約定條款</h2>
            <button class="close" type="button" >關閉視窗</button>
            <button class="close_phone" type="button" >x</button>
            <p>
            <strong>一、	成為週週投會員資格</strong><br>
            <ul>
                <li>
                    1.	使用週週投功能前，您必須先完成基本帳戶註冊，包含約定匯款銀行帳戶設定，取得債權購買資格。
                </li>
                <li>
                    2.	需瞭解並同意本約定條款，始可使用週週投功能。
                </li>
                <li>
                    3.	本公司有權篩選週週投會員並保有最終核准權利，未經核准或列為警示戶客戶，無法成為週週投會員。
                </li>    
            </ul>        
            </p>
            <p>
            <strong>二、	使用週週投功能</strong><br/>
            <ul>
                <li>
                    1.	當您成為週週投會員，您可至豬豬在線開啟並設定週週投功能，授權系統每週僅依照您設定的金額為上限，自動以隨機及分散方式(每筆債權以新台幣1000元為基礎)，為您進行債權認購。
                </li>
                <li>    
                    2.	週週投功能僅限於國內商品分期及小額貸款之債權，回款方式為本息平均攤還至您約定的個人帳戶。
                </li>
                <li>
                    3.	週週投之設定，每週最低認購金額為伍千，最高限額參萬元；為達公平，期數、債權項目及報酬率等亦以隨機方式進行媒合，若要認購特定期數、債權項目及報酬率等，請改以智能媒合進行標購。
                </li>
                <li>
                    4.	週週投認購成功後，系統於每週結標時，會同步寄發E-mail及簡訊通知您，請您於期限內自行轉帳繳費。
                </li>
                <li>
                    5.	如果您透過週週投購買債權，最後因故未完成繳費，豬豬在線有權將您列入警示帳號，並關閉週週投功能，即若有違反逾期繳費或取消購買之規定，您將暫時不得購買債權。
                </li>
                <li>
                    6.	有搭配週週投功能之債權，皆會於債權項目上標註，並於簡介內說明。
                </li>
                <li>
                    7.	有搭配週週投債權會依登記週週投會員順序，依序自動媒合，如當週有搭配週週投債權金額小於週週投會員總登記金額時，您有可能因登記順序，無法透過週週投功能認購債權。
                </li>
                <li>
                    8.	您隨時可以修改您週週投的設定，包含但不限於金額修改及功能開啟或關閉等，惟當你進行修改週週投設定後，您的投資順位亦將會有所變化，順位將因此後挪。
                </li>
                <li>
                    9.	若您修改週週投設定為債權上架當日或前一日，有可能當週無法依您變更設定而仍使用原設定，如當週有未依您變更設定狀況發生，請隨時聯絡豬豬在線服務人員為您再次確認。
                </li>
            </p>
            <p>
            <strong>三、	約定及說明</strong><br>
            <ul>
                <li>
                    1.	豬豬在線對週週投約定條款擁有最終解釋與修改權利，另本週週投約定條款自您申請時即生效，而在豬豬在線核准通過後，豬豬在線與您都受有本條款之約束及權利。
                </li>
                <li>
                    2.	豬豬在線有權隨時終止本方案；或日後若有新的條款經豬豬在線通知您者，本方案亦自動失效。
                </li>
            </ul>
            </p>
        </div>
    </div>

    @component('Front_End.user_manage.account.mobileSelect')
    @endcomponent


    <div class="container" style="min-height: 500px">
        <div class="row">
            <div class="member_title col-sm-12"> <span class="f28m">週週投 投資設定</span></div>
            <form style="width: 100%" id="change_password_form">
                <div class="form-horizontal">

                    <div class="col-12 col-padding" style="border: 0px">
                        <div class="col-md-4 col-12 match-col-style"><span class="f20"><img src="/images/cl1.png" alt=""
                                    class="pr5"> 輸入欲投資金額</span> </div>
                        <div class="col-md-8 col-12 match-col-style">
                            <div class="form-group">
                                <div class="modal-col-1">
                                    <input id="input_amount" type="number" class="input_style form-control" min="5000" step="1000"
                                        value="{{$weekly[0]->l_e_amount}}" max="30000" pattern="[\d]{9}" placeholder="請填入整數" />
                                </div>
                            </div>
                            <div class="pf15" id = "word15"><span class="pf15"
                                style="font-size: 20px; color: #00c1de;">元整</span> (以千元為單位)</div>
                        </div>
                    </div>
                    <div class="clear"></div>

                    <div class="m-b-10" style="padding:10px;width:100%">
                        
                        <input type="checkbox" id="isRead" class="check_all_agreement" checked>
                        <span>已閱讀並同意</span><span style="color: red;cursor: pointer;" id="clause_button">「週週投約定條款」</span>
                        
                    </div>
                    <div class="clear"></div>
                    <div class="form-group " style="padding-top: 30px; padding-bottom: 30px;">
                        <div class="col-md-3 col-6 btn_padding" >
                            <input onclick='edit_password_btn(2)' class="btn btn-block btn_width btn-info " type="button"
                                value="修改設定">
                        </div>        
                            
                        <div class="col-md-3 col-6 btn_padding" >
                            <input onclick='edit_password_btn(1)' class="btn btn-block btn_width btn-danger" type="button"
                                value="終止週週投">
                        </div>
                        @if($weekly[0]->l_e_check == 2)
                        <div class="col-md-3 col-6 btn_padding" >
                            <input onclick='edit_password_btn(4)' class="btn btn-block btn_width btn-secondary" type="button"
                                value="暫停週週投">
                        </div>
                        @elseif($weekly[0]->l_e_check == 4)
                        <div class="col-md-3 col-6 btn_padding" >
                            <input onclick='edit_password_btn(3)' class="btn btn-block btn_width btn-warning" type="button"
                                value="恢復週週投">
                        </div>
                        @endif
                        <div class="clear"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>


</body>

</html>
<script>
    $(document).ready(function(){
        $('#clause_button').click(function() {
            $('#clause').show();
            $('#isRead').prop('checked', true);
        }); 
        $(".close").click(function(){
            $('#clause').hide();
        });
        $(".close_phone").click(function(){
            $('#clause').hide();
        });
    });

    let banned = {{json_encode($banned)}};
    let permission = {{json_encode($permission)}};
    let cant_repeat10 = {{json_encode($cant_repeat10)}};
    
    function edit_password_btn(radio){
        let amount = $("#input_amount").val();
        var number_check = /^\+?[1-9][0-9]*$/;
        
        if ($("#isRead").prop('checked') == false) {
            
            // $('#isRead').prop('checked', true);
            swal('提示', `請確認"週週投約定條款"後再進行申請，謝謝!`, 'info');
        } else {
                if(!banned && !permission && !cant_repeat10 && amount.match(number_check) && amount>=5000 && amount<=30000 && amount%1000==0 || radio == 1){
                    
                    switch (radio) {
                        case 1:
                            swal({
                                title: "您確認要終止週週投？",
                                type: "info",
                                confirmButtonText: `確認`,
                                cancelButtonText: `取消`,
                                showCancelButton: true//顯示取消按鈕
                            }).then( value => {
                                        //使用者按下「確定」要做的事
                                        run(radio);
                                        // swal("完成!", "資料已經刪除", "success");
                                
                                });//end then 
                        break;
                        case 2:
                            swal({
                                title: "您確認要修改投資金額？",
                                html: "修改後系統會即時更新認購金額",
                                type: "info",
                                confirmButtonText: `確認`,
                                cancelButtonText: `取消`,
                                showCancelButton: true//顯示取消按鈕
                            }).then( value => {
                                    
                                        //使用者按下「確定」要做的事
                                        run(radio);
                                        // swal("完成!", "資料已經刪除", "success");
                                
                                });//end then 
                        break;
                        case 3:
                            swal({
                                title: "您確認要恢復週週投？",
                                type: "info",
                                confirmButtonText: `確認`,
                                cancelButtonText: `取消`,
                                showCancelButton: true//顯示取消按鈕
                            }).then( value => {
                                    
                                        //使用者按下「確定」要做的事
                                        run(radio);
                                        // swal("完成!", "資料已經刪除", "success");
                                
                                });//end then 
                        break;
                        case 4:
                            swal({
                                title: "您確認要暫停週週投？",
                                type: "info",
                                confirmButtonText: `確認`,
                                cancelButtonText: `取消`,
                                showCancelButton: true//顯示取消按鈕
                            }).then( value => {
                                    
                                        //使用者按下「確定」要做的事
                                        run(radio);
                                        // swal("完成!", "資料已經刪除", "success");
                                
                                });//end then 
                        break;
                    default:    
                    }
                
                }else if(banned){
                    swal('提示', '您的帳號目前違停權狀態!', 'error').then(function () {
                        location.reload();
                    })
                }else if(permission){
                    swal('提示', '您的帳號權限錯誤!', 'error').then(function () {
                        location.reload();
                    })
                }else if(cant_repeat10){
                    swal('提示', '週週投變更10分鐘後才可再更改!', 'info').then(function () {
                        location.reload();
                    })
                }else if(!amount.match(number_check)){
                    swal('提示', '注意只可輸入數字!', 'error').then(function () {
                        location.reload();
                    })
                }else if(amount<=5000 || amount>=30000 || amount%1000!==0){
                    swal('提示', '投標金額不可少於5000元，最高上限為三萬元，(金額以千為單位!)', 'error').then(function () {
                        location.reload();
                    })
                }
            }
        }
    function run (radio){
            $.ajax({
                url: '{{ url("/users/weekly_claim_category/front_update") }}',
                type: 'post',
                data: {
                    amount : $("#input_amount").val(),
                    radio : radio,
                    id : {{$weekly[0]->l_e_id}}
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (d) {
                    if (d.status == 'success') {
                        swal('提示', '申請成功!', 'success').then(function () {
                            location.reload();
                        })
                    } else if (d.status == 'banned') {
                        swal('提示', '您的帳號目前違停權狀態!', 'error').then(function () {
                            location.reload();
                        })
                    } else if (d.status == 'permission') {
                        swal('提示', '您的帳號權限錯誤!', 'error').then(function () {
                            location.reload();
                        })
                    } else if (d.status == 'no_purview') {
                        swal('提示', '您尚未通過實名認證，無法使用此功能!', 'error').then(function () {
                            location.reload();
                        })
                    } else if (d.status == 'no_user') {
                        swal('提示', '無此使用者!，請重新登入', 'error').then(function () {
                            location.reload();
                        })
                    } else if (d.status == 'amount_error') {
                        swal('提示', '投標金額不可少於5000元，最高上限為三萬元，(金額以千為單位!)', 'error').then(function () {
                            location.reload();
                        })
                    } else if (d.status == 'not_amount') {
                        swal('提示', '注意只可輸入數字!', 'error').then(function () {
                            location.reload();
                        })
                    } else if (d.status == 'cant_repeat10') {
                        swal('提示', '週週投變更10分鐘後才可再更改!', 'info').then(function () {
                            location.reload();
                        })
                    } else {
                        swal('提示', '系統錯誤!請重新操作', 'error').then(function () {
                            location.reload();
                        })
                    }
                },
                error: function (e) {
                    swal('提示', '系統錯誤!請重新操作', 'error').then(function () {
                        location.reload();
                    })
                }
            })
    }
</script>
@endsection
