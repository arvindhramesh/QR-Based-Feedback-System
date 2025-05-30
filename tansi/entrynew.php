<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = oci_connect("tans", "tans", "gct");
if (!$conn) {
   // die("Connection failed: " . htmlentities(oci_error()['message']));
}

$cat_id = isset($_GET['cat_id']) ? intval($_GET['cat_id']) : 0;

if ($cat_id <= 0) {
    die("No valid cat_id provided in URL.");
}

$cat_name = '';
$params = array();

// Fetch category name
$sql = "SELECT NAME FROM TANS.ASSET_CATEGORY WHERE CAT_ID = :cat_id";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":cat_id", $cat_id);
oci_execute($stmt);
if (oci_fetch($stmt)) {
    $cat_name = oci_result($stmt, "NAME");
} else {
    die("Category not found.");
}

// Fetch parameters and questions
$sql = "SELECT p.PARAM_ID, p.NAME AS PARAM_NAME, q.ENG_QUESTION
        FROM TANS.ASSET_PARAMETER p
        LEFT JOIN ASSET_PARAMETER_QUESTION q ON q.PARAM_ID = p.PARAM_ID
        WHERE p.CAT_ID = :cat_id";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":cat_id", $cat_id);
oci_execute($stmt);
while ($row = oci_fetch_assoc($stmt)) {
    $params[] = $row;
}
?>

<h2>Editing Category: <?= htmlspecialchars($cat_name) ?></h2>

<form method="post">
    <input type="hidden" name="cat_id" value="<?= $cat_id ?>">
    Category: <input type="text" name="cname" value="<?= htmlspecialchars($cat_name) ?>"><br><br>

    <?php foreach ($params as $index => $p): ?>
        <input type="hidden" name="param_id[]" value="<?= $p['PARAM_ID'] ?>">
        Param: <input type="text" name="pname[]" value="<?= htmlspecialchars($p['PARAM_NAME']) ?>">
        Qns: <input type="text" name="eng_question[]" value="<?= htmlspecialchars($p['ENG_QUESTION']) ?>"><br><br>
    <?php endforeach; ?>

    <input type="submit" name="update" value="Update">
</form>

<?php
if (isset($_POST['update'])) {
    $new_name = $_POST['cname'];
    $pnames = $_POST['pname'];
    $questions = $_POST['eng_question'];
    $param_ids = $_POST['param_id'];

    $stmt = oci_parse($conn, "UPDATE TANS.ASSET_CATEGORY SET NAME = UPPER(:name) WHERE CAT_ID = :cat_id");
    oci_bind_by_name($stmt, "upper(:name)", $new_name);
    oci_bind_by_name($stmt, ":cat_id", $cat_id);
    oci_execute($stmt, OCI_DEFAULT);

    for ($i = 0; $i < count($param_ids); $i++) {
        $pid = $param_ids[$i];
        $pname = strtoupper($pnames[$i]);
        $qname = strtoupper($questions[$i]);

        $stmt = oci_parse($conn, "UPDATE TANS.ASSET_PARAMETER SET NAME = :pname WHERE PARAM_ID = :pid");
        oci_bind_by_name($stmt, "upper(:pname)", $pname);
        oci_bind_by_name($stmt, ":pid", $pid);
        oci_execute($stmt, OCI_DEFAULT);

        $stmt = oci_parse($conn, "UPDATE ASSET_PARAMETER_QUESTION SET ENG_QUESTION = upper(:qname) WHERE PARAM_ID = :pid");
        oci_bind_by_name($stmt, "upper(:qname)", $qname);
        oci_bind_by_name($stmt, ":pid", $pid);
        oci_execute($stmt, OCI_DEFAULT);
    }

    oci_commit($conn);
    echo "<p style='color:green'>Updated successfully!</p>";
}
?>
