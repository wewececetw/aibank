<?php
namespace App\MainFlow\ClaimState;
use App\MainFlow\Main;
use App\Claim;
use App\Tenders;

class State3 extends Main{
    public $trig;
    public $claim;
    public $setBidFaild;
    public function __construct($claim)
    {
        $this->trig = false;
        $this->setBidFaild = false;
        $this->claim = $claim;
        $this->changeOfIsDisplay($claim);
    }

    public function init()
    {
        return false;
    }


}
