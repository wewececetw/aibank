<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Finacial\FirstSheet;
use App\Exports\Finacial\SecondSheet;

class FinacialExport implements WithMultipleSheets
{
    use Exportable;

    protected $foreign;
    protected $date;

    public function __construct(array $array)
    {
        $this->foreign = $array['foreign'];
        $this->date = $array['target_repayment_date'];
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[0] = new FirstSheet($this->foreign,$this->date);
        $sheets[1] = new SecondSheet($this->foreign,$this->date);

        return $sheets;
    }
}
