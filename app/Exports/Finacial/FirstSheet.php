<?php
namespace App\Exports\Finacial;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Claim;
use DB;

class FirstSheet implements FromCollection, WithTitle,WithHeadings,WithColumnFormatting
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
        $docc = "'.$doc.'";
        $data = collect(DB::select('SELECT
         CONCAT("'.$doc.'" , "21322000035668") AS pay_account,
        "信任豬股份有限公司" AS pay_ac_name,
        "806" AS pay_bank,
        "1320" AS pay_bank_branch,
        SUM((per_return_principal + per_return_interest) - management_fee) as real_return_amount,
        CONCAT("'.$doc.'" , pre_r.bank_account) as  bank_account,
        u.user_name,
        CONCAT("'.$doc.'" , LPAD(b.bank_code, 3, "0") ) AS receive_bank,
        CONCAT("'.$doc.'" , LPAD(b.bank_branch_code, 4, "0") ) AS receive_bank_branch,
        "53" AS split_type,
        u.id_card_number,
        "15" AS fee_type,
        "0" AS contact_method,
        SUM(pre_r.management_fee) as management_fee, 
        SUM(pre_r.per_return_principal) as per_return_principal,
        SUM(pre_r.per_return_interest) as per_return_interest,
        c.note,
        c.claim_state
    FROM
        (
        SELECT
            tr.target_repayment_date,
            tr.real_return_amount,
            tr.management_fee,
            tr.per_return_principal,
            tr.per_return_interest,
            td.user_id,
            td.claim_id,
            ub.bank_id,
            ub.bank_account
        FROM
            (
            SELECT
                *
            FROM
                tender_repayments
            WHERE
            paid_at is null AND target_repayment_date = "'. $this->date .' 00:00:00" AND tender_documents_id IN(
                SELECT
                    tender_documents_id
                FROM
                    tender_documents
                WHERE
                    claim_id IN(
                    SELECT
                        claim_id
                    FROM
                        claims
                    WHERE
                        `foreign` = '.$this->foreign.' AND claim_state = 4 AND tender_document_state in (2,4)
                ) 
            ) 
        ) AS tr
    INNER JOIN(
        SELECT
            *
        FROM
            tender_documents WHERE tender_document_state in (2,4)
    ) AS td
    ON
        tr.tender_documents_id = td.tender_documents_id
    LEFT JOIN(
        SELECT
            *
        FROM
            user_bank
        WHERE
            bank_id IN(
            SELECT
                bank_id
            FROM
                bank_lists
        ) and is_active = "1"
    ) AS ub
    ON
        td.user_id = ub.user_id
    ) AS pre_r
    LEFT JOIN(
        SELECT
            user_name,
            id_card_number,
            user_id
        FROM
            users
    ) AS u
    ON
        pre_r.user_id = u.user_id
    LEFT JOIN(
        SELECT
            note,
            claim_state,
            claim_id
        FROM
            claims
    ) AS c
    ON
        pre_r.claim_id = c.claim_id
    LEFT JOIN(
    SELECT
        *
    FROM
        bank_lists
    ) AS b
    ON
        pre_r.bank_id = b.bank_id
    GROUP BY
        u.id_card_number,
        pre_r.target_repayment_date;'));

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
        return '元大';
    }

    public function headings(): array
    {
        return [
            '付款帳號',
            '付款戶名',
            '付款總行',
            '付款分行',
            '收款金額',
            '收款帳號',
            '收款戶名',
            '收款總行',
            '收款分行',
            '識別碼類別',
            '識別碼',
            '手續費負擔別',
            '通知方式',
            '手續費',
            '本金',
            '利息',
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
