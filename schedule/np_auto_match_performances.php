<?
include_once("setsql/setdb.php");


$items = array('annualBenefitsRate','memberBenefits','totalInvestAmount');
//計算投資總額
$totalInvestAmount_sql = 'SELECT sum(amount) as amount  FROM tender_documents WHERE tender_document_state in(2,4)';

$ro = mysqli_query($link,$totalInvestAmount_sql);
// if(!$ro){var_dump(mysqli_error($link));}
// exit;
$row = mysqli_fetch_assoc($ro);

$value = array();

$value['totalInvestAmount'] = $row['amount'];
//計算會員收益
$memberBenefits_sql = 'SELECT
                    sum(tr.per_return_interest) AS return_interest
                    FROM
                        tender_documents td , tender_repayments tr 
                    where
                        td.tender_document_state in(2,4) and  td.tender_documents_id = tr.tender_documents_id
                    group by
                        td.tender_documents_id';

$ro1 = mysqli_query($link,$memberBenefits_sql);
// if(!$ro){var_dump(mysqli_error($link));}
// exit;
$row1 = mysqli_fetch_assoc($ro1);                        

$memberBenefits = 0;
do{

    $memberBenefits += $row1['return_interest'];
}while($row1 = mysqli_fetch_assoc($ro1));

$value['memberBenefits'] = $memberBenefits;



//計算年平均報酬
$data = 'SELECT c.annual_interest_rate , td.amount FROM tender_documents td, claims c  WHERE td.tender_document_state in(2,4) and c.claim_id = td.claim_id';
$ro2 = mysqli_query($link,$data);
// if(!$ro){var_dump(mysqli_error($link));}
// exit;
$row2 = mysqli_fetch_assoc($ro2);  

$total = 0;
do{

    $total += (($row2['annual_interest_rate']/100)*$row2['amount']);

}while($row2 = mysqli_fetch_assoc($ro2));

$value['annualBenefitsRate'] = ($total/$value['totalInvestAmount'])*100;


foreach ($items as $item) {

    $sql = "UPDATE data_value set value =".$value[$item]." where value_name = '".$item."'";

    $rola = mysqli_query($link,$sql);

}
echo "sucess";
?>