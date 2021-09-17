<?php
namespace App\Traits;

trait DataTables{

    // --- DataTable 如果有搜尋值時 -- //
    public function scopeTableApiSearch($query, $searchParamsArray)
    {
        foreach ($searchParamsArray as $val) {
            $query = $query->where($val['col'], 'LIKE', '%' . $val['val'] . '%');
        }
        return $query;
    }
    // ---- Order By, Offset,limit ---- //
    public function scopeTableApiOOL($query, $orderBy, $ascDesc, $offset, $limit)
    {
        return $query->orderBy($orderBy, $ascDesc)->offset($offset)->limit($limit);
    }
    // ---- Count Api Run Result ---- //
    public function scopeTableApiCount($query, $num)
    {
        if ($num > 0) {
            return $query->count();
        } else {
            $n = new self(); 
            return $n->count();
        }
    }
    // -- 組合DataTables要吃的陣列格式 - //
    public function scopeFormatArray($query,$draw,$totalCount,$filterCount,$attributeArray)
    {
        $result = [];
        $result['draw'] = $draw;
        $result['recordsTotal'] = $totalCount;
        $result['recordsFiltered'] = $filterCount;
        $result['data'] = [];
        foreach ($query->get() as $val) {
            $data = [];
            foreach ($attributeArray as $key => $attribute) {
                $data[$key] = $val[$attribute];
            }
            array_push($result['data'], $data);
        }
        return $result;
    }
    // --- 分解DataTables的請求參數 -- //
    public function scopeBreakDownRequestQuery($query,$requestQuery,$columns)
    {
        $searchParamsArray = [];
        foreach ($requestQuery as $key => $value) {
            switch ($key) {
                case 'start':
                    $start = $value;
                    break;
                case 'length':
                    $length = $value;
                    break;
                case 'draw':
                    $draw = $value;
                    break;
                case 'order':
                    $orderBy[0] = $columns[$value[0]['column']];
                    $orderBy[1] = $value[0]['dir'];
                    break;
                case 'columns':
                    //如果欄位搜尋有值
                    foreach ($value as $col) {
                        if (!is_null($col['search']['value'])) {
                            $ar = [];
                            $ar['col'] = $col['data'];
                            $ar['val'] = $col['search']['value'];
                            array_push($searchParamsArray, $ar);
                        }
                    }
                    break;
                default:
                    break;
            }
        }
        $result = [
            'start' => $start,
            'length' => $length,
            'draw' => $draw,
            'orderBy' => $orderBy,
            'searchParamsArray' => $searchParamsArray
        ];
        return $result;
    }

    // - 把所有上面Function直接run一遍 - //
    public function scopeRunDataTables($query,$requstQuery,$columns,$attributeArray)
    {
        //儲存搜尋欄位&值
        $analisQuery = $query->BreakDownRequestQuery($requstQuery,$columns);
        //有下搜尋
        if (count($analisQuery['searchParamsArray']) > 0) {
            $query = $query->tableApiSearch($analisQuery['searchParamsArray']);
        }
        //篩選後數量，這要在拉分頁和排序前先做，不然數字不對
        $filterCount = $query->tableApiCount(count($analisQuery['searchParamsArray']));
        //開始拉分頁和排序資料
        $query = $query->tableApiOOL($analisQuery['orderBy'][0], $analisQuery['orderBy'][1], $analisQuery['start'], $analisQuery['length']);
        //資料總數量
        $totalCount = $query->tableApiCount(0);
        $result = $query->formatArray($analisQuery['draw'],$totalCount,$filterCount,$attributeArray);


        return $result;
    }
}