<?
$img = fopen("../images/id_back_file_name/id_".Auth::user()->user_id.".jpg","rb" );       
header("Content-type: image/jpeg"); 
fpassthru($img);
?>
