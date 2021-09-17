<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection,WithColumnFormatting
{
    protected $data;

    //构造函数传值
    public function __construct($data)
    {
        $this->data = $data;
    }
    //数组转集合
    public function collection()
    {
        return new Collection($this->data);
    }
    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
