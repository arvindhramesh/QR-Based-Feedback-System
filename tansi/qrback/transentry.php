
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
    max-width: 500px;
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
    width: 40%;
}
.form-style-9 ul li .field-full{
    width: 50%;
}

.columns {
	width: 200%;
	column-count:2;

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

.name_label {
    display: inline-block;
	width:50%;
    text-align: right;
}
</style>
<body>



<?php
include ("oraconn.php");

//$conn=oci_connect("webdde","webphp","ORDDE");
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}


if (isset($_POST['DEPT']) )
{
$sql="insert into sis.DEPTTRANS (
DEPT,
AHEAD,
DT,
AMOUNT,
REFNO,
VOCHNO
  )
  values(
:DEPT,
:AHEAD, 
:DT,
:AMOUNT,
:REFNO,
:VOCHNO
  )";
 
$ins =oci_parse($conn,$sql) ;
oci_bind_by_name($ins,':DEPT',$_POST['DEPT']); 
oci_bind_by_name($ins,':AHEAD',$_POST['AHEAD']); 
$dt=date('d-M-Y', strtotime($_POST['DT']));
oci_bind_by_name($ins,':DT',$dt); 
@oci_bind_by_name($ins,':AMOUNT',strtoupper($_POST['AMOUNT'])); 
@oci_bind_by_name($ins,':REFNO',strtoupper($_POST['REFNO'])); 
@oci_bind_by_name($ins,':VOCHNO',strtoupper($_POST['VOCHNO'])); 
oci_execute($ins,OCI_DEFAULT);
oci_commit($conn);
	
}


?>

<form  class="form-style-9" id="feefrm" onSubmit="return validate();" method="post" autocomplete="off">

<h1 style="font-size:18px; font-weight:bold">Head of Expenses </h1>

<ul>
<li  class="columns">

<select onChange="ahead();"   class="field-style field-split align-left" tabindex="1" id="DEPT" name="DEPT"  >
<option disabled selected > Select Department  </option>
<?php
$stid1 = oci_parse($conn, "select DISTINCT DEPT from sis.DEPT ORDER BY 1");
oci_execute($stid1);
while(oci_fetch($stid1))
{
?>
 <option> <?php echo oci_result($stid1,'DEPT'); }?> </option>
 </select>
 
 <label  class="name_label"  style="font-size:24px; font-weight:bold; color:#C00" id="allotment"></label> 
    
 

</li>
 <li  class="columns">
 <select  onChange="balret();"  class="field-style field-split align-left" tabindex="1" id="AHEAD" name="AHEAD"  >
 </select>
 
 <label class="name_label" style="font-size:24px; font-weight:bold; color:#C00" id="debit">  </label>
  
 </li>
 
 <li  class="columns">
 <input class="field-style field-split align-left" type="date" tabindex="12" placeholder="Date:-"  id="DT"   
  name="DT" maxlength="60" size="30" >
  <label class="name_label" style="font-size:24px; font-weight:bold; color:#C00" id="balamt">  </label>
 </li>
   
<li  class="columns">  
  <input onChange="amt();" class="field-style field-split align-left" tabindex="3" placeholder="AMOUNT"  id="AMOUNT"  type="number"  required
  name="AMOUNT"  maxlength="60" size="30" >
</li>

  <li  class="columns">
  <input class="field-style field-split align-left" tabindex="5" placeholder="VochNo"  
  id="VOCHNO" style="text-transform:uppercase"  
  name="VOCHNO" maxlength="60" size="30" >    
  </li>
  
  <li  class="columns">
  <input class="field-style field-split align-left" tabindex="6" placeholder="Ref.No"  
  id="REFNO" style="text-transform:uppercase"  
  name="REFNO" maxlength="60" size="30" >    
  </li>
 

 
 
 
  
  <li >
  <input  align="middle"     tabindex="15"  type="submit" value="Save">
   <input  align="middle"     tabindex="15"  type="reset" value="Clear">

    
 </li> 

 
 
 <?php
 
 
 
 
 if (@$_POST['GEN_TYPE']=='TCDIS')
 {
 echo '<a style=" font-weight: bold; font-size:14px; color:blue;" href="tcdiscontiued.php?id=',$_POST['ROLLNO'],'" target="_parent;return false;"> ' .$_POST['ROLLNO']."<br />"    ; 
 }
 else
 {
 echo '<a style=" font-weight: bold; font-size:14px; color:blue;" href="tc.php?id=',$_POST['ROLLNO'],'" target="_parent;return false;"> ' .$_POST['ROLLNO']."<br />"    ; 
	 
 }
 
?>



  
</ul>   
   
</form>


  


</body>
</html>

<script>
function ahead()
{


$.ajax({
    url:'headdisp.php',
    type:'POST',
    data :{dept:document.getElementById('DEPT').value},
    dataType: 'json',
    success: function( json ) {


			
          // Assumption is that API returned something like:["North","West","South","East"];
		  $('#AHEAD').empty();
            $('#AHEAD').append($('<option>').text("Select Head"));
            $.each(json, function(i, obj){
                    $('#AHEAD').append($('<option>').text(obj).attr('value', obj));

            });
          
    }
});

}
function amt()
{
	
	if( parseInt(document.getElementById("balamt").innerHTML) 	
	 <=  parseInt(document.getElementById("AMOUNT").value))
	{
		alert ('Insufficient Balance  ');
		document.getElementById("AMOUNT").focus();

		
	}
}



function balret()
{
	

	$.ajax
({
    type: "POST",
    url: "balhead.php",	
	data :{dept:document.getElementById("DEPT").value,achead:document.getElementById("AHEAD").value},
    dataType: 'json',
    cache: false,

    success: function(data)
    {
      
//document.getElementById("baltxt").innerHTML=data.amt;
document.getElementById("allotment").innerHTML='Allotment...'+numberWithCommas(data.allotment);
    document.getElementById("debit").innerHTML='Total Exp...'+numberWithCommas(data.debit);
 
  document.getElementById("balamt").innerHTML='Balance......'+(numberWithCommas(parseInt(data.allotment)-parseInt(data.debit)));
		
		
    }
		
}

);


}


$("input[type=date]").datepicker({
  dateFormat: 'yy-mm-dd',
  onSelect: function(dateText, inst) {
    $(inst).val(dateText); // Write the value in the input
  }
});

// Code below to avoid the classic date-picker
$("input[type=date]").on('click', function() {
  return false;
});


function numberWithCommas(x) {
return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	
	//return x.toLocaleString("en-INDIA");
}







</script>
