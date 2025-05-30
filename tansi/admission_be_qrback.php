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

$conn=oci_connect("sis","sis","gct");
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}
if($searchq=='')
{
$sqlstr="select
trim(TO_CHAR(TO_DATE(to_char(DOF,'dd'),'J'),'JSP')) ||' '||upper(to_char(dof,'month'))||' '|| trim(TO_CHAR(TO_DATE(to_char(dof,'yyyy'),'J'),'JSP'))  WORDDOF ,
CCTYPE,CNAME,
AADHAR,
EMISNO,
BGROUP,
ORPHA,
DIFFERENTLY,
TYPE_DIFFERENTLY,
DIS_PERCENTAGE,
DISABLILITY_ID,
SPECIAL_CATEGORY,
STUDENT_BNAME,
BANK_NAME,
BANK_BRANCH,
ACC_NO,
IFSC,
QUOT,
LETERAL_ENO,
JOIN_DT,
COUNSELLING_NO,
OKSTATUS,
ROUND,
FEES,
TO_CHAR(RECEIPTDT,'DD/MM/YYYY') RECEIPTDT,
RECEIPTNO,
UGREGNO,
UGUNIVNAME,
PATTERN,
UGBRANCH,
RANK_SCORE,
SEM_MAR1,
SEM_MAR2,
SEM_MAR3,
SEM_MAR4,
SEM_MAR5,
SEM_MAR6,
SEM_MAR7,
SEM_MAR8,
CLASS,
LAST_TCNO,
TO_CHAR(LAST_TCDATE,'DD/MM/YYYY') LAST_TCDATE,
ENTRY_DATE,
LAST_UNIVERSITY,
LAST_PLACE,
ASNO,
BEBRANCH,
ACYEAR,
APPLI_NO,
ROLLNO,
TO_CHAR(ADMISSION_DT,'DD/MM/YYYY') ADMISSION_DT,
STUDNAME,
COURSE_YR,
COURSE_CODE,
MEDI,
FNAME,
FOCCUPATION,
FINCOME,
MNAME,
MOCCUPATION,
MINCOME,
PMTADD1,
PMTADD2,
PMTADD3,
PMTTALUK,
PMTDIST,
PMTSTAT,
PMTPIN,
CURADD1,
CURADD2,
CURADD3,
CURTALUK,
CURSTAT,
CURPIN,
CURDIST,
MOBILE,
PARENT_MOBILE,
to_char(DOF,'dd/mm/yyyy') DOF,
NATY,
RELIGION,
COMMUNITY,
CASTE,
MTONGUE,
GENDER,
F_GRADUATE,
F_GRADUATE_NO,
HOSTELLER,
HOSTEL_TYPE,
QUALIFIY,
LAST_STUDIED,
BOARD,
SCHOOL_TYPE,
MONTH_YR_PASSING,
NO_ATTEMPTS_HSC,
TOTAL_MARKS,
CUTTOFF,
MEDIUM_STUDIES,
BOARD,
SCHOOL_TYPE,
EMAIL,
DECODE(LETERAL_ENO,'II','II','I YEAR')  LETERAL_ENO  
 from sis.tapal a,sis.course b where  ccode=course_code and cctype='B.E.' and rollno between '71772318101' and '71772318200'  ";
}
else
{
	$sqlstr="select
trim(TO_CHAR(TO_DATE(to_char(DOF,'dd'),'J'),'JSP')) ||' '||upper(to_char(dof,'month'))||' '|| trim(TO_CHAR(TO_DATE(to_char(dof,'yyyy'),'J'),'JSP'))  WORDDOF ,
CCTYPE,CNAME,
AADHAR,
EMISNO,
BGROUP,
ORPHA,
DIFFERENTLY,
TYPE_DIFFERENTLY,
DIS_PERCENTAGE,
DISABLILITY_ID,
SPECIAL_CATEGORY,
STUDENT_BNAME,
BANK_NAME,
BANK_BRANCH,
ACC_NO,
IFSC,
QUOT,
LETERAL_ENO,
JOIN_DT,
COUNSELLING_NO,
OKSTATUS,
ROUND,
FEES,
TO_CHAR(RECEIPTDT,'DD/MM/YYYY') RECEIPTDT,
RECEIPTNO,
UGREGNO,
UGUNIVNAME,
PATTERN,
UGBRANCH,
RANK_SCORE,
SEM_MAR1,
SEM_MAR2,
SEM_MAR3,
SEM_MAR4,
SEM_MAR5,
SEM_MAR6,
SEM_MAR7,
SEM_MAR8,
CLASS,
LAST_TCNO,
TO_CHAR(LAST_TCDATE,'DD/MM/YYYY') LAST_TCDATE,
ENTRY_DATE,
LAST_UNIVERSITY,
LAST_PLACE,
ASNO,
BEBRANCH,
ACYEAR,
APPLI_NO,
ROLLNO,
TO_CHAR(ADMISSION_DT,'DD/MM/YYYY') ADMISSION_DT,
STUDNAME,
COURSE_YR,
COURSE_CODE,
MEDI,
FNAME,
FOCCUPATION,
FINCOME,
MNAME,
MOCCUPATION,
MINCOME,
PMTADD1,
PMTADD2,
PMTADD3,
PMTTALUK,
PMTDIST,
PMTSTAT,
PMTPIN,
CURADD1,
CURADD2,
CURADD3,
CURTALUK,
CURSTAT,
CURPIN,
CURDIST,
MOBILE,
PARENT_MOBILE,
to_char(DOF,'dd/mm/yyyy') DOF,
NATY,
RELIGION,
COMMUNITY,
CASTE,
MTONGUE,
GENDER,
F_GRADUATE,
F_GRADUATE_NO,
HOSTELLER,
HOSTEL_TYPE,
QUALIFIY,
LAST_STUDIED,
BOARD,
SCHOOL_TYPE,
MONTH_YR_PASSING,
NO_ATTEMPTS_HSC,
TOTAL_MARKS,
CUTTOFF,
MEDIUM_STUDIES,
BOARD,
SCHOOL_TYPE,
EMAIL,
LETERAL_ENO
 from sis.tapal a,sis.course b where  ccode=course_code and cctype='B.E.'  AND APPLI_NO='$searchq'";

}
$stid=oci_parse($conn,$sqlstr);
oci_execute($stid);



while(oci_fetch($stid))
{
	
$qr_app=oci_result($stid,'APPLI_NO');
$qr_name=oci_result($stid,'STUDNAME');
$qr_prg=oci_result($stid,'COURSE_CODE');
$qr_gender=oci_result($stid,'GENDER');
$qr_dof=oci_result($stid,'DOF');
$qr_community=oci_result($stid,'COMMUNITY');
$qr_fg=oci_result($stid,'F_GRADUATE');
$qr_prgname=oci_result($stid,'CNAME');

$myarray = array($qr_app,$qr_name,$qr_prg,$qr_gender,$qr_dof,$qr_community,$qr_fg,$qr_prgname);
$serialized = json_encode($myarray);
$data = 'myarray=' . rawurlencode($serialized);

//$qr_csv=oci_result($stid,'APPLI_NO').','.oci_result($stid,'STUDNAME').','.oci_result($stid,'CCTYPE').','.oci_result($stid,'CNAME');
$qr_csv="http://14.139.188.102/SIS/qrupdate.php?".$data;
QRcode::png($qr_csv, '../qrcodes/'.$qr_name.'.png');
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admission Register</title>

</head>
<body  style="margin-left:10px;" >

<h4 align="center">GOVERNMENT COLLEGE OF TECHNOLOGY COIMBATORE-641013 <BR /> 
   REGISTER OF ADMISSIONS AND WITHDRAWALS</h4>
<table width="80%">
  <tr>
    <th>Name of the candidate(in block letters) </th>
    <td><?php echo oci_result($stid,'STUDNAME');?></td>
    <th></th>
    <th> </th>
  </tr>
  <tr>
    <th>Roll Number </th>
    <td><?php echo oci_result($stid,'ROLLNO');?></td>
    <th ></th>
    <td align="center" rowspan="7"><img src="../qrcodes/<?php echo "$qr_name".".png";?>"  alt=""></td>
  </tr>
  <tr>
    <th>Admitted on </th>
    <td><?php echo oci_result($stid,'ADMISSION_DT');?></td>
    <td ></td>
  </tr>
  <tr>
    <th>Year & Course Name </th>
    <td><?php  
  if (oci_result($stid,'LETERAL_ENO')=='II') 
  { 
  $let='II ';
  }
  else 
  {$let='I YEAR';} echo $let . ' '. oci_result($stid,'CCTYPE').' '.oci_result($stid,'CNAME'); ?></td>
  <td ></td>
  </tr>
  <tr>
    <th>TNEA REG NO </th>
    <td><?php echo oci_result($stid,'APPLI_NO');?></td>
    <td ></td>
  </tr>
  <tr>
    <th>Receipt number and Date </th>
    <td></td>
    <td ></td>
  </tr>
  <tr>
    <th>Father's Name </th>
    <td><?php echo oci_result($stid,'FNAME');?></td>
    <td ></td>
  </tr>
  <tr>
    <th>AADHAR NO </th>
    <td><?php echo oci_result($stid,'AADHAR');?></td>
    <td></td>
  </tr>
  <tr>
    <th>Parent Mob.</th>
    <td><?php echo oci_result($stid,'PARENT_MOBILE');?></td>
    <td></td>
  </tr>
  <tr>
    <th>Student Mob.</th>
    <td><?php echo oci_result($stid,'MOBILE');?></td>
  </tr>
  <tr>
    <th>Mail Id</th>
    <td><?php echo  oci_result($stid,'EMAIL');?></td>
  </tr>
  <tr>
    <th valign="top">Permanent Address </th>
    <td><div><?php echo oci_result($stid,'PMTADD1');?><br />
      <?php echo oci_result($stid,'PMTADD2'); 
   if(oci_result($stid,'PMTADD2') != ''){echo '<BR />';}    ?> <?php echo oci_result($stid,'PMTADD3');
if(oci_result($stid,'PMTADD3') != ''){echo '<BR />';}  
?> <?php echo oci_result($stid,'PMTTALUK');
if(oci_result($stid,'PMTTALUK') != ''){echo '<BR />';}  

?> <?php echo oci_result($stid,'PMTDIST');
if(oci_result($stid,'PMTDIST') != ''){echo '<BR />';}  

?> <?php echo oci_result($stid,'PMTSTAT');
if(oci_result($stid,'PMTSTAT') != ''){echo '<BR />';}  
?> <?php echo oci_result($stid,'PMTPIN'); ?></div>
      <br /></td>
  </tr>
  <tr>
    <th valign="top" >DOB </th>
    <td valign="top"><?php echo oci_result($stid,'DOF');?> <br />
      <?php echo oci_result($stid,'WORDDOF');?></td>
    <td valign="top"><br /></td>
    <td></td>
  </tr>
  <tr>
    <th>Nationality </th>
    <td><?php echo oci_result($stid,'NATY');   ?></td>
    <th colspan="2" >&nbsp;</th>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <th>Quota </th>
    <td><?php echo oci_result($stid,'QUOT');   ?></td>
  </tr>
  <tr>
    <th>Name of the State </th>
    <td><?php echo oci_result($stid,'PMTSTAT');   ?></td>
  </tr>
  <tr>
    <th>Mother Tongue </th>
    <td><?php echo oci_result($stid,'MTONGUE');   ?></td>
    <th colspan="2" >COURSE COMPLETED / DISCONTINUED</th>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <th>Religion </th>
    <td><?php echo oci_result($stid,'RELIGION');   ?></td>
    <th colspan="2" >&nbsp;</th>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <th>Community </th>
    <td><?php echo oci_result($stid,'COMMUNITY');   ?></td>
    <td></td>
  </tr>
  <tr>
    <th>Caste</th>
    <td><?php echo oci_result($stid,'CASTE');   ?></td>
    <th colspan="2" style=" font-weight:300:" >NO AND DATE OF TRANSFER CERTIFICATE MADE</th>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <th>GENDER </th>
    <td><?php echo oci_result($stid,'GENDER');   ?></td>
  </tr>
    <th>Dayscholar/Hosteller </th>
    <td><?php echo oci_result($stid,'HOSTELLER');   ?></td>
  </tr>
    <th>FG/NFG </th>
    <td><?php echo oci_result($stid,'F_GRADUATE');   ?></td>
    <th colspan="2"  style="font-weight:bold"; >PA TO PRINCIPAL</th>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
</table>
<div style="break-after:page"></div>
<?php
}
?>
</body>

</html>