<style>
 
  @page {
 size:  A4  ;

}

  
table, th, td {
 margin-left:65px;
/*  border: 1px solid black;*/
  border-collapse: collapse;
  
}
tr {
		height:28px;
}
th
{

	text-align:left;
	font-family:"Times New Roman", Times, serif;
	font-size:14px;
	font-weight:300;
	
	
	
}




td {
	font-family:"Times New Roman", Times, serif;
	font-size:14px;
	font-weight:bold;
	
	

}

</style>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?PHP
include '../phpqrcode/qrlib.php';
   
@$searchq = strtoupper($_GET['id']);

//$conn=oci_connect("tans","tans","tans","AL32UTF8");
include 'connection.php';
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}
if($searchq=='')
{
$sqlstr="select NAME,CAT_ID,BLOCK FROM tans.ASSET_CATEGORY";

$stid=oci_parse($conn,$sqlstr);
oci_execute($stid);



while(oci_fetch($stid))
{
	
$qr_title=oci_result($stid,'NAME');

$qr_catid=oci_result($stid,'CAT_ID');

$qr_block=oci_result($stid,'BLOCK');

$myarray = array($qr_title,$qr_catid,$qr_block);
$serialized = json_encode($myarray);
$data = 'myarray=' . rawurlencode($serialized);

//$qr_csv=oci_result($stid,'APPLI_NO').','.oci_result($stid,'STUDNAME').','.oci_result($stid,'CCTYPE').','.oci_result($stid,'CNAME');
//$qr_csv="http://14.139.188.102/SIS/qrupdate.php?".$data;
//QRcode::png($qr_csv, '../qrcodes/'.$qr_title.'.png');
$qr_csv=oci_result($stid,'NAME');
$qr_csv="http://192.168.0.200/tansi/tranupdate.php?".$data;
//$qr_csv="http://49.204.138.234/tansi/tranupdate.php?".$data;

QRcode::png($qr_csv, '../qrcodes/'.$qr_title.'.png');



?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

</head>
<body  style="margin-left:10px;" >
<div align="center">
<h4 align="center">TAMILNADU STATE COUNCIL FOR HIGHER EDUCATION<BR /> 
   QR CODE FORMS <BR />  </h4>
     <h5> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp  <?php echo $qr_title.'-'.$qr_block;?></h5>
   
   <table border="2">
   <tr>
   <th align="center"><img src="../qrcodes/<?php echo "$qr_title".".png";?>"  alt=""> 
   </th>
   </tr>
   </table>
<?php

echo '<div style="break-after:page"></div>';
}
}
?>
</div>

</body>

</html>