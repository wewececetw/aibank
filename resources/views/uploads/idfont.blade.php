<?
$img = fopen("../images/id_front_watermark/id_".Auth::user()->user_id.".jpg","rb" );       
header("Content-type: image/jpeg"); 
fpassthru($img);
?>
