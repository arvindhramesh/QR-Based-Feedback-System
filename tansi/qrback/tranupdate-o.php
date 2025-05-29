<html>
<head>
<style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f4f8;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 600px;
      margin: 40px auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    h1 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 30px;
    }

    .question {
      margin-bottom: 25px;
	  color:blue;
    }

    .question label {
      display: block;
      font-weight: 600;
      color: #34495e;
      margin-bottom: 10px;
    }

    .options {
      display: flex;
      gap: 20px;
	  color: red;
    }

    .options label {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      font-weight: 500;
      color: #2c3e50;
    }

    input[type="radio"] {
      accent-color: #2980b9;
    }

    submit {
      display: block;
      margin: 20px auto 0;
      background: #2980b9;
      color: white;
      border: none;
      padding: 12px 30px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    submit:hover {
      background: #1c5980;
    }
  </style>
</head>
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

if(isset($_POST["save"]))
{
 //$sql="insert into sis.master_asset_data (parameters,name,questions,status,category) values    ('$myarray[0]','$myarray[1]','$myarray[2]','$myarray[3]','$myarray[4]') "  ;
 $qsname=$_POST["qsname"];
 $sql="insert into tans.master_asset_data (parameters, QUESTIONS ) values('$myarray[0]','$qsname') "  ;

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
}
$sqlstr="select  ENG_QUESTION FROM TANS.ASSET_PARAMETER_QUESTION where APQ_ID=14";
$stid=oci_parse($conn,$sqlstr);
oci_execute($stid);
?>

<html>
<body>
<h1><b>TAMILNADU STATE COUNCIL FOR HIGHER EDUCATION </b></h1>
<pre data-placeholder="Translation" id="tw-target-text" data-ved="2ahUKEwjL4sXQ6ZONAxVjgVYBHaDhGd4Q3ewLegQICRAW" dir="ltr" aria-label="Translated text: தமிழ்நாடு மாநில உயர்கல்வி மன்றம்"><span lang="ta">தமிழ்நாடு மாநில உயர்கல்வி மன்றம்்</span></pre>
<h1>&nbsp;</h1>
<h2><b>" <?php echo $myarray[0]; ?> . "</b></h2>
<div>
<?php
 while(oci_fetch($stid)){
	$qsname=oci_result($stid,'ENG_QUESTION');
?>
<form id='question'>
<div class="question">
<p><?php echo oci_result($stid,'ENG_QUESTION');  ?>
<input class="option" type="radio" name="yes" id="yes" >ஆம் 
<input type="radio" name="no" id="no"> இல்லை </p><br>
 </div>
 <input class="option" type="text" name="save" value="save" hidden>
 <input type="text"  name="qsname" value=<?php echo $qsname; ?> hidden>
 <?php
 } ?>
  	<input class="submit" type="submit">
  </div>
 </form>
</div>
</body>
</html>