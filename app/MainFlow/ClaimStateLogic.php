<?php
namespace App\MainFlow;
use App\Claim;

use Log;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class ClaimStateLogic {
    public $claim;
    public $state;

    public function __construct($claim_id)
    {
        $model = Claim::find($claim_id);
        $this->claim = $model;
        try {
            $this->state = $model->getOriginal('claim_state');
        } catch (\Throwable $th) {
            if(isset($model->claim_state)){
                $this->state = $model->claim_state;
            }else{
                abort(555,'State 不存在');
            }
        }

    }

    public function check()
    {
        try {
            $old_state = $this->claim->claim_state;
            //動態呼叫Class
            $className = __NAMESPACE__ . '\\' . 'ClaimState' . '\\' . 'State'.$this->state;
            $c = new $className($this->claim);
            $c->init();

            $new_state = Claim::find($this->claim->claim_id)->claim_state;
            $this->debuglogg($old_state,$new_state,$this->claim->claim_id);

        } catch (\Throwable $th) {
            abort(555,$th);
            // dd($th);
        }

    }


    public function debuglogg($stateO,$stateN,$claim_id)
    {
        $logpath = 'logs/mainFlow_run/' . date("Y-m-d H") . '.log';
        $log = new Logger('pp_ClaimStateLogic');
        $log->pushHandler(new StreamHandler(storage_path($logpath)), Logger::DEBUG);
        $stateText = ($stateO !== $stateN)?'轉換':'無變化';
        $msg = [
            '時間:'.date('Y-m-d H:i:s'),
            '狀態:'.$stateO.'->'. $stateN,
            '狀態轉換:'.$stateText,
            'Claim Id:'.$claim_id
        ];
        $log->debug('檢查',$msg);

    }

}

