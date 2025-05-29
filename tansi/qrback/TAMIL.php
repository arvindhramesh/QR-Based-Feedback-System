<?PHP
$tamil = "தமிழ் எழுதுக";  // Some Tamil string
$conn = oci_connect("tans", "tans", "tans",'AL32UTF8');

if (!$conn) {
    $m = oci_error();
    trigger_error(htmlentities($m['message']), E_USER_ERROR);
}
$sql = "INSERT INTO ASSET_PARAMETER_QUESTION (TAMIL_QUESTION) VALUES (:tq)";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":tq", $tamil);
oci_execute($stmt);
?>