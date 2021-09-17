<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Exports\FinacialExport;


class ReportsController extends Controller
{
    public function index(){

        $date = "'".date('Y-m-d')."'";

        $data['invest'] = DB::select("select *,paid_amount/invest_amount as paid_rate from 
            (SELECT 
                r0.*,r3.create_count,r3.`SUM(c.staging_amount)` as staging_amount, r5.invest_count, r5.invest_amount,r7.paid_amount
            FROM
            (
            select DATE_FORMAT(".$date.", '%Y-%m-%d') AS exp_type
            union
            select distinct(DATE_FORMAT(td.created_at, '%Y-%m')) as exp_type
            FROM
                    tender_documents as td
            where 
            DATE_FORMAT(td.created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
            union
            select DATE_FORMAT(".$date.", '%Y') AS exp_type
            )as r0
            left join
                (SELECT 
                    DATE_FORMAT(c.created_at, '%Y-%m-%d') AS exp_type,
                        COUNT(*) AS create_count,
                        SUM(c.staging_amount)
                FROM
                    claims AS c
                WHERE
                    DATE_FORMAT(c.created_at, '%Y-%m-%d') = DATE_FORMAT(".$date.", '%Y-%m-%d')
                GROUP BY exp_type UNION SELECT 
                    DATE_FORMAT(c.created_at, '%Y-%m') AS exp_type,
                        COUNT(*),
                        SUM(c.staging_amount)
                FROM
                    claims AS c
                WHERE
                    DATE_FORMAT(c.created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                GROUP BY exp_type UNION SELECT 
                    DATE_FORMAT(c.created_at, '%Y') AS exp_type,
                        COUNT(*),
                        SUM(c.staging_amount)
                FROM
                    claims AS c
                WHERE
                    DATE_FORMAT(c.created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                GROUP BY exp_type) AS r3 on r3.exp_type= r0.exp_type
                    left JOIN
                ((SELECT 
                    DATE_FORMAT(created_at, '%Y-%m-%d') AS exp_type,
                        COUNT(DISTINCT user_id) AS invest_count,
                        SUM(amount) AS invest_amount
                FROM
                    tender_documents AS td1
                WHERE
                    DATE_FORMAT(created_at, '%Y-%m-%d') = DATE_FORMAT(".$date.", '%Y-%m-%d')
                GROUP BY exp_type) UNION (SELECT 
                    DATE_FORMAT(created_at, '%Y-%m') AS exp_type,
                        COUNT(DISTINCT user_id) AS invest_count,
                        SUM(amount) AS invest_amount
                FROM
                    tender_documents AS td1
                WHERE
                    DATE_FORMAT(created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                GROUP BY exp_type) UNION (SELECT 
                    DATE_FORMAT(created_at, '%Y') AS exp_type,
                        COUNT(DISTINCT user_id) AS invest_count,
                        SUM(amount) AS invest_amount
                FROM
                    tender_documents AS td1
                WHERE
                    DATE_FORMAT(created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                GROUP BY exp_type)) AS r5 ON r0.exp_type = r5.exp_type
                left join
                
            (
            (SELECT
            DATE_FORMAT(created_at, '%Y-%m-%d') as exp_type,
            sum(amount) as paid_amount
                
            FROM
                tender_documents as td1
            WHERE
                DATE_FORMAT(created_at, '%Y-%m-%d') = DATE_FORMAT(".$date.", '%Y-%m-%d')
                and
                DATE_FORMAT(paid_at, '%Y-%m-%d') = DATE_FORMAT(".$date.", '%Y-%m-%d')
                group by exp_type
            )
            union
            (
            SELECT
            DATE_FORMAT(created_at, '%Y-%m') as exp_type,
            sum(amount) as paid_amount
                
            FROM
                tender_documents as td1
            WHERE
                DATE_FORMAT(created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                and
                DATE_FORMAT(paid_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                group by exp_type
            )
            union
            (
            SELECT
            DATE_FORMAT(created_at, '%Y') as exp_type,
            sum(amount) as paid_amount
                
            FROM
                tender_documents as td1
            WHERE
                DATE_FORMAT(created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                and
                DATE_FORMAT(paid_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                group by exp_type
            )
            )as r7 ON r0.exp_type = r7.exp_type
            )as result
            order by length(exp_type) desc
            ");


        return view('Back_End.reports.reports_panel',$data);

    }


    public function investExport()
    {
        
        $date = "'".date('Y-m-d')."'";

        $data['invest'] = DB::select("select *,paid_amount/invest_amount as paid_rate from 
            (SELECT 
                r0.*,r3.create_count,r3.`SUM(c.staging_amount)` as staging_amount, r5.invest_count, r5.invest_amount,r7.paid_amount
            FROM
            (
            select DATE_FORMAT(".$date.", '%Y-%m-%d') AS exp_type
            union
            select distinct(DATE_FORMAT(td.created_at, '%Y-%m')) as exp_type
            FROM
                    tender_documents as td
            where 
            DATE_FORMAT(td.created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
            union
            select DATE_FORMAT(".$date.", '%Y') AS exp_type
            )as r0
            left join
                (SELECT 
                    DATE_FORMAT(c.created_at, '%Y-%m-%d') AS exp_type,
                        COUNT(*) AS create_count,
                        SUM(c.staging_amount)
                FROM
                    claims AS c
                WHERE
                    DATE_FORMAT(c.created_at, '%Y-%m-%d') = DATE_FORMAT(".$date.", '%Y-%m-%d')
                GROUP BY exp_type UNION SELECT 
                    DATE_FORMAT(c.created_at, '%Y-%m') AS exp_type,
                        COUNT(*),
                        SUM(c.staging_amount)
                FROM
                    claims AS c
                WHERE
                    DATE_FORMAT(c.created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                GROUP BY exp_type UNION SELECT 
                    DATE_FORMAT(c.created_at, '%Y') AS exp_type,
                        COUNT(*),
                        SUM(c.staging_amount)
                FROM
                    claims AS c
                WHERE
                    DATE_FORMAT(c.created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                GROUP BY exp_type) AS r3 on r3.exp_type= r0.exp_type
                    left JOIN
                ((SELECT 
                    DATE_FORMAT(created_at, '%Y-%m-%d') AS exp_type,
                        COUNT(DISTINCT user_id) AS invest_count,
                        SUM(amount) AS invest_amount
                FROM
                    tender_documents AS td1
                WHERE
                    DATE_FORMAT(created_at, '%Y-%m-%d') = DATE_FORMAT(".$date.", '%Y-%m-%d')
                GROUP BY exp_type) UNION (SELECT 
                    DATE_FORMAT(created_at, '%Y-%m') AS exp_type,
                        COUNT(DISTINCT user_id) AS invest_count,
                        SUM(amount) AS invest_amount
                FROM
                    tender_documents AS td1
                WHERE
                    DATE_FORMAT(created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                GROUP BY exp_type) UNION (SELECT 
                    DATE_FORMAT(created_at, '%Y') AS exp_type,
                        COUNT(DISTINCT user_id) AS invest_count,
                        SUM(amount) AS invest_amount
                FROM
                    tender_documents AS td1
                WHERE
                    DATE_FORMAT(created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                GROUP BY exp_type)) AS r5 ON r0.exp_type = r5.exp_type
                left join
                
            (
            (SELECT
            DATE_FORMAT(created_at, '%Y-%m-%d') as exp_type,
            sum(amount) as paid_amount
                
            FROM
                tender_documents as td1
            WHERE
                DATE_FORMAT(created_at, '%Y-%m-%d') = DATE_FORMAT(".$date.", '%Y-%m-%d')
                and
                DATE_FORMAT(paid_at, '%Y-%m-%d') = DATE_FORMAT(".$date.", '%Y-%m-%d')
                group by exp_type
            )
            union
            (
            SELECT
            DATE_FORMAT(created_at, '%Y-%m') as exp_type,
            sum(amount) as paid_amount
                
            FROM
                tender_documents as td1
            WHERE
                DATE_FORMAT(created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                and
                DATE_FORMAT(paid_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                group by exp_type
            )
            union
            (
            SELECT
            DATE_FORMAT(created_at, '%Y') as exp_type,
            sum(amount) as paid_amount
                
            FROM
                tender_documents as td1
            WHERE
                DATE_FORMAT(created_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                and
                DATE_FORMAT(paid_at, '%Y') = DATE_FORMAT(".$date.", '%Y')
                group by exp_type
            )
            )as r7 ON r0.exp_type = r7.exp_type
            )as result
            order by length(exp_type) desc
            ");


        $invest_export = [
            [
                '當日',
                '上拋債權件數',
                '上拋債權金額',
                '投標人數',
                '投標金額',
                '募集金額',
                '募集成功率'
                
            ],
            [
                'exp_type',
                'create_count',
                'staging_amount',
                'invest_amount',
                'invest_count',
                'paid_amount',
                'paid_rate'
            ],
        ];


        foreach ($data['invest'] as $row) {
            $ar = [$row->exp_type,
                $row->create_count,
                $row->staging_amount,
                $row->invest_amount,
                $row->invest_count,
                $row->paid_amount,
                $row->paid_rate];

                array_push($invest_export, $ar);
        }


        $myFile = Excel::download(new UsersExport($invest_export), '報稅資料表.xlsx');
        return $myFile;
    }
}

    

