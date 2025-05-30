<?php
$conn = oci_connect('tans', 'tans', 'tans');
if (!$conn) {
    $e = oci_error();
    die("Connection failed: " . $e['message']);
}
?>