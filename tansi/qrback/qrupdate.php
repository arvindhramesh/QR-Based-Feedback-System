<html>
<body>
<?php
//@$app =$_GET['appno'];
//@$nam=$_GET['name'];
@$myarray = json_decode($_GET["myarray"]);
//echo $app.','. $nam;

$conn=oci_connect("tans","tans","tans");
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

if(isset($myarray))
{
 $sql="insert into tans.master_asset_data (parameters,name,questions,status,category) values    ('$myarray[0]','$myarray[1]','$myarray[2]','$myarray[3]','$myarray[4]') "  ;

$ins_fee =oci_parse($conn,$sql) ;
$r=oci_execute($ins_fee,OCI_DEFAULT);
if (!$r) {    
    $e = oci_error($ins_fee);
    //oci_rollback($conn);  // rollback changes to both tables
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}
else
{
oci_commit($conn);
}


$html ="
<html>
<body>
<h1> Invoice </h1>
<p>parameters :" . $myarray[0] ."</p>
<p> Name :" . $myarray[1] ." </p>
<p> questions:" . $myarray[2]." </p>
<p> status:" . $myarray[3]." </p>
<p> category:" . $myarray[4]." </p>
</body>
</html>";
echo $html;
file_put_contents("printfile.html",$html);
$printer="\\\\dbgct\\Kyocera";
$command ="print /D:". $printer ." printfile.html";
$output =shell_exec($command);
//optional show output for debugging
//echo "<pre> $output </pre>";




//echo "<script> window.close() </script>";
}
?>




</body>
</html>