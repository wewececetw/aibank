<?php
namespace App\Exports\Finacial;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Claim;
use DB;

class SecondSheet implements FromCollection, WithTitle,WithHeadings,WithColumnFormatting
{
    protected $foreign;
    protected $date;
    private $claimModel;

    public function __construct($foreign,$date)
    {
        $this->foreign = $foreign;
        $this->date = $date;
        $this->claimModel = new Claim;
    }

    /**
     * @return Builder
     */
    public function collection()
    {
        $doc = "'";
        $data = collect(DB::select('SELECT
        pre_r.target_repayment_date,
        c.value_date,
        CONCAT("'.$doc.'",pre_r.claim_certificate_number) as claim_certificate_number,
        u.user_name,
        CONCAT("'.$doc.'",u.virtual_account) as virtual_account,
        u.id_card_number,
        pre_r.per_return_principal as per_return_principal ,
        pre_r.per_return_interest,
        pre_r.management_fee,
        (per_return_principal + pre_r.per_return_interest) - pre_r.management_fee,
        c.note,
        c.claim_state

    FROM
        (SELECT
            tr.target_repayment_date,
                tr.real_return_amount,
                tr.management_fee,
                tr.per_return_principal,
                tr.per_return_interest,
                td.user_id,
                td.claim_id,
                td.claim_certificate_number,
                ub.bank_id,
                ub.bank_account
        FROM
            (SELECT
            *
        FROM
            tender_repayments
        WHERE
            paid_at is null AND target_repayment_date = "'. $this->date .' 00:00:00"
                AND tender_documents_id IN (SELECT
                    tender_documents_id
                FROM
                    tender_documents
                WHERE
                    claim_id IN (SELECT
                            claim_id
                        FROM
                            claims
                        WHERE
                            `foreign` = '.$this->foreign.' AND claim_state = 4) AND tender_document_state in (2,4))) AS tr
        INNER JOIN (SELECT
            *
        FROM
            tender_documents WHERE tender_document_state in (2,4) ) AS td ON tr.tender_documents_id = td.tender_documents_id
        LEFT JOIN (SELECT
            *
        FROM
            user_bank
        WHERE
            bank_id IN (SELECT
                    bank_id
                FROM
                    bank_lists)) AS ub ON tr.user_bank_id = ub.user_bank_id) AS pre_r
            LEFT JOIN
        (SELECT
            user_name, id_card_number, user_id,virtual_account
        FROM
            users) AS u ON pre_r.user_id = u.user_id
            LEFT JOIN
        (SELECT
            note, claim_state, claim_id,value_date
        FROM
            claims) AS c ON pre_r.claim_id = c.claim_id
            LEFT JOIN
        (SELECT
            *
        FROM
            bank_lists) AS b ON pre_r.bank_id = b.bank_id
            order by user_name
;'));

            $data->map(function($v){
                $v->claim_state = $this->claimModel->getClaimStateAttribute($v->claim_state);
                return $v;
            });
            return $data;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return '信任豬出款總明細';
    }

    public function headings(): array
    {
        return [
            '付款日期',
            '起息日',
            '債權憑證號',
            '投資人',
            '繳款虛擬帳號',
            '識別碼(身分證)',
            '本金',
            '利息',
            '手續費',
            '收款金額',
            '債權備註',
            '債權狀態',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
