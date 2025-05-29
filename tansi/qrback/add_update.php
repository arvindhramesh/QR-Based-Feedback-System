<?php
include 'config.php';

$slno = $_POST['slno'] ?? '';
$regno = $_POST['regno'];
$scholar = $_POST['scholar'];
$regdt = $_POST['regdt'];
$discipline = $_POST['discipline'];

if ($slno) {
  // Update
  $sql = "UPDATE PHD_TN1 SET REGNO=:regno, SCHOLAR=:scholar, REGDT=TO_DATE(:regdt, 'YYYY-MM-DD'), DISCIPLINE=:discipline WHERE SLNO=:slno";
  $stid = oci_parse($conn, $sql);
  oci_bind_by_name($stid, ":slno", $slno);
} else {
  // New SLNO
  $sql_get = "SELECT NVL(MAX(SLNO), 0)+1 AS NEWSL FROM PHD_TN1";
  $stid_get = oci_parse($conn, $sql_get);
  oci_execute($stid_get);
  $row = oci_fetch_assoc($stid_get);
  $slno = $row['NEWSL'];

  // Insert
  $sql = "INSERT INTO PHD_TN1 (SLNO, REGNO, SCHOLAR, REGDT, DISCIPLINE)
          VALUES (:slno, :regno, :scholar, TO_DATE(:regdt, 'YYYY-MM-DD'), :discipline)";
  $stid = oci_parse($conn, $sql);
  oci_bind_by_name($stid, ":slno", $slno);
}

oci_bind_by_name($stid, ":regno", $regno);
oci_bind_by_name($stid, ":scholar", $scholar);
oci_bind_by_name($stid, ":regdt", $regdt);
oci_bind_by_name($stid, ":discipline", $discipline);

$r = oci_execute($stid);

echo $r ? "Success" : "Failed";
?>
