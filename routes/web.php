<?
/*
    if (!empty($_SERVER["HTTP_CLIENT_IP"])){
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }else{
        $ip = $_SERVER["REMOTE_ADDR"];
    }
    if($ip!="125.227.159.140" and $ip!="59.127.195.243" and $ip!="218.161.40.233" and $ip!="210.71.188.87"){
            //header("location:https://www.pponline.com.tw/");
    }
*/
/*

if( $_SERVER['REQUEST_URI'] !="/main" ){
    if (!empty($_SERVER["HTTP_CLIENT_IP"])){
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }else{
        $ip = $_SERVER["REMOTE_ADDR"];
    }
    if($ip!="125.227.159.140" and $ip!="59.127.195.243" and $ip!="218.161.40.233" and $ip!="210.71.188.87"){
        header("location:main");
    }
}
/**/
use App\Mail\TestEmail;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/
Route::view('main', 'main.main');
Route::get('/logout','Auth\LoginController@logout');
// Route::get('/login','Auth\LoginController@authenticated');
    Auth::routes();

    Route::post('login', 'Auth\LoginController@login')->middleware('loginbefore')->middleware('loginafter');

    Route::post('/log/UpdUserRead','API\LogController@upduserreadtime');

    // Route::post('register', 'Auth\RegisterController@postRegistration')->name('register');
    Route::post('/trustpigs/get_default_rate_table','FrontEndController@get_default_rate_table');

// Front_End前台--------------------------------------------------------------------------------

    // 登入
    Route::get('/users/sign_up','FrontEndController@sign_up');
    Route::get('/users/sign_in','Auth\LoginController@showLoginForm');
    Route::get('/users/password_new','FrontEndController@password_new');
    // Route::post('/users/sign_up/register','Auth\RegisterController@postRegistration')->name('register');
    Route::post('/users/sign_up/define','Auth\RegisterController@postRegistration');
    Route::get('/users/confirmation','Auth\RegisterController@mailConfirmation');
    Route::post('/users/forget_password','Auth\LoginController@forget_password');
    Route::get('/users/newpassword_setting','Auth\LoginController@newpassword_setting');
    Route::post('/users/newpassword_confirmation','Auth\LoginController@newpassword_confirmation')->name('newpassword_confirmation');
    Route::get('/users/resent_validation','Auth\LoginController@resent_validation');
    Route::post('/users/resent_confirmation','Auth\LoginController@resent_confirmation');

//-----------------------------------2021-07-01活動條款-------------------------------------------------------
    Route::post('/users/activity/rule','FrontEndController@rule');












    // 首頁
    Route::get('/','FrontEndController@index');


    // 關於我們
        Route::get('/front/about','FrontEndController@about_index');
        Route::get('/front/about_finance','FrontEndController@about_index_finance');

        Route::get('/front/about_news','FrontEndController@about_index_news');
        // 新聞
        Route::get('/news/news_detail','FrontEndController@news_details');


    // 操作指南
    Route::get('/front/operation','FrontEndController@operation_index');
    Route::get('/front/operation_faq','FrontEndController@operation_faq');


    // 投資認購(claims)

        // (智能媒合項目)
        Route::get('/front/claim_category/{line_id}/{cliams_type}','FrontEnd_ClaimsController@claim_category_index');
        Route::post('/front/get_claims_html/{cliams_id}','FrontEnd_ClaimsController@get_claims_html');

        // (特別投資項目)
        Route::get('/front/claim_category_special/{line_id}/{cliams_type}','FrontEnd_ClaimsController@claim_category_special');
        Route::post('/front/get_sp_claims_html/{sp_cliams_id}','FrontEnd_ClaimsController@get_sp_claims_html');

        // (歷史投資項目)
        Route::get('/front/claim_category_history/{line_id}/{cliams_type}','FrontEnd_ClaimsController@claim_category_history');
        Route::post('/front/get_claims_history_html/{cliams_id}','FrontEnd_ClaimsController@get_claims_history_html');

        //投資試算
        Route::get('/front/claim_category_counting','FrontEnd_ClaimsController@claim_category_counting');
        Route::get('/front/claim_category_counting_c2','FrontEnd_ClaimsController@claim_category_counting_c2');

        // 投標
        Route::group(['middleware' => ['auth']], function () {
            Route::get('/front/claim_tender/{cliams}','FrontEnd_ClaimsController@tender_details');
            Route::post('/front/multipleCreateTender','FrontEndController@multipleCreateTender');

        });


        Route::post('/front/claim_tender/{cliams}/insert','FrontEnd_ClaimsController@tender_create');


        //智能媒合
        Route::get('/front/claim_match','FrontEndController@claim_match');
       //投資試算
        Route::post('/front/claim_match/api/totalSplits','FrontEndController@totalSplits');
        Route::post('/front/claim_match/api/randomTotalSplits','FrontEndController@randomTotalSplits');


    // 貸款專區
    Route::get('/front/loan','FrontEndController@loan_index');

    //套用PDF檔 繳款
    Route::get('/front/PaymentNoticePdf/{pay_day}','TestController@payPdf');
    Route::get('/front/foradminPdf/{user_number}/{pay_day}','TestController@payPdf2');    


    Route::get('/web_test', function () {
        return view('Front_End.layout.welcome');
        });


        //服務合約
        Route::get('/front/service','FrontEndController@service_contract');
        //隱私權政策
        Route::get('/front/privacy','FrontEndController@privacy');
        //服務合約
        Route::get('/front/risk','FrontEndController@risk');
// 使用者後台--------------------------------------------------------------------------------

Route::group(['middleware' => ['auth']], function () {

    Route::group(['middleware' => ['front']], function () {
        Route::view('/users/font_img_r_2', 'uploads.idfont_r_2');
        Route::view('/users/back_img_r_2', 'uploads.idback_r_2');
        
        //我的帳戶
        Route::get('/front/myaccount','UserAccountController@account');
        Route::get('/front/myaccount_not_paid','UserAccountController@account_unpay');
        Route::get('/front/myaccount_failure','UserAccountController@account_failure');
        Route::get('/front/myaccount_bill','UserAccountController@account_bill');

        Route::get('/front/myaccount_pdf/{pdfid}','UserAccountController@look_pdf');

        Route::post('/front/m_get_claims_html/{cliams_id}','FrontEnd_ClaimsController@m_get_claims_html');
        //收益明細API
        Route::get('/front/api/getRepaymentDetail/{tenderId}','UserAccountController@apiGetRepaymentDetail');
        ////////測別人的帳本
        ////////測別人的帳本
        ////////測別人的帳本
        //Route::get('/front/myaccount_bill2','UserAccountController@account_bill2');
        //Route::get('/front/api/getRepaymentDetail2/{tenderId}/{uu}','UserAccountController@apiGetRepaymentDetail2');
        ////////測別人的帳本
        ////////測別人的帳本
        ////////測別人的帳本
    Route::get('/front/downloadClaimPdf','UserAccountController@downloadClaimPdf');

    //個人真實資訊
        Route::get('/users','UserInfoController@index');
        Route::view('/users/font_img', 'uploads.idfont');
        Route::view('/users/back_img', 'uploads.idback');
        Route::post('/users/update_info','UserInfoController@userInfo');
        Route::post('/user/sendPhoneMsg','UserInfoController@sendPhoneMsg');

        Route::get('/front/downloadClaimPdf','UserAccountController@downloadClaimPdf');

        // Route::get('/user/checkIsNeedSmsConfirm','UserInfoController@checkIsNeedSmsConfirm');


        //個人真實資訊
        Route::get('/users','UserInfoController@index');
        Route::post('/users/update_info','UserInfoController@userInfo');
        Route::post('/user/sendPhoneMsg','UserInfoController@sendPhoneMsg');

        //銀行帳戶
        Route::get('/users/tab_two','UserBankAccountController@index');
        Route::post('/user/bank_account_insert','UserBankAccountController@bank_account_insert');
        Route::post('/user/bank_select','UserBankAccountController@bank_select');
        Route::post('/user/bank_delete/{bank_id}','UserBankAccountController@bank_delete');
        Route::post('/user/is_active_update','UserBankAccountController@is_active_update');



        //投資習慣設定
        Route::get('/users/tab_four','UserManageController@habit');
        Route::post('/users/tab_four/save','UserManageController@habitSave');
        //修改密碼
        Route::get('/users/tab_five','UserManageController@change_password');
        Route::post('/users/changepassword_confirmation','UserManageController@change_confirmation');

        //繳款
        Route::get('/front/payment','UserManageController@payment');

        //我的收藏
        Route::get('/users/favorite','UserManageController@favorite');

        //會員訊息
        Route::get('/inbox_letters','UserManageController@inbox_letters');
        Route::get('/check_letters/{letter}','UserManageController@check_letters');
        Route::get('/del_inbox_letters/{letter}','UserManageController@del_inbox_letters');
        Route::post('/inbox_letters/search','UserManageController@inbox_letters_search');

        //豬豬推手
        Route::get('/users/pushhand','PushHandController@index');
        Route::get('/users/pushhand/pay_block','PushHandController@pay_block');
        // Route::get('/users/pushhand/unpay_block','PushHandController@unpay_block');
        Route::get('/users/pushhand/failur_block','PushHandController@failur_block');
        Route::post('/user/create_recommendation_code','PushHandController@create_recommendation_code');


        //週週投
        Route::get('/users/weekly_claim_category','WeeklyController@index');
        Route::post('/users/weekly_claim_category/insert','WeeklyController@insert');
        Route::post('/users/weekly_claim_category/front_update','WeeklyController@Front_update');
    });


    // Back_End管理者後台--------------------------------------------------------------------------------
    Route::group(['middleware' => ['back']], function () {


    // 登入後的頁面
    Route::get('/home','BackEndController@index');
    //以債權查詢tender_document_id
    // Route::get('/check_document_id','ppgoController@check_document_id');
    //手動更改債權狀態為4
    // Route::get('/gostate2','ppgoController@gostate2');

    // loan(貸款專區)
        Route::get('/admin/loans','LoansController@index');
        Route::post('/admin/loans/table_rows','LoansController@tableGenerator');
        Route::post('/admin/loans/search','LoansController@search');

        // 編輯
        Route::get('/admin/loans/loans_edit/{loan}','LoansController@loans_edit');
        Route::post('/admin/loans/loans_update/{loan}','LoansController@loans_update');


    //claims(債權列表)
        Route::get('/admin/claims','ClaimsController@index');
        Route::get('/admin/claims/table','ClaimsController@tableGenerator');
        Route::post('/admin/claims/search','ClaimsController@search');
        Route::get('/admin/claims_create','ClaimsController@claims_create');
        Route::post('/admin/claims_insert','ClaimsController@claims_store');
        Route::get('/admin/claims_edit/{claim}','ClaimsController@claims_edit');
        Route::post('/admin/claims_update/{claim}','ClaimsController@claims_update');
        Route::get('/admin/claim_details/{claim}','ClaimsController@claim_details');
        Route::get('/admin/claim_export','ClaimsController@info_export');
        Route::post('/admin/variables_update','ClaimsController@variables_update');
        Route::post('/admin/claim_import', 'ClaimsController@import');
        Route::post('/admin/buy_tenderer_import', 'ClaimsController@buy_tenderer_import');
        Route::get('/admin/claim_download', 'ClaimsController@download');
        Route::get('/admin/buy_tenderer_download', 'ClaimsController@buy_tenderer_download');
        Route::post('/admin/claim_display', 'ClaimsController@is_display');
        Route::post('/admin/is_receive_letter', 'ClaimsController@is_receive_letter');
        Route::post('/admin/change_tenderer_import', 'ClaimsController@change_tenderer_import');
        Route::get('/admin/change_tenderer_download', 'ClaimsController@change_tenderer_download');

        Route::get('/admin/claim_repayments','ClaimsController@repayments_index');
        Route::get('/admin/claim_repayments_insert','ClaimsController@claim_repayments_insert');
        Route::post('/variables_update','ClaimsController@variables_update');

        Route::get('/admin/claim_data/{claim}', 'ClaimsController@getClaimData');

        Route::post('/admin/claim/update','ClaimsController@updateClaim');


    //tender(標單專區)
        Route::get('/admin/tender_documents/search/{download}','TendersController@search');
        Route::get('/admin/tender_documents','TendersController@index');
        Route::post('/admin/tender_documents/search','TendersController@search');
        Route::post('/admin/tender_documents/table','TendersController@tableGenerator');
        Route::get('/admin/tender_detail/{tenders}','TendersController@tender_details');
        Route::get('/admin/tender_documents_export/unpaid','TendersController@unpaid_export');
        Route::get('/admin/tender_documents_export/pending','TendersController@pending_export');
        Route::post('/admin/tender_documents_import/paid','TendersController@paid_import');
        Route::post('/admin/tender_documents_import/repay','TendersController@repay_import');
        Route::post('/admin/tender_documents/paying','TendersController@paying');
        Route::get('/admin/tender_documents_export/finacialExport','TendersController@finacialExport');
        Route::get('/admin/tender_documents_export/taxExport','TendersController@taxExport');
        Route::get('/admin/tender_documents_export/taxExport_yatai','TendersController@taxExport_yatai');
        Route::get('/admin/tender_documents_export/taxExport_yatai2','TendersController@taxExport_yatai2');
        Route::get('/admin/tender_documents_export/taxExport_yatai3','TendersController@taxExport_yatai3');
        Route::get('/admin/tender_documents_export/taxExport_yatai4','TendersController@taxExport_yatai4');
        Route::post('/admin/tender_documents/setHealthSafe','TendersController@setHealthSafe');
        Route::post('/admin/tender_documents/remove','TendersController@remove');


    //user(會員專區)
        Route::get('/admin/users','UsersController@index');
        Route::get('/admin/user_discount_download','UsersController@user_discount_download');
        Route::post('/admin/users/detail','UsersController@rowDetail');
        Route::get('/admin/users_details/{user}','UsersController@users_details');
        Route::get('/admin/users_edit/{user}','UsersController@users_edit');
        Route::post('/admin/users_update/{user}','UsersController@users_update');
        Route::post('/admin/users/search','UsersController@search_export');
        Route::post('/admin/users_banned','UsersController@users_banned');
        Route::post('/admin/users_details/is_alert','UsersController@users_is_alert');
        Route::post('/admin/users_details/super_pusher','UsersController@users_super_pusher');
        Route::post('/admin/users_details/user_state','UsersController@users_user_state');
        Route::post('/admin/users_details/update_cfit','UsersController@update_cfit');
        Route::post('/admin/users_details/update_s_p','UsersController@update_s_p');
        Route::post('/admin/users_details/update_u_id','UsersController@update_u_id');
        Route::post('/admin/users_details/update_cn','UsersController@update_cn');
        Route::post('/admin/user_discount_import','UsersController@user_discount_import');
        
        Route::view('/users/font_img_r', 'uploads.idfont_r');
        Route::view('/users/back_img_r', 'uploads.idback_r');

        Route::get('/admin/users_details/letterChange/{user}/{letter}','UsersController@letterChange');
        Route::get('/admin/users_details/letter_type_Change/{user}/{letter_type}','UsersController@letter_type_Change');

        Route::get('/admin/users/search/{download}','UsersController@search_export')->name('users_excel.excel');

        // Route::get('/admin/users_excel','UsersController@excel')->name('users_excel.excel');

        Route::get('/admin/staffs','StaffsController@index');
        Route::get('/admin/staffs/detail','StaffsController@rowDetail');
        Route::post('/admin/staffs/search','StaffsController@search');
        Route::get('/admin/staffs_create','StaffsController@staff_create');
        Route::post('/admin/staffs_store','StaffsController@staff_store');
        Route::get('/admin/staffs_edit/{user}','StaffsController@staff_edit');
        Route::post('/admin/staffs_update/{user}','StaffsController@staff_update');
        Route::post('/admin/staffs_display','StaffsController@staff_display');
        Route::post('/admin/staffs_delete/{user}','StaffsController@staff_delete');

        Route::get('/admin/users_details/user_bank_confirm/{user_bank_id}/{state}','UsersController@user_bank_confirm');


    //letters(站內信)
        Route::post('/admin/internal_letters/image_upload', 'LettersController@upload')->name('upload');
        Route::get('/admin/internal_letters/image_browse', 'LettersController@browse')->name('browse');
        Route::get('/admin/internal_letters','LettersController@index');
        Route::get('/admin/outside_letters','LettersController@outside_letters');
        Route::post('/admin/outside_letters/search','LettersController@outside_letters_search');
        Route::get('/admin/outside_letters_details/{letters}','LettersController@outside_letters_details');
        Route::post('/admin/internal_letters/search','LettersController@search');
        Route::get('/admin/internal_letters_details/{letters}','LettersController@letters_details');
        Route::get('/admin/internal_letters_create','LettersController@letters_create');
        Route::post('/admin/internal_letters_store','LettersController@letters_store');
        Route::post('/admin/internal_letters_update','LettersController@letters_update');
        Route::get('/admin/inbox_letters_create','LettersController@inbox_letters_create');
        Route::post('/admin/inbox_letters_store','LettersController@inbox_letters_store');
        // Route::post('/admin/internal_letters_delete/{letters}','LettersController@letters_delete');

        Route::post('/andmin/internal_letters_send','LettersController@sendMail')->name('mail');

        Route::post('/admin/internal_letters_display','LettersController@letters_display');

    //reports(系統現況/報表)
        Route::get('/admin/reports','ReportsController@index');
        Route::get('/admin/reports/investExport','ReportsController@investExport');


    //roi_settings(智能媒合設定)
        Route::get('/admin/roi_settings','RoiSettingsController@index');
        Route::get('/admin/roi_settings/edit/{roi_settings}','RoiSettingsController@roi_settings_edit');
        Route::post('/admin/roi_settings/update/{roi_settings_id}','RoiSettingsController@roi_settings_update');


    //買回    
        Route::get('/admin/buying_back','Buying_backController@index');
        Route::post('/admin/buying_back/update','Buying_backController@update');
        Route::post('/admin/buying_back/search','Buying_backController@search');
        Route::get('/admin/buying_back_download','Buying_backController@download');
///////////////////////////////////////買回更新ROUTES-202107///////////////////////////////////////
        Route::get('/admin/buying_back_o_c','Buying_backController@index_o_c');
        Route::post('/admin/buying_back_o_c_post','Buying_backController@o_c_post');
        Route::post('/admin/buying_back_c_p_post','Buying_backController@c_p_post');
        Route::get('/admin/buying_back_ex1_get','Buying_backController@ex1_get');
        Route::get('/admin/buying_back_ex2_get','Buying_backController@ex2_get');
        Route::get('/admin/buying_back_c_p','Buying_backController@index_c_p');
        Route::post('/admin/buying_back_c_p/search','Buying_backController@search_c_p');
///////////////////////////////////////買回更新ROUTES-202107///////////////////////////////////////

    //週週投    
        Route::get('/admin/weekly_audited','WeeklyController@back_index');
        Route::post('/admin/weekly_audited/update','WeeklyController@update');
        Route::post('/admin/weekly_audited/search','WeeklyController@search');
        Route::get('/admin/weekly_audited/export/{download}','WeeklyController@search');

    //(前端管理)
        Route::get('/web_contents/web_category','CategoryController@index');

        // 新聞
        Route::get('/web_contents/news','NewsController@index');
        Route::get('/news/insert',function () {
            return view('Back_End.web_contents.news.news_edit');
            });
        Route::post('/news/insert','NewsController@news_insert');
        Route::get('/news/edit/{news}','NewsController@news_edit');
        Route::post('/news/update/{news}','NewsController@news_update');
        Route::post('/news/delete/{news}','NewsController@news_delete');
        //各種前端編輯
        // Route::resource('/web_contents/{category_name}','WebContentsController');
        Route::post('/web_contents/{category_name}/contents/{id}/update','WebContentsController@update');
        Route::post('/web_contents/resort','WebContentsController@resort');
        Route::resource('/web_contents/{category_name}/contents','WebContentsController');



        
    //(媒合表現數據設定)
        Route::get('/match_performances/new','PerformancesController@index');
        Route::post('/match_performances/new', 'PerformancesController@update_submit');

    // Sendgrid mail test
        Route::get('admin/testmail', function(){
            $data = ['message' => 'This is a test!'];
            Mail::to('ray.wu@intersense.com.tw')->send(new TestEmail($data));
            return back();
        })->name('testmail');

    });
});






    Route::group(['prefix' => 'test'], function () {
        Route::get('check_original_claim_amount_max','TestController@check_original_claim_amount_max');
        Route::get('check_original_claim_amount_max/{thisTenderAmount}/{claim_id}','TestController@check_original_claim_amount_max');

        //檢查 claim state != 2
        Route::get('check_claim_state','TestController@check_claim_state');
        Route::get('check_claim_state/{claim_id}','TestController@check_claim_state');

        //產生標單
        Route::get('addNewTender','TestController@addNewTender');
        Route::get('addNewTender/{claim_id}','TestController@addNewTender');

        //檢查債權狀態
        Route::get('checkClaimState','TestController@checkClaimState');
        Route::get('checkClaimState/{claim_id}','TestController@checkClaimState');

        // //檢查債權狀態
        // Route::get('writeDataToTenderRepayment','TestController@writeDataToTenderRepayment');
        // Route::get('writeDataToTenderRepayment/{claim_id}','TestController@writeDataToTenderRepayment');

        //下載PDF檔 債權憑證
        Route::get('downloadClaimPdf','TestController@downloadClaimPdf');
        Route::get('downloadClaimPdf/{user_id}/{claim_id}/{amount}/{claim_certificate_number}','TestController@downloadClaimPdf');
        Route::get('downloadClaimPdf/{user_id}/{claim_id}/{amount}','TestController@downloadClaimPdf');

        //儲存所有Claim底下的Tender PDF
        Route::get('saveClaimTendersPdf/{claim_id}','TestController@saveClaimTendersPdf');

        Route::get('ss','TestController@ss');
        Route::get('testMail','TestController@testMail');

        Route::get('bankSend','TestController@bankSend');
        //加密
        Route::post('bankSendEncrypt','TestController@bankSendEncrypt');
        //解密
        Route::post('bankSendDecrypt','TestController@bankSendDecrypt');

        //Claim state=2 的 tender 壓到 order API
        Route::get('claimToOrder','TestController@claimToOrder');
        //Order 發簡訊
        // Route::get('orderSendSms','TestController@orderSendSms');

        //發簡訊
        Route::get('sendPhoneMsg','TestController@sendPhoneMsg');
        Route::post('sendPhoneMsg','TestController@postSendPhoneMsg');
        Route::get('sendSMS','TestController@sendSMS');

        //本金攤還
        Route::get('equalPrincipalPaymentView','TestController@equalPrincipalPaymentView');
        Route::post('equalPrincipalPayment','TestController@equalPrincipalPayment');
        //本息攤還
        Route::get('equalTotalPayment','TestController@equalTotalPaymentView');
        Route::post('equalTotalPayment','TestController@equalTotalPayment');

        //test upload file
        // Route::get('uploadTest','TestController@uploadTest');
        // Route::post('uploadTest','TestController@postUploadTest');

        // Route::get('varDbCol','TestController@varDbCol');
        Route::get('time',function(){
            return date('Y-m-d H:i:s');
        });

        Route::get('MailTo','TestController@MailTo');
        Route::get('PaymentPdf','TestController@PaymentPdf');
    });

    //彰銀API明文接收
    Route::post('bankSendPlanText','ScheduleApiController@bankSendPlanText');
    Route::get('bankSendPlanText','ScheduleApiController@bankSendPlanTextGet');

    // Route::get('tttt',function(){
    //     // $url = 'http://hel12312lo.com';
    //     // $listdata = json_decode(file_get_contents($url));
    //     // dd($listdata);
    //     //不存在URL file_get_contents 會錯
    //     // array_merge 帶入非陣列 會錯
    //     $a = json_decode('ff');
    //     $b = ['ab' => 123];
    //     $lst = array_merge($a, $b);
    //     dd($lst);
    // });

    // Route::get('tim',function(){
    //     $t = date('Y-m-d H:i:s');
    //     $s = date('Y-m-d 23:59:59',strtotime($t));
    //     dd($t,$s);
    // });

    //自動運算數據
    Route::get('auto_match_performances','PerformancesController@auto_update');
    //檢查所有債權變化
    Route::get('checkAllClaimState','ScheduleApiController@checkAllClaimState');
    //Order 發簡訊
    Route::get('orderSendSms','ScheduleApiController@orderSendSms');
    //Order 檢查
    Route::get('checkOrder','ScheduleApiController@checkOrder');
    Route::get('sendOrder','ScheduleApiController@sendOrder');
    //產 claim4 的 pdf檔
    Route::get('claim_4_pdf','ScheduleApiController@claim_4_pdf');

    //檢查結標用
    Route::get('checkClaimClosed','ScheduleApiController@checkClaimClosed');

    Route::get('/clear-cache', function() {
        // Artisan::call('cache:clear');
        Artisan::call('config:clear');
        return "OK";
    });

    Route::get('/testPath',function(){
        $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
        dd($rootDir);
    });
