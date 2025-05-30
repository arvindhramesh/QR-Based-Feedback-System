<?php
include 'config.php';

$slno = $_POST['slno'] ?? '';
$regno = $_POST['regno'];
$scholar = $_POST['scholar'];
$discipline = $_POST['discipline'];

if ($slno) {
    // Update
    $sql = "UPDATE PHD_TN1 SET REGNO=:regno, SCHOLAR=:scholar, DISCIPLINE=:discipline WHERE SLNO=:slno";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":slno", $slno);
} else {
    // Insert new
    $q = oci_parse($conn, "SELECT NVL(MAX(SLNO),0)+1 AS SLNO FROM PHD_TN1");
    oci_execute($q);
    $r = oci_fetch_assoc($q);
    $slno = $r['SLNO'];

    $sql = "INSERT INTO PHD_TN1 (SLNO, REGNO, SCHOLAR, DISCIPLINE) VALUES (:slno, :regno, :scholar, :discipline)";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":slno", $slno);
}

oci_bind_by_name($stmt, ":regno", $regno);
oci_bind_by_name($stmt, ":scholar", $scholar);
oci_bind_by_name($stmt, ":discipline", $discipline);

oci_execute($stmt);

header("Location: indexgrid.php");
?>
