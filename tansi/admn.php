<?php
//include "sisindex.php";
?>

<script type="text/javascript" src="jquery.js"></script> 
<script type='text/javascript' src='jquery.autocomplete.js'></script>
<html>
<link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" />
<style>
input[type="date"]:before{
    color:#666;
    content:attr(placeholder);
}
.form-style-9{
    max-width: 1000px;
    background: #FAFAFA;
    padding: 30px;
    margin: 50px auto;
    box-shadow: 1px 1px 25px rgba(0, 0, 0, 0.35);
    border-radius: 10px;
    border: 6px solid #305A72;
}
.form-style-9 ul{
    padding:0;
    margin:0;
    list-style:none;
}
.form-style-9 ul li{
    display: block;
    margin-bottom: 10px;
    min-height: 24px;
}
.form-style-9 ul li  .field-style{
    box-sizing: border-box; 
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box; 
    padding: 8px;
    outline: none;
    border: 1px solid #B0CFE0;
    -webkit-transition: all 0.30s ease-in-out;
    -moz-transition: all 0.30s ease-in-out;
    -ms-transition: all 0.30s ease-in-out;
    -o-transition: all 0.30s ease-in-out;

}.form-style-9 ul li  .field-style:focus{
    box-shadow: 0 0 5px #B0CFE0;
    border:1px solid #B0CFE0;
}
.form-style-9 ul li .field-split{
    width: 49%;
}
.form-style-9 ul li .field-full{
    width: 100%;
}
.form-style-9 ul li input.align-left{
    float:left;
}
.form-style-9 ul li input.align-right{
    float:right;
}

.form-style-9 ul li select.align-left{
    float:left;
}

.form-style-9 ul li select.align-right{
    float:right;
}

.form-style-9 ul li textarea{
    width: 100%;
    height: 100px;
}
.form-style-9 ul li input[type="button"], 
.form-style-9 ul li input[type="submit"] {
    -moz-box-shadow: inset 0px 1px 0px 0px #3985B1;
    -webkit-box-shadow: inset 0px 1px 0px 0px #3985B1;
    box-shadow: inset 0px 1px 0px 0px #3985B1;
    background-color: #216288;
    border: 1px solid #17445E;
    display: inline-block;
    cursor: pointer;
    color: #FFFFFF;
    padding: 8px 18px;
    text-decoration: none;
    font: 12px Arial, Helvetica, sans-serif;
}
.form-style-9 ul li input[type="button"]:hover, 
.form-style-9 ul li input[type="submit"]:hover {
    background: linear-gradient(to bottom, #2D77A2 5%, #337DA8 100%);
    background-color: #28739E;
}
</style>
<script>
function validate()
{
feecal();
document.getElementById("feefrm1").submit();

	return true;
}
function val()
{
feecal();
 
    return true;    // in success case
}
	
	function feecal()
{
 var comm;
 var hos;
 var fg;
 var quto;
 var fees=11980;
 var less1=0;
 var add1=0;
 var add2=0;
 
	comm=document.getElementById("COMMUNITY").value;
	hos= document.getElementById("HOSTELLER").value;
	fg=document.getElementById("F_GRADUATE").value;
	quto=document.getElementById("QUOT").value;
	oth=document.getElementById("OTHSTAT").value;
if(quto=='PH')
{
	less1=3500;
	
}
else if (quto=='JK')
{
	less1=10980;
}
else
{	
	
if (fg=='Yes' || comm=='SC' || comm=='SCA'|| comm=='ST')
{	
less1=2000;	
}
}

if(hos=='Hosteller')
{
	add1=450;
	
	}



if(oth=='Yes')
{
	add2=600;
	
	}



fees=fees+add1+add2-less1;
if(quto=='7.5%')
{
	fees=0;
	
}



document.getElementById("FEES").value=fees;
}
function pyr()
{
document.getElementById("MONTH_YR_PASSING").value=document.getElementById("PMON").value + '-'+
document.getElementById("PYR").value;

}
	
	 
function cast()
{
 $.ajax({
        url: 'caste.php',
        type: 'post',
        data: { "type": document.getElementById("COMMUNITY").value},
        success: function(data1) {
			$("#castlist").html(data1);
   	
  

			  }
    });	

}
	 
	 
function curpinval()
{
	

	$.ajax
({
    type: "POST",
    url: "enrol_val.php",	
	data :{pin:document.getElementById("CURPIN").value},
    dataType: 'json',
    cache: false,

    success: function(data)
    {

		document.getElementById("CURSTAT").value=data.stat;
		document.getElementById("CURDIST").value=data.district;
		document.getElementById("CURTALUK").value=data.taluk;
    }
		
}

);


}
	 

function pinval()
{
	

	$.ajax
({
    type: "POST",
    url: "enrol_val.php",	
	data :{pin:document.getElementById("PMTPIN").value},
    dataType: 'json',
    cache: false,

    success: function(data)
    {

		document.getElementById("PMTSTAT").value=data.stat;
		document.getElementById("PMTDIST").value=data.district;
		document.getElementById("PMTTALUK").value=data.taluk;
    }
		
}

);


}


function tplret()
{
	

	$.ajax
({
    type: "POST",
    url: "tpl_ret.php",	
	data :{appno:document.getElementById("APPLI_NO").value},
    dataType: 'json',
    cache: false,

    success: function(data)
    {
       
	   if (data.quto=='MBC & DNC')
	   {
		document.getElementById("QUOT").value="MBC/DNC"; 
				   
	   }
	   else
	   {
		document.getElementById("QUOT").value=data.community; 
		
	   }
	   document.getElementById("COMMUNITY").value=data.community;
		document.getElementById("STUDNAME").value=data.stname;
		document.getElementById("EMAIL").value=data.email;
		document.getElementById("MOBILE").value=data.mobile;
		document.getElementById("COURSE_CODE").value=data.ccode;
		document.getElementById("F_GRADUATE").value=data.fg;
		document.getElementById("GENDER").value=data.gender;
		
		document.getElementById("DOF").value=data.dob;
		document.getElementById("PMTDIST").value=data.district;
		document.getElementById("PMTPIN").value=data.pincode;
		pinval();
		document.getElementById("AADHAR").value=data.aadhar;
		
		document.getElementById("QUALIFIY").value=data.qual;
		document.getElementById("PYR").value=data.qualyr;
		document.getElementById("EMISNO").value=data.emsisno;
		document.getElementById("TOTAL_MARKS").value=data.hscmark;
		document.getElementById("FOCCUPATION").value=data.foccup;
		document.getElementById("FINCOME").value=data.fincome;
		document.getElementById("CUTTOFF").value=data.ggrmark;
		document.getElementById("MEDIUM_STUDIES").value=data.medium;
		document.getElementById("MTONGUE").value=data.mtong;
		document.getElementById("RELIGION").value=data.religion;
		feecal();
		cast();
		
    }
		
}

);


}


$(document).ready(function(){
    $('input').keyup(function(){
        if($(this).val().length==$(this).attr("maxlength")){
			$(this).attr("maxlength")
            //$(this).next().focus();
			
        }
    });
});

$(function(){
    $('#ccoode').change(function(){
	var x=document.getElementById("prglist");
	var txt="";
	var i;
	var str1;

	
	for(i=0;i<x.options.length;i++) {
 	str1=x.options[i].value;

	if(document.getElementById("ccoode").value==str1.substring(0,3))
	{

	document.getElementById("ccoode").value=str1;
	}
	//txt=txt+x.options[i].value+ "<br>";
	
	
		
	}
 //document.getElementById("prgdatalist").innerHTML=txt;
    });
});



function myFunction() {
  var checkBox = document.getElementById("myCheck");
  var text = document.getElementById("text");
  if (checkBox.checked == true){
document.getElementById('CURADD1').value=document.getElementById('PMTADD1').value
document.getElementById('CURADD2').value=document.getElementById('PMTADD2').value
document.getElementById('CURADD3').value=document.getElementById('PMTADD3').value
document.getElementById('CURTALUK').value=document.getElementById('PMTTALUK').value
document.getElementById('CURDIST').value=document.getElementById('PMTDIST').value
document.getElementById('CURSTAT').value=document.getElementById('PMTSTAT').value
document.getElementById('CURPIN').value=document.getElementById('PMTPIN').value
   
   

  } else {
   document.getElementById('CURADD1').value='';
  }
}


document.getElementById("APPLI_NO").focus();

</script>



<body>



<?php
include ("oraconn.php");
//include ("orayear.php");
//$prgcat=$_POST['userid']='IT';
$moumode=$_POST['moumode']='TIE';
//$merchantid=$_POST['opt'];
//echo $merchantid;
//$merchantid=$_POST['pwd']=6813;
$college=$_POST['college']="";
//$feeshead=$_POST['feesheads']='0402';
//$acyear="2018-2019";
//$acyear=$academic='2019-2020';
//$fullname =$_POST['fullname']='6813 - CSN System Private Limited';
//$fullname =$_POST['fullname']='6805 - Amaze Educational Consultancy India Private Limited';
$prglist=oci_parse($conn,
"select ccode,cname from sis.course WHERE CCTYPE  ='B.E.' AND PRGTIME='FULL' order by 1");
oci_execute($prglist);
while(oci_fetch($prglist))
{
$prgarr[]= oci_result($prglist, 'CCODE').'-'.oci_result($prglist, 'CNAME');

}


//$conn=oci_connect("webdde","webphp","ORDDE");
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}


if (isset($_POST['APPLI_NO']) )
{
$sql="insert into sis.tapal (
  ACYEAR,
  ADMISSION_DT,
  QUOT,
  FEES,
  ROUND,
  RECEIPTNO,
  RECEIPTDT,
  MEDI,
  LAST_TCNO,
  HOSTEL_TYPE,
  ROLLNO,
  APPLI_NO,
  STUDNAME,
  COURSE_YR,
  COURSE_CODE,
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
  CURDIST,
  CURSTAT,
  CURPIN,
  MOBILE,
  PARENT_MOBILE,
  DOF ,
  NATY,
  RELIGION,
  COMMUNITY,
  CASTE,
  MTONGUE,
  GENDER,
  LAST_TCDATE,
  F_GRADUATE,
  F_GRADUATE_NO,
  HOSTELLER,
  QUALIFIY,
  LAST_STUDIED,
  LAST_PLACE,
  CLASS,
  BOARD,
  SCHOOL_TYPE,
  MONTH_YR_PASSING ,
  NO_ATTEMPTS_HSC, 
  TOTAL_MARKS,
  CUTTOFF, 
  MEDIUM_STUDIES,
  EMAIL,
  AADHAR,
  ENTRY_DATE,
  EMISNO,
  LETERAL_ENO,
  OTHSTAT
  )
  values(
  :ACYEAR,   
  :ADMISSION_DT,
  :QUOT,
  :FEES,
  :ROUND,
  :RECEIPTNO,
  :RECEIPTDT,
  :MEDI,
  :LAST_TCNO,
  :HOSTEL_TYPE,
  :ROLLNO,
  :APPLI_NO,
  :STUDNAME,
  :COURSE_YR,
  :COURSE_CODE,
  :FNAME,
  :FOCCUPATION,
  :FINCOME,
  :MNAME,
  :MOCCUPATION,
  :MINCOME,
  :PMTADD1,
  :PMTADD2,
  :PMTADD3,
  :PMTTALUK,
  :PMTDIST,
  :PMTSTAT,
  :PMTPIN,
  :CURADD1,
  :CURADD2,
  :CURADD3,
  :CURTALUK,
  :CURDIST,
  :CURSTAT,
  :CURPIN,
  :MOBILE,
  :PARENT_MOBILE,  
  :DOF,
  :NATY,
  :RELIGION,
  :COMMUNITY,
  :CASTE,
  :MTONGUE,
  :GENDER,
  :LAST_TCDATE,
  :F_GRADUATE,
  :F_GRADUATE_NO,
  :HOSTELLER,
  :QUALIFIY,
  :LAST_STUDIED,
  :LAST_PLACE,
  :CLASS,
  :BOARD,
  :SCHOOL_TYPE,
  :MONTH_YR_PASSING ,
  :NO_ATTEMPTS_HSC, 
  :TOTAL_MARKS,
  :CUTTOFF, 
  :MEDIUM_STUDIES,
  :EMAIL,
  :AADHAR,
   SYSDATE,
  :EMISNO,
  :LETERAL_ENO,
  :OTHSTAT
   )";
  
$ins_enrol =oci_parse($conn,$sql) ;

$acyear='2023-2024';
  @oci_bind_by_name($ins_enrol,':ACYEAR',$acyear);
  
 @$dt1=date('d-M-Y', strtotime($_POST['ADMISSION_DT']));
 
 @ oci_bind_by_name($ins_enrol,':ADMISSION_DT',$dt1);
   oci_bind_by_name($ins_enrol,':APPLI_NO',$_POST['APPLI_NO']);       
   oci_bind_by_name($ins_enrol,':ROUND',$_POST['ROUND']);       
   oci_bind_by_name($ins_enrol,':ROLLNO',$_POST['ROLLNO']);       
  @oci_bind_by_name($ins_enrol,':STUDNAME',strtoupper($_POST['STUDNAME']));
  @oci_bind_by_name($ins_enrol,':COURSE_YR',$_POST['COURSE_YR']);
  @oci_bind_by_name($ins_enrol,':QUOT',$_POST['QUOT']);
  @oci_bind_by_name($ins_enrol,':FEES',$_POST['FEES']);
  @oci_bind_by_name($ins_enrol,':RECEIPTNO',$_POST['RECEIPTNO']);
  @ $dt1=date('d-M-Y', strtotime($_POST['RECEIPTDT']));
  @oci_bind_by_name($ins_enrol,':RECEIPTDT',$dt1);
  

  @oci_bind_by_name($ins_enrol,':COURSE_CODE',substr($_POST['COURSE_CODE'],0,3));
  
  
    @oci_bind_by_name($ins_enrol,':MEDI',$_POST['MEDI']);
  @oci_bind_by_name($ins_enrol,':FNAME',strtoupper($_POST['FNAME']));
  @oci_bind_by_name($ins_enrol,':FOCCUPATION',strtoupper($_POST['FOCCUPATION']));
  @oci_bind_by_name($ins_enrol,':FINCOME',$_POST['FINCOME']);
  @oci_bind_by_name($ins_enrol,':MNAME',strtoupper($_POST['MNAME']));
  @oci_bind_by_name($ins_enrol,':MOCCUPATION',strtoupper($_POST['MOCCUPATION']));
  @oci_bind_by_name($ins_enrol,':MINCOME',$_POST['MINCOME']);
  @oci_bind_by_name($ins_enrol,':PMTADD1',strtoupper($_POST['PMTADD1']));
  @oci_bind_by_name($ins_enrol,':PMTADD2',strtoupper($_POST['PMTADD2']));
  @oci_bind_by_name($ins_enrol,':PMTADD3',strtoupper($_POST['PMTADD3']));
  @oci_bind_by_name($ins_enrol,':PMTTALUK',strtoupper($_POST['PMTTALUK']));
  @oci_bind_by_name($ins_enrol,':PMTDIST',$_POST['PMTDIST']);
  @oci_bind_by_name($ins_enrol,':PMTSTAT',strtoupper($_POST['PMTSTAT']));
  @oci_bind_by_name($ins_enrol,':PMTPIN',$_POST['PMTPIN']);
  @oci_bind_by_name($ins_enrol,':CURADD1',strtoupper($_POST['CURADD1']));
  @oci_bind_by_name($ins_enrol,':CURADD2',strtoupper($_POST['CURADD2']));
  @oci_bind_by_name($ins_enrol,':CURADD3',strtoupper($_POST['CURADD3']));
  @oci_bind_by_name($ins_enrol,':CURTALUK',strtoupper($_POST['CURTALUK']));
  @oci_bind_by_name($ins_enrol,':CURDIST',strtoupper($_POST['CURDIST']));
  @oci_bind_by_name($ins_enrol,':CURSTAT',strtoupper($_POST['CURSTAT']));
  @oci_bind_by_name($ins_enrol,':CURPIN',$_POST['CURPIN']);
  @oci_bind_by_name($ins_enrol,':MOBILE',$_POST['MOBILE']);
  @oci_bind_by_name($ins_enrol,':PARENT_MOBILE',$_POST['PARENT_MOBILE']);
  $dt=date('d-M-Y', strtotime($_POST['DOF']));
    oci_bind_by_name($ins_enrol,':DOF' ,$dt);
  @oci_bind_by_name($ins_enrol,':NATY',$_POST['NATY']);
  @oci_bind_by_name($ins_enrol,':RELIGION',$_POST['RELIGION']);
  @oci_bind_by_name($ins_enrol,':COMMUNITY',$_POST['COMMUNITY']);
  @oci_bind_by_name($ins_enrol,':CASTE',strtoupper($_POST['CASTE']));
  @oci_bind_by_name($ins_enrol,':MTONGUE',$_POST['MTONGUE']);
  @oci_bind_by_name($ins_enrol,':GENDER',$_POST['GENDER']);
   @oci_bind_by_name($ins_enrol,':LAST_TCNO',$_POST['LAST_TCNO']);
   $dts=date('d-M-Y', strtotime($_POST['LAST_TCDATE']));
  @oci_bind_by_name($ins_enrol,':LAST_TCDATE',$dts);
  @oci_bind_by_name($ins_enrol,':F_GRADUATE',$_POST['F_GRADUATE']);
  @oci_bind_by_name($ins_enrol,':F_GRADUATE_NO',$_POST['F_GRADUATE_NO']);
  @oci_bind_by_name($ins_enrol,':HOSTELLER',strtoupper($_POST['HOSTELLER']));
  @oci_bind_by_name($ins_enrol,':HOSTEL_TYPE',$_POST['HOSTEL_TYPE']);
  @oci_bind_by_name($ins_enrol,':QUALIFIY',$_POST['QUALIFIY']);
  @oci_bind_by_name($ins_enrol,':LAST_STUDIED',strtoupper($_POST['LAST_STUDIED']));
  @oci_bind_by_name($ins_enrol,':LAST_PLACE',strtoupper($_POST['LAST_PLACE']));
    @oci_bind_by_name($ins_enrol,':CLASS',strtoupper($_POST['CLASS']));
  @oci_bind_by_name($ins_enrol,':BOARD',$_POST['BOARD']);
  @oci_bind_by_name($ins_enrol,':SCHOOL_TYPE',$_POST['SCHOOL_TYPE']);
  @oci_bind_by_name($ins_enrol,':MONTH_YR_PASSING' ,strtoupper($_POST['MONTH_YR_PASSING']));
   @oci_bind_by_name($ins_enrol,':NO_ATTEMPTS_HSC', $_POST['NO_ATTEMPTS_HSC']);
  @oci_bind_by_name($ins_enrol,':TOTAL_MARKS',$_POST['TOTAL_MARKS']);
  @oci_bind_by_name($ins_enrol,':CUTTOFF', $_POST['CUTTOFF']);
 @oci_bind_by_name($ins_enrol,':MEDIUM_STUDIES',strtoupper($_POST['MEDIUM_STUDIES']));
   @oci_bind_by_name($ins_enrol,':EMAIL',$_POST['EMAIL']);
    @oci_bind_by_name($ins_enrol,':AADHAR',$_POST['AADHAR']);
  @oci_bind_by_name($ins_enrol,':EMISNO',$_POST['EMISNO']);
  @oci_bind_by_name($ins_enrol,':LETERAL_ENO',$_POST['LETERAL_ENO']);
  @oci_bind_by_name($ins_enrol,':OTHSTAT',$_POST['OTHSTAT']);
  
  
oci_execute($ins_enrol,OCI_DEFAULT);
oci_commit($conn);
echo '<label style="font-size:35"   > Update Successfully </label>';
die();
 

}


?>

<form    class="form-style-9" id="feefrm1" onSubmit="return validate();" method="post" autocomplete="off">

<h1 style="font-size:18px; font-weight:bold">Admission Entry B.E   </h1>

<table  border="1">
<tr>

<td width="330"><input   type="date" tabindex="" 
   placeholder="Admission Date:-"  id="ADMISSION_DT"   name="ADMISSION_DT" maxlength="60" size="30" value="<?PHP echo date('Y-m-d'); ?>" > 
   </td>
<td width="276"><input hidden style="width:60%" tabindex=""
 type="text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"   min="11"  max="11"  maxlength="11" placeholder="Roll Number" id="ROLLNO" name="ROLLNO"  ></td>
<td width="4">&nbsp;</td>
<td width="271"><select onChange="feecal();" class="field-style field-split align-right" tabindex="40" id="HOSTELLER" name="HOSTELLER"  >
  <option selected disabled > Select Hosteller </option>
  <option > Hosteller </option>
  <option > Dayscholar </option>
</select></td>
</tr>
 
  <tr>
    <td><input style="width:30%" tabindex="2"
 type="text"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"   min="4"  max="15"  maxlength="15" placeholder="Application Number" id="APPLI_NO" name="APPLI_NO" onBlur="tplret();"  >
 <select  tabindex="3" id="ROUND" name="ROUND"   >
  <option  value="I" > I </option>
 <option value="I-Up" > I-Up </option>
 <option selected  value="II" > II </option>
 <option value="II-Up" >II-Up</option>
 <option value="III" > III </option>
 <option value="III-Up" >III-Up</option>
 <option value="IV" > IV </option>
 <option value="IV-Up" >IV-Up</option>
  </select>
  
      <select onChange="feecal();"  tabindex="3"  name="QUOT" id="QUOT">
       <option selected disabled > Eligible for </option>
        <option value="OC">OC</option>
        <option value="BC">BC</option>
        <option value="MBC/DNC">MBC/DNC</option>
        <option value="SC">SC</option>
        <option value="SCA">SCA</option>
        <option value="ST">ST</option>
        <option value="SPORTS">Sports</option>
        <option value="EX-SERVICE">EX-Service Man</option>
        <option value="PH">PH</option>
        <option value="7.5%">7.5%</option>
        <option value="GOI">GOI</option>
        <option value="JK">JK</option>
        <option value="BCM">BCM</option>
        <option value="FG">FG  </option>
        <option value="PMMS">PMMS </option>
        <option value="OBC">OBC </option>
        
      </select></td>
    <td>
    <input hidden   style="width:50%" placeholder="fees"  tabindex="4"  name="FEES"  max="7" size="7"
    id="FEES"   >
      <input hidden style="width:50%" placeholder="Receipt No:"  tabindex="5"  name="RECEIPTNO"  max="12" size="12"
    id="RECEIPTNO"   >
<input hidden type="date" tabindex="6" 
   placeholder="Receipt Date:-"  id="RECEIPTDT"   name="RECEIPTDT" maxlength="60" size="30"  value="<?PHP echo date('Y-m-d'); ?>"
    >    
    
    </td>
   
   
    <td>&nbsp;</td>
    <td><select  class="field-style field-split align-right" tabindex="41" id="QUALIFIY" name="QUALIFIY"  >
      <option selected disabled > Select HSC/Diploma(Laterl Entry) </option>
      <option > HSC </option>
      <option > Diploma </option>
    </select>
   <input  tabindex="42" placeholder="TC NO."  id="LAST_TCNO"   
  name="LAST_TCNO" maxlength="30" size="30"  >
  <input type="date" tabindex="43" 
   placeholder="TC Date:-"  id="LAST_TCDATE"   name="LAST_TCDATE" maxlength="60" size="30" >
    </td>
    </tr>
  <tr>
    <td colspan="3"> <input   tabindex="6" placeholder="Student Name"  id="STUDNAME" style="text-transform:uppercase; width:100% "  
  name="STUDNAME" maxlength="60" size="30" >
    </td>
    <td><input style="text-transform:uppercase;" tabindex="44" placeholder="Name of the School /College last studied"  id="LAST_STUDIED"   
  name="LAST_STUDIED" maxlength="150" size="30" >
  <input   style="text-transform:uppercase;"  tabindex="45" placeholder="PLACE"  id="LAST_PLACE"   
  name="LAST_PLACE" maxlength="100" size="30" >
  <input   style="text-transform:uppercase;"  tabindex="46" placeholder="CLASS"  id="CLASS"   
  name="CLASS" maxlength="100" size="30" >
  
  </td>
    <td width="4">&nbsp;</td>
     <td width="4">&nbsp;</td>
  </tr>
  <tr>
  
  
    <td colspan="3"><input  type="date" tabindex="7" placeholder="Date of Birth:-"  id="DOF"   
  name="DOF" maxlength="60" size="30" >
      <select  tabindex="8" id="GENDER" name="GENDER"  >
        <option selected disabled > Select Gender </option>
        <option value="MALE" > Male </option>
        <option value="FEMALE" > Female </option>
      </select>
      <select  tabindex="8" id="LETERAL_ENO" name="LETERAL_ENO"  >
        
        
        <option selected  value="" > Regular </option>
 <option value="II" > IIyr Leteral </option>
 <option value="III Trans" > Trans.III SEM </option>
 <option value="V Trans" > Trans.V SEM </option>
 <option value="VII Trans" > Trans.VII SEM </option>
   
 </select>
  
    <td><select   tabindex="48" id="SCHOOL_TYPE" name="SCHOOL_TYPE"  >
 <option selected > Government </option>
 <option > Aided </option>
 <option > Private </option>
 </select></td>
    <td>&nbsp;</td>
     <td>&nbsp;</td>
  </tr>
   <tr>
    <td colspan="3">  <input required style="width:100%" placeholder="Select Programme "  list="prglist"  
      tabindex="9"  name="COURSE_CODE" id="COURSE_CODE"   >  
      
      <?php	
 foreach( $prgarr as $p ){   
 ?>
      <datalist tabindex="10" id="prglist">
        
        foreach( $prgarr as $p ){ 
        
        <select    name="prlist" id ="prg"  >
<option  data-id="<?php echo substr($p,1,strpos($p,'-'));?> " value="<?php echo $p;?>" > </option>
          </select>
        <?php
 }

 ?>
        </datalist>
</td>
    <td>
<select   tabindex="47" id="BOARD" name="BOARD"  >
  <option selected disabled > Select Board </option>
  <option > State Board </option>
  <option > CBSE </option>
  <option > ICSE </option>
</select>
 <BR>
 <select  onChange="pyr();"   tabindex="49" id="PMON" name="PMON"  >
  <option selected disabled >Month</option>
  <option > JAN </option>
  <option > FEB </option>
  <option > MAR </option>
  <option > APR </option>
  <option > MAY </option>
  <option > JUN </option>
  <option > JUL </option>
  <option > AUG </option>
  <option > SEP </option>
  <option > OCT </option>
  <option > NOV </option>
  <option > DEC </option>   
</select>

<select onChange="pyr();"   tabindex="49" id="PYR" name="PYR"  >
   <option selected disabled >Year </option>
    <option > 2021 </option>
  <option > 2022 </option>
  <option > 2023</option>
  <option > 2024</option>
</select>
 Passing in HSC/Diploma 
</td>
    <td></td>
     <td>&nbsp;</td>
  </tr>
  <tr>
  <td><input   width="60%" tabindex="11" placeholder="Nationality"  id="NATY"  value="INDIAN"  
  name="NATY" maxlength="60" size="30" ></td>
  <td><select  tabindex="12" id="RELIGION" name="RELIGION"  >
    <option selected disabled > Select Religion </option>
    <option value="HINDHU" > Hindhu </option>
    <option value="MUSLIM" > Muslim </option>
    <option value="CHRISTIAN" > Christian </option>
    <option value="JAIN" >Jain</option>
  </select></td>
  <td rowspan="10"> </td>
  <td><select  tabindex="50" id="NO_ATTEMPTS_HSC" name="NO_ATTEMPTS_HSC"  >
    <option selected disabled > Select No Attemts Hsc </option>
    <option value="1" > 1 </option>
    <option value="2" > 2 </option>
    <option value="3" > 3 </option>
    <option value="4"> 4 </option>
  </select></td>
  </tr>
   
   <tr>
  <td><select onChange="cast();feecal();"  tabindex="13" id="COMMUNITY" name="COMMUNITY"   >
    <option selected disabled > Select Community </option>
    <option > OC </option>
    <option > BC </option>
    <option > BCM </option>
    <option > MBC </option>
    <option > DNC </option>
    <option > SC </option>
    <option > ST </option>
    <option > SCA </option>
    <option > OBC </option>
    
  </select></td>
  <td>
  <input  list="castlist"   tabindex="14" id="CASTE" name="CASTE" autocomplete="off"  >
  Caste
    <datalist id="castlist">
   
    <option selected>Select cast...</option>
</datalist>

</td>
  <td><input tabindex="51" placeholder="Total Marks in HSC/Diploma"  id="TOTAL_MARKS"   
  name="TOTAL_MARKS" maxlength="60" size="30"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required ></td>
   </tr>
   
   <tr>
  <td><select  tabindex="15" id="MTONGUE" name="MTONGUE"  >
    <option selected disabled > Select Mother Tongue </option>
    <option value="TAMIL" > Tamil </option>
    <option value="ENGLISH" > English </option>
    <option value="TELUGU" > Telugu </option>
    <option value="MALAYALAM" > Malayalam </option>
    <option value="URDU" > Urdu </option>
    <option value="KANNADA" > Kannada </option>
    <option value="HINDI" > Hindi </option>
    <option value="GUJARATI" > Gujarati </option>
    <option value="OTHERS" > Others </option>
  </select></td>
  <td><input tabindex="16" placeholder="Student Mobile No."  id="MOBILE"   
 name="MOBILE"  type="text" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" ></td>
  <td><input tabindex="52" placeholder="Cuttoff (+2)"  id="CUTTOFF"   
  name="CUTTOFF"  type="text" maxlength="6"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required  ></td>
   </tr>
   <tr>
  <td><input  tabindex="17" placeholder="Father Name"  id="FNAME" style="text-transform:uppercase; width:100%"  
  name="FNAME" maxlength="40" size="30" required ></td>
  <td><input  tabindex="20" placeholder="Mother Name"  id="MNAME" style="text-transform:uppercase; width:100% "  
  name="MNAME" maxlength="40" size="30" ></td>
  <td><select   tabindex="53" id="MEDIUM_STUDIES" name="MEDIUM_STUDIES"  >
    <option selected disabled > Select Medium of stuies in HSC/Diploma </option>
    
    <option value="TAMIL" > Tamil </option>
    <option value="ENGLISH" > English </option>
  </select></td>
   </tr>
   <tr>
  <td><input tabindex="18" placeholder="Father Occupation"  id="FOCCUPATION" style="text-transform:uppercase; width:100% "  
  name="FOCCUPATION" maxlength="40" size="30" ></td>
  <td><input  tabindex="21" placeholder="Mother Occupation"  id="MOCCUPATION" style="text-transform:uppercase; width:100%"  
  name="MOCCUPATION" maxlength="40" size="30" ></td>
  <td><input tabindex="54" placeholder="Student EMAIL id"  id="EMAIL"   
  name="EMAIL" maxlength="50" size="50" style="text-transform:lowercase; width:100% "  ></td>
   </tr>
   <tr>
  <td><input  tabindex="19" placeholder="Father Annual Income"  id="FINCOME"   
  name="FINCOME" type="text" maxlength="7"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" ></td>
  <td><input  tabindex="22" placeholder="Mother Annual Income"  id="MINCOME"   
  name="MINCOME"  maxlength="7"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  ></td>
  <td><input class="field-style field-split align-right" tabindex="55" placeholder="Aadhaar No"  id="AADHAR"   
  name="AADHAR"  type="text" maxlength="12"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required ></td>
   </tr>
  
  <tr>
  <td><input  tabindex="23" placeholder="Parent Mobile No."  id="PARENT_MOBILE"   
  name="PARENT_MOBILE" type="text" maxlength="10"   size="10"  autocomplete="on"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  ></td>
  <td>&nbsp;</td>
  <td><input class="field-style field-split align-right" tabindex="56" placeholder="Emis No"  id="EMISNO"   
  name="EMISNO" maxlength="60" size="30" required >
  OtherState
  <select  onChange="feecal();" tabindex="47" id="OTHSTAT" name="OTHSTAT"  >
     <option selected > No  </option>
  <option > Yes </option>
  
</select>
  </td>
  
  
  </tr>
 
 
  
 
   <tr>
    <td><select  class="field-style field-split align-right" tabindex="24" id="F_GRADUATE" name="F_GRADUATE"  >
      <option selected disabled > Select First Graduate </option>
      <option > Yes </option>
      <option > No </option>
    </select> First Graduate</td>
    <td><input class="field-style field-split align-right" tabindex="25" placeholder="First Graduate No."  id="F_GRADUATE_NO"   
  name="F_GRADUATE_NO" maxlength="20" size="30" ></td>
    <td  align="center"><input style="background-color:#0F0" class="align-centre" type="submit" value="Save"></td>
    </tr>
   <tr>
    <td ><input  tabindex="26" placeholder="Present Address No/Street"  id="PMTADD1"   
  name="PMTADD1" maxlength="50" size="30"  style="text-transform:uppercase; width:100%"  ></td>
    <td> <input type="checkbox" id="myCheck" onClick="myFunction()" >Same<input  tabindex="33" placeholder="Current Address No / Street."  id="CURADD1"   
  name="CURADD1" maxlength="50" size="30"  style="text-transform:uppercase; width:100%"  ></td>
    </tr>
   <tr>
    <td ><input  tabindex="27" placeholder="Present Address Line2 "  id="PMTADD2"   
  name="PMTADD2" maxlength="50" size="30" style="text-transform:uppercase; width:100%" ></td>
    <td><input  tabindex="34" placeholder="Current Address Line2"  id="CURADD2"   
  name="CURADD2" maxlength="50" size="30" style="text-transform:uppercase; width:100%" ></td>
    </tr>
   <tr>
    <td ><input   tabindex="28" placeholder="Present Address Line3"  id="PMTADD3"   
  name="PMTADD3" maxlength="50" size="30"  style="text-transform:uppercase; width:100%"  ></td>
    <td><input  tabindex="35" placeholder="Current Address Line3"  id="CURADD3"   
  name="CURADD3" maxlength="50" size="30" style="text-transform:uppercase; width:100%" ></td>
    <td>&nbsp;</td>
     <td>&nbsp;</td>
  </tr>
 
  <tr>
  <td><input  tabindex="29" onBlur="pinval();" placeholder="Present PINCODE"  id="PMTPIN"   
  name="PMTPIN"  type="text"  maxlength="6"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="text-transform:uppercase; width:100%"  ></td>
  <td><input  tabindex="36" onBlur="curpinval();" placeholder="PINCODE"  id="CURPIN"   
  name="CURPIN"  type="text"  maxlength="6"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" style="text-transform:uppercase; width:100%"  ></td>
    <td>&nbsp;</td>
     <td>&nbsp;</td>
  </tr>
  <tr>
  <td ><input tabindex="30" placeholder="Present Taluk"  id="PMTTALUK"   
  name="PMTTALUK" maxlength="50" size="30" style="text-transform:uppercase; width:100%"></td>
  <td><input tabindex="37" placeholder="Taluk"  id="CURTALUK"     name="CURTALUK" maxlength="50" size="30" style="text-transform:uppercase; width:100%"></td>
    <td>&nbsp;</td>
     <td>&nbsp;</td>
  </tr>
  <tr>
  <td  ><input  tabindex="31" placeholder="Present District"  id="PMTDIST"   
  name="PMTDIST" maxlength="50" size="30" style="text-transform:uppercase; width:100%" ></td>
  <td><input  tabindex="38" placeholder="District"  id="CURDIST"   
  name="CURDIST" maxlength="50" size="30" style="text-transform:uppercase; width:100%" ></td>
    <td>&nbsp;</td>
     <td>&nbsp;</td>
  </tr>
  <tr>
    <td ><input  tabindex="32" placeholder="Present State"  id="PMTSTAT"   
  name="PMTSTAT" maxlength="50" size="30" style="text-transform:uppercase; width:100%"  ></td>
    <td><input  tabindex="39" placeholder="State"  id="CURSTAT"   
  name="CURSTAT" maxlength="50" size="30" style="text-transform:uppercase; width:100%"  ></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>
 

 
  <tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
    <td>&nbsp;</td>
     <td>  </td>
  </tr>
  
  <tr>
  <td></td>
  <td>&nbsp;</td>
    <td>&nbsp;</td>
     <td>&nbsp;</td>
  </tr>

 
 <input type="hidden" id="MONTH_YR_PASSING" name="MONTH_YR_PASSING" readonly>
  <input type="hidden" id="prgcat" name="prgcat" readonly>
  <input name="prgcd" id="prgcd" hidden >
</form>

  
  


</body>
</html>

