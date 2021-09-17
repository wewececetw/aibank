<?php

include_once("setsql/setdb.php");

$sql = 'UPDATE
                claims
                SET
                is_display = 1
                WHERE
                    claim_state in (0,1) AND is_display = 0 AND launched_at >=  ADDDATE("'.$nt.'",INTERVAL -1 minute) AND "'.$nt.'" >= launched_at';
$ro = mysqli_query($link,$sql);                    



?>