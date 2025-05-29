<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$conn = oci_connect('tans', 'tans', 'tans');
$sql = "SELECT * FROM tans.phd_tn1";
$stid = oci_parse($conn, $sql);
oci_execute($stid);

$data = array();
while ($row = oci_fetch_assoc($stid)) {
    // Safely encode Oracle strings
    $data[] = array_map('utf8_encode', $row);
}

echo json_encode(array('data' => $data));

oci_free_statement($stid);
oci_close($conn);
?>
