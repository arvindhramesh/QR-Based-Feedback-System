<?php
include 'config.php';

$slno = $_GET['slno'] ?? '';
if ($slno) {
    $sql = "DELETE FROM PHD_TN1 WHERE SLNO=:slno";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":slno", $slno);
    oci_execute($stmt);
}
header("Location: index.php");
?>
