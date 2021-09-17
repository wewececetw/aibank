<?
$img = fopen("../images/id_back_file_name/id_".$_GET['g'].".jpg","rb" );       
header("Content-type: image/jpeg"); 
fpassthru($img);
?>
