<?php
// Oracle DB connection
$conn = oci_connect('tans', 'tans', 'tans','AL32UTF8');
if (!$conn) {
    $e = oci_error();
    die("Connection failed: " . $e['message']);
}
?>