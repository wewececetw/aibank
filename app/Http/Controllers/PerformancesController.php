<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Match;

class PerformancesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    private $items = array('annualBenefitsRate','memberBenefits','totalInvestAmount');
    
    public function index()
    {
        $datas = Match::where('value_type','=','frontShow')->get();
        $result = array();
        foreach($datas as $data)
        {
            if($data->value_name == 'annualBenefitsRate')
            {
                $result['annualBenefitsRate'] = $data->value;
                continue;
            }
            else if($data->value_name == 'memberBenefits')
            {
                $result['memberBenefits'] = $data->value;
                continue;
            }
            else if ($data->value_name == 'totalInvestAmount')
            {
                $result['totalInvestAmount'] = $data->value;
                continue;
            }
        }
        return view('Back_End.web_contents.match_panel',$result);   
    }

    public function auto_update(){

        $totalInvestAmount = DB::select('SELECT sum(amount) as amount  FROM tender_documents WHERE tender_document_state in(2,4)');

        $value = array();

        $value['totalInvestAmount'] = $totalInvestAmount[0]->amount;

        $memberBenefits = DB::select('SELECT
                            sum(tr.per_return_interest) AS return_interest
                            FROM
                                tender_documents td , tender_repayments tr 
                            where
                                td.tender_document_state in(2,4) and  td.tender_documents_id = tr.tender_documents_id
                            group by
                                td.tender_documents_id');

        $value['memberBenefits'] = 0;
        foreach ($memberBenefits as $k) {

            $value['memberBenefits'] += $k->return_interest;
        }

        $data = DB::select('SELECT c.annual_interest_rate , td.amount FROM tender_documents td, claims c  WHERE td.tender_document_state in(2,4) and c.claim_id = td.claim_id');

        $total = 0;
        foreach ($data as $k) {

            $total += (($k->annual_interest_rate/100)*$k->amount);

        }

        $value['annualBenefitsRate'] = ($total/$value['totalInvestAmount'])*100;


        foreach ($this->items as $item) {

            $match = Match::where('value_name',$item)->first();

            $match->value = $value[$item];
            $match->save();

        }
    }

    public function update_submit(Request $request)
    {
        
        foreach($this->items as $item){
            $value = $request->input($item);

            $match = Match::where('value_name',$item)->first();

            $match->value = $value;
            $match->save();

        }

        return response()->json([
                'success' => true,
                'msg' => '已儲存'
            ]);
       
    }
}
