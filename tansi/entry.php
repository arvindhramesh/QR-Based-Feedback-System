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



if (isset($_POST['cname'])) {
    $cname = $_POST['cname'];
    $pnames = $_POST['pname'];
    $questions = $_POST['eng_question'];

    // Generate CAT_ID
    $catnxt = "select TANS.ASSET_CAT.NEXTVAL NEXTVAL from dual";
    $gen1 = oci_parse($conn, $catnxt);
    oci_execute($gen1, OCI_DEFAULT);
    $catnxtno = oci_fetch($gen1) ? oci_result($gen1, "NEXTVAL") : null;

    // Insert Category
    $sql1 = "insert into TANS.ASSET_CATEGORY (CAT_ID, CDATE, NAME) values ($catnxtno, sysdate, upper(:cname))";
    $ins1 = oci_parse($conn, $sql1);
    oci_bind_by_name($ins1, ':cname', $cname);
    oci_execute($ins1, OCI_DEFAULT);

    for ($i = 0; $i < count($pnames); $i++) {
        $pname = strtoupper($pnames[$i]);
        $qname = strtoupper($questions[$i]);

        // Get PARAM_ID
        $parnxt = "select TANS.ASSET_PARA.NEXTVAL NEXTVAL from dual";
        $gen2 = oci_parse($conn, $parnxt);
        oci_execute($gen2, OCI_DEFAULT);
        $parnxtno = oci_fetch($gen2) ? oci_result($gen2, "NEXTVAL") : null;

        // Insert Parameter
        $sql2 = "insert into TANS.ASSET_PARAMETER (PARAM_ID, CDATE, NAME, CAT_ID) values ($parnxtno, sysdate, :pname, $catnxtno)";
        $ins2 = oci_parse($conn, $sql2);
        oci_bind_by_name($ins2, ':pname', $pname);
        oci_execute($ins2, OCI_DEFAULT);

        // Insert Question (APQ_ID generation ideally should be separate; here we use same as CAT_ID for now)
        $sql3 = "insert into ASSET_PARAMETER_QUESTION (APQ_ID, CDATE, ENG_QUESTION, PARAM_ID) values ($catnxtno, sysdate, :qname, $parnxtno)";
        $ins3 = oci_parse($conn, $sql3);
        oci_bind_by_name($ins3, ':qname', $qname);
        oci_execute($ins3, OCI_DEFAULT);
    }

    oci_commit($conn);
}
?>


<form method="post">
    <input style='text-transform:uppercase' placeholder="Category " type="text" name="cname" /><br>

    <div id="param_question_blocks">
        <div class="block">
            <input style='text-transform:uppercase' type="text" placeholder="Parameter Name" name="pname[]" />
            <input style='text-transform:uppercase' type="text" placeholder="Question" name="eng_question[]" /><br><br>
        </div>
    </div>

    <button type="button" onclick="addParamWithQuestion()">Add Another Parameter + Question</button><br><br>

    <input type="submit" name="save" />
</form>




</body>
</html>
<script>
function addParamWithQuestion() {
    var container = document.getElementById('param_question_blocks');
    var block = document.createElement('div');
    block.className = 'block';

    var paramInput = document.createElement('input');
    paramInput.type = 'text';
    paramInput.name = 'pname[]';
    paramInput.placeholder = 'Parameter Name';
    paramInput.style = 'text-transform:uppercase';

    var questionInput = document.createElement('input');
    questionInput.type = 'text';
    questionInput.name = 'eng_question[]';
    questionInput.placeholder = 'Question';
    questionInput.style = 'text-transform:uppercase';

    block.appendChild(paramInput);
    block.appendChild(questionInput);
    block.appendChild(document.createElement('br'));
    block.appendChild(document.createElement('br'));

    container.appendChild(block);
}
</script>
