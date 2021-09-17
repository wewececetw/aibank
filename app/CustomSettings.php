<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Claim;

class CustomSettings extends Model
{
    //
    protected $table = 'custom_settings';
    protected $primaryKey = "custom_settings_id";
    protected $guarded = [];

    public static $percentToRiskArray = [
        "a_percent" => "A",
        "b_percent" => "B",
        "c_percent" => "C",
        "d_percent" => "D",
        "e_percent" => "E",
    ];

    /**
     * 審核通過時，建立使用者預設資料
     *
     * @param  mixed $user_id
     * @return void
     */
    public function createUserDefaultSettings($user_id)
    {
        $defaultSetting = config('customSettingParams');
        $dataArr = $defaultSetting[0];
        $dataArr['user_id'] = $user_id;
        $dataArr['created_at'] = date('Y-m-d H:i:s');
        $dataArr['updated_at'] = date('Y-m-d H:i:s');
        $this->create($dataArr);
    }


    public static function beautifulSetting($setArray)
    {
        $percentToRiskArray = self::$percentToRiskArray;
        $result = [];
        foreach ($setArray as $k => $v) {
            if(isset($v) && $v != 0 && (int)$v != 0){
                if(isset($percentToRiskArray[$k])){
                    $key = Claim::nameSwitch('risk_category',$percentToRiskArray[$k]);
                    $result[$key] = $v;
                }

            }
        }
        return $result;
    }
}
