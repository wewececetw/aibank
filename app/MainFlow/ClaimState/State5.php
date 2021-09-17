<?php
namespace App\MainFlow\ClaimState;
use App\MainFlow\Main;
use App\Claim;
use App\Tenders;

class State5 extends Main{
    public $trig;
    public $claim;
    public function __construct($claim)
    {
        $this->trig = false;
        $this->claim = $claim;
    }

    public function init()
    {
        return false;
    }


}
