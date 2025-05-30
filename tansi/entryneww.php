<?php
// Enable sessions to store CAT_ID across requests
if($_POST['clear']=='Clear')
{
	session_unset();
}
else
{
	session_start(); 
}
$conn = oci_connect("tans", "tans", "gct");
if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}

$cat_id = null;

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cname = trim($_POST['cname']);
    $pnames = $_POST['pname'];
    $questions = $_POST['eng_question'];

    // Use existing CAT_ID from session, or create new one
    if (!empty($_POST['cat_id'])) {
        $cat_id = $_POST['cat_id'];
    } elseif (!empty($_SESSION['cat_id'])) {
        $cat_id = $_SESSION['cat_id'];
    } else {
        // Generate new CAT_ID
        $catnxt = "SELECT TANS.ASSET_CAT.NEXTVAL NEXTVAL FROM dual";
        $gen1 = oci_parse($conn, $catnxt);
        oci_execute($gen1, OCI_DEFAULT);
        $cat_id = oci_fetch($gen1) ? oci_result($gen1, "NEXTVAL") : null;

        // Insert Category
        $sql1 = "INSERT INTO TANS.ASSET_CATEGORY (CAT_ID, CDATE, NAME) VALUES ($cat_id, sysdate, upper(:cname))";
        $ins1 = oci_parse($conn, $sql1);
        oci_bind_by_name($ins1, ':cname', $cname);
        oci_execute($ins1, OCI_DEFAULT);
    }

    $_SESSION['cat_id'] = $cat_id; // Store it in session for later use

    // Insert only valid param/question pairs
    for ($i = 0; $i < count($pnames); $i++) {
        $pname = strtoupper(trim($pnames[$i]));
        $qname = strtoupper(trim($questions[$i]));

        if ($pname !== '' && $qname !== '') {
            // Generate PARAM_ID
            $parnxt = "SELECT TANS.ASSET_PARA.NEXTVAL NEXTVAL FROM dual";
            $gen2 = oci_parse($conn, $parnxt);
            oci_execute($gen2, OCI_DEFAULT);
            $parnxtno = oci_fetch($gen2) ? oci_result($gen2, "NEXTVAL") : null;

            // Insert Parameter
            $sql2 = "INSERT INTO TANS.ASSET_PARAMETER (PARAM_ID, CDATE, NAME, CAT_ID) VALUES ($parnxtno, sysdate, :pname, $cat_id)";
            $ins2 = oci_parse($conn, $sql2);
            oci_bind_by_name($ins2, ':pname', $pname);
            oci_execute($ins2, OCI_DEFAULT);

            // Insert Question (APQ_ID reused here as CAT_ID or use your own sequence)
            $sql3 = "INSERT INTO ASSET_PARAMETER_QUESTION (APQ_ID, CDATE, ENG_QUESTION, PARAM_ID) VALUES ($cat_id, sysdate, :qname, $parnxtno)";
            $ins3 = oci_parse($conn, $sql3);
            oci_bind_by_name($ins3, ':qname', $qname);
            oci_execute($ins3, OCI_DEFAULT);
        }
    }

    oci_commit($conn);
}
?>

<!-- HTML FORM -->
<form method="post">
    <input style='text-transform:uppercase' placeholder="Category" type="text" name="cname"
           value="<?php echo isset($cname) ? htmlspecialchars($cname) : ''; ?>" required /><br>

    <!-- Store CAT_ID to reuse on next form submission -->
    <input type="hidden" name="cat_id" value="<?php echo isset($cat_id) ? htmlspecialchars($cat_id) : (isset($_SESSION['cat_id']) ? htmlspecialchars($_SESSION['cat_id']) : ''); ?>" />


    <div id="param_question_blocks">
        <div class="block">
            <input style='text-transform:uppercase' type="text" placeholder="Parameter Name" name="pname[]" />
            <input style='text-transform:uppercase' type="text" placeholder="Question" name="eng_question[]" /><br><br>
        </div>
    </div>

    <button type="button" onclick="addParamWithQuestion()">Add Another Parameter + Question</button><br><br>

    <input type="submit" name="save" value="Save / Continue" />
    <input type="submit" name="clear" value="Clear" />
</form>

<script>
function addParamWithQuestion() {
    const container = document.getElementById('param_question_blocks');
    const block = document.createElement('div');
    block.className = 'block';

    const paramInput = document.createElement('input');
    paramInput.type = 'text';
    paramInput.name = 'pname[]';
    paramInput.placeholder = 'Parameter Name';
    paramInput.style = 'text-transform:uppercase';

    const questionInput = document.createElement('input');
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
