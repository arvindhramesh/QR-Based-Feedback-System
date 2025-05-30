<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
<?php
$conn=oci_connect("tans","tans","gct");
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}



if (isset($_POST['cname']) )
{
	
$cname=$_POST['cname'];	
$pname=$_POST['pname'];
$qname= $_POST['eng_question'];

$catnxt="select TANS.ASSET_CAT.NEXTVAL NEXTVAL from dual";
;
$gen1=oci_parse($conn,$catnxt) ;

oci_execute($gen1,OCI_DEFAULT);
while(oci_fetch($gen1))
{
$catnxtno=oci_result($gen1,"NEXTVAL");
	
}




$sql1="insert into  TANS.ASSET_CATEGORY (CAT_ID,CDATE,NAME)values($catnxtno,sysdate,upper('$cname'))";

$ins1 =oci_parse($conn,$sql1) ;

oci_execute($ins1,OCI_DEFAULT);

$parnxt="select TANS.ASSET_PARA.NEXTVAL NEXTVAL from dual";
	$gen2=oci_parse($conn,$parnxt) ;
	
	
	
foreach ($_POST['pname'] as $paname => $pa_name) {
	echo $pa_name;
oci_execute($gen2,OCI_DEFAULT);	
$qarr=$_POST['eng_question'];
while(oci_fetch($gen2))
{
	
$parnxtno=oci_result($gen2,"NEXTVAL");

	
}
$sql2="insert into TANS.ASSET_PARAMETER (PARAM_ID,CDATE,NAME,CAT_ID)values($parnxtno,sysdate,upper('$pa_name'),$catnxtno)";

$sql3="insert into  ASSET_PARAMETER_QUESTION (APQ_ID,CDATE,ENG_QUESTION,PARAM_ID)values($catnxtno,sysdate,upper('$qarr[$paname]'),$parnxtno)";
$ins3 =oci_parse($conn,$sql3) ;
oci_execute($ins3,OCI_DEFAULT);
 
$ins2 =oci_parse($conn,$sql2) ;
oci_execute($ins2,OCI_DEFAULT);
}


 




oci_commit($conn);
}
?>
<table border="1">

<form method="post" >
<tr>
<td>
<input style='text-transform:uppercase'  placeholder="Category " type="text" id="cname" name="cname" /> <br>
</td>
<td> </td>
<td> </td>
</tr>
<tr>
<tr>
<td>


<div id="param">
<input style='text-transform:uppercase' type="text" placeholder="Paramter Name" 
id="pname" name="pname[]"  /><br />

</td>

<td>
 
<div id="questions">

<input style='text-transform:uppercase' type="text" placeholder="Question"  id="eng_question"   name="eng_question[]" />
<br />
</div>
</div>

</td>

<td>
<button type="button" onclick="addparam();addQuestion();">Add Another Parameter</button>
</td>
</tr>
<input type="submit" name="save" id="save"/>


</form>
</table>


</body>
</html>
<script>
function addQuestion() {
    var div = document.getElementById('questions');
    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'eng_question[]';
    input.placeholder = 'Question';
    input.style = 'text-transform:uppercase';
    div.appendChild(input);
    div.appendChild(document.createElement('br'));
}

function addparam() {
	//alert('tst');
    var div = document.getElementById('param');
    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'pname[]';
    input.placeholder = 'Parameter';
    input.style = 'text-transform:uppercase';
    div.appendChild(input);
    div.appendChild(document.createElement('br'));
}
</script>
