<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Log;
use Illuminate\Support\Facades\Storage;
// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Match;
use App\Claim;
use App\ClaimFiles;
use App\Tenders;
use App\SystemVariables;
use App\Order;
use App\User;
use App\UsersRoles;
use App\UserBank;

//本金攤還
use App\PayBackCount\equalPrincipalPayment;
//本息攤還
use App\PayBackCount\equalTotalPayment;

use App\PayBackCount\Common;
use App\MainFlow\ClaimState\Changetypestate2;
use App\MainFlow\MainFlow;
//郵件相關
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleMail;

class ppgoController extends Controller
{
    public function gostate2(Request $req){
        $change_state =  $req->change_claim_state4;
        $claim = Claim::find($change_state);
        $aaa = new Changetypestate2($claim);
        $aaa->init();
    }
    public function check_document_id(Request $req){
        $check_document_id =  $req->claim_number;
        $row =  DB::select("select tender_documents_id,claim_certificate_number from tender_documents where claim_id = (select claim_id from claims where claim_number = ? )",[$check_document_id]);
        foreach ($row as $k){
            echo $k->tender_documents_id.'->'.$k->claim_certificate_number;
        }
    }
}
