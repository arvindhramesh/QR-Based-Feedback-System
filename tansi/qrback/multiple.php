<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Questions</title>
</head>
<body>
<?php
$conn = oci_connect("tans", "tans", "tans");
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Insert new question
    if (isset($_POST['new_questions']) && is_array($_POST['new_questions'])) {
        foreach ($_POST['new_questions'] as $new_question) {
            $cname = strtoupper(trim($new_question['cname']));
            $pname = strtoupper(trim($new_question['pname']));
            $qname = strtoupper(trim($new_question['question']));

            // Get next IDs
            $catnxt = oci_parse($conn, "SELECT TANS.ASSET_CAT.NEXTVAL AS NEXTVAL FROM dual");
            $parnxt = oci_parse($conn, "SELECT TANS.ASSET_PARA.NEXTVAL AS NEXTVAL FROM dual");

            oci_execute($catnxt);
            $catnxtno = oci_fetch_assoc($catnxt)['NEXTVAL'];

            oci_execute($parnxt);
            $parnxtno = oci_fetch_assoc($parnxt)['NEXTVAL'];

            // Insert into tables
            oci_execute(oci_parse($conn, "INSERT INTO TANS.ASSET_CATEGORY (CAT_ID, CDATE, NAME) VALUES ($catnxtno, SYSDATE, '$cname')"));
            oci_execute(oci_parse($conn, "INSERT INTO TANS.ASSET_PARAMETER (PARAM_ID, CDATE, NAME, CAT_ID) VALUES ($parnxtno, SYSDATE, '$pname', $catnxtno)"));
            oci_execute(oci_parse($conn, "INSERT INTO ASSET_PARAMETER_QUESTION (APQ_ID, CDATE, ENG_QUESTION, PARAM_ID) VALUES ($catnxtno, SYSDATE, '$qname', $parnxtno)"));
        }
    }

    // Update existing question
    if (isset($_POST['update_questions']) && is_array($_POST['update_questions'])) {
        foreach ($_POST['update_questions'] as $update) {
            $qid = (int)$update['qid'];
            $qname = strtoupper(trim($update['question']));
            oci_execute(oci_parse($conn, "UPDATE ASSET_PARAMETER_QUESTION SET ENG_QUESTION = '$qname' WHERE APQ_ID = $qid"));
        }
    }

    // Delete questions
    if (isset($_POST['delete_qids']) && is_array($_POST['delete_qids'])) {
        foreach ($_POST['delete_qids'] as $qid) {
            $qid = (int)$qid;
            oci_execute(oci_parse($conn, "DELETE FROM ASSET_PARAMETER_QUESTION WHERE APQ_ID = $qid"));
        }
    }

    oci_commit($conn);
    echo "<p>Changes saved successfully.</p>";
}
?>

<h2>Manage Questions</h2>
<form method="post">
    <h3>Add New Questions</h3>
    <div id="new-questions-container">
        <div class="question-block">
            <input type="text" name="new_questions[0][cname]" placeholder="Category" required />
            <input type="text" name="new_questions[0][pname]" placeholder="Parameter Name" required />
            <input type="text" name="new_questions[0][question]" placeholder="Question" required />
        </div>
    </div>
    <button type="button" onclick="addNewQuestion()">+ Add Another Question</button>

    <h3>Update Existing Questions</h3>
    <?php
    // Display existing questions for update/delete
    $qresult = oci_parse($conn, "SELECT APQ_ID, ENG_QUESTION FROM ASSET_PARAMETER_QUESTION");
    oci_execute($qresult);
    $i = 0;
    while ($row = oci_fetch_assoc($qresult)) {
        echo "<div>";
        echo "<input type='hidden' name='update_questions[$i][qid]' value='{$row['APQ_ID']}' />";
        echo "<input type='text' name='update_questions[$i][question]' value='" . htmlentities($row['ENG_QUESTION']) . "' />";
        echo "<label><input type='checkbox' name='delete_qids[]' value='{$row['APQ_ID']}' /> Delete</label>";
        echo "</div>";
        $i++;
    }
    ?>
    <br>
    <input type="submit" value="Save Changes" />
</form>

<script>
let questionIndex = 1;
function addNewQuestion() {
    const container = document.getElementById('new-questions-container');
    const div = document.createElement('div');
    div.className = 'question-block';
    div.innerHTML = `
        <input type="text" name="new_questions[${questionIndex}][cname]" placeholder="Category" required />
        <input type="text" name="new_questions[${questionIndex}][pname]" placeholder="Parameter Name" required />
        <input type="text" name="new_questions[${questionIndex}][question]" placeholder="Question" required />
    `;
    container.appendChild(div);
    questionIndex++;
}
</script>

</body>
</html>
