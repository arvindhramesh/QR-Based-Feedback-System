<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Multiple Questions</title>
</head>
<body>
<?php
$conn = oci_connect("tans", "tans", "tans");
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['questions'])) {
    foreach ($_POST['questions'] as $q) {
        $cname = strtoupper(trim($q['cname']));
        $pname = strtoupper(trim($q['pname']));
        $qname = strtoupper(trim($q['eng_question']));

        // Get next IDs
        $catnxt = oci_parse($conn, "SELECT TANS.ASSET_CAT.NEXTVAL AS NEXTVAL FROM dual");
        $parnxt = oci_parse($conn, "SELECT TANS.ASSET_PARA.NEXTVAL AS NEXTVAL FROM dual");

        oci_execute($catnxt);
        $catnxtno = oci_fetch_assoc($catnxt)['NEXTVAL'];

        oci_execute($parnxt);
        $parnxtno = oci_fetch_assoc($parnxt)['NEXTVAL'];

        // Insert data
        oci_execute(oci_parse($conn, "INSERT INTO TANS.ASSET_CATEGORY (CAT_ID, CDATE, NAME) VALUES ($catnxtno, SYSDATE, '$cname')"));
        oci_execute(oci_parse($conn, "INSERT INTO TANS.ASSET_PARAMETER (PARAM_ID, CDATE, NAME, CAT_ID) VALUES ($parnxtno, SYSDATE, '$pname', $catnxtno)"));
        oci_execute(oci_parse($conn, "INSERT INTO ASSET_PARAMETER_QUESTION (APQ_ID, CDATE, ENG_QUESTION, PARAM_ID) VALUES ($catnxtno, SYSDATE, '$qname', $parnxtno)"));
    }

    oci_commit($conn);
    echo "<p>Questions added successfully!</p>";
}
?>

<h2>Add Multiple Questions</h2>
<form method="post">
    <div id="questions-container">
        <div class="question-block">
            <input style='text-transform:uppercase' placeholder="Category" type="text" name="questions[0][cname]" required />
            <input style='text-transform:uppercase' placeholder="Parameter Name" type="text" name="questions[0][pname]" required />
            <input style='text-transform:uppercase' placeholder="Question" type="text" name="questions[0][eng_question]" required />
        </div>
    </div>
    <button type="button" onclick="addQuestion()">+ Add Another Question</button><br><br>
    <input type="submit" value="Submit Questions" />
</form>

<script>
let qIndex = 1;
function addQuestion() {
    const container = document.getElementById('questions-container');
    const div = document.createElement('div');
    div.className = 'question-block';
    div.innerHTML = `
        <input style='text-transform:uppercase' placeholder="Category" type="text" name="questions[${qIndex}][cname]" required />
        <input style='text-transform:uppercase' placeholder="Parameter Name" type="text" name="questions[${qIndex}][pname]" required />
        <input style='text-transform:uppercase' placeholder="Question" type="text" name="questions[${qIndex}][eng_question]" required />
    `;
    container.appendChild(div);
    qIndex++;
}
</script>

</body>
</html>
