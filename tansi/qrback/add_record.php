<?php
$conn = oci_connect('tans', 'tans', 'tans');

// Get max SLNO
$slno_stmt = oci_parse($conn, "SELECT NVL(MAX(SLNO), 0) + 1 AS NEXT_SLNO FROM TANS.PHD_TN1");
oci_execute($slno_stmt);
$row = oci_fetch_assoc($slno_stmt);
$next_slno = $row['NEXT_SLNO'];

$sql = "INSERT INTO TANS.PHD_TN1 (
  SLNO, REGNO, SCHOLAR, REGDT, GENDER, TIMESTATUS, DISCIPLINE,
  NAME_INST, COMMUNITY, SCH_MOBILE, SCH_MAIL,
  GUIDE, GUIDE_MOBILE, GUIDE_MAIL, UNIVERSITY, UN_CODE
) VALUES (
  :SLNO, :REGNO, :SCHOLAR, TO_DATE(:REGDT, 'YYYY-MM-DD'), :GENDER, :TIMESTATUS, :DISCIPLINE,
  :NAME_INST, :COMMUNITY, :SCH_MOBILE, :SCH_MAIL,
  :GUIDE, :GUIDE_MOBILE, :GUIDE_MAIL, :UNIVERSITY, :UN_CODE
)";

$statement = oci_parse($conn, $sql);

oci_bind_by_name($statement, ":SLNO", $next_slno);
oci_bind_by_name($statement, ":REGNO", $_POST['REGNO']);
oci_bind_by_name($statement, ":SCHOLAR", $_POST['SCHOLAR']);
oci_bind_by_name($statement, ":REGDT", $_POST['REGDT']);
oci_bind_by_name($statement, ":GENDER", $_POST['GENDER']);
oci_bind_by_name($statement, ":TIMESTATUS", $_POST['TIMESTATUS']);
oci_bind_by_name($statement, ":DISCIPLINE", $_POST['DISCIPLINE']);
oci_bind_by_name($statement, ":NAME_INST", $_POST['NAME_INST']);
oci_bind_by_name($statement, ":COMMUNITY", $_POST['COMMUNITY']);
oci_bind_by_name($statement, ":SCH_MOBILE", $_POST['SCH_MOBILE']);
oci_bind_by_name($statement, ":SCH_MAIL", $_POST['SCH_MAIL']);
oci_bind_by_name($statement, ":GUIDE", $_POST['GUIDE']);
oci_bind_by_name($statement, ":GUIDE_MOBILE", $_POST['GUIDE_MOBILE']);
oci_bind_by_name($statement, ":GUIDE_MAIL", $_POST['GUIDE_MAIL']);
oci_bind_by_name($statement, ":UNIVERSITY", $_POST['UNIVERSITY']);
oci_bind_by_name($statement, ":UN_CODE", $_POST['UN_CODE']);

$r = oci_execute($statement);

if ($r) {
    echo "Record added successfully.";
} else {
    $e = oci_error($statement);
    echo "Error: " . $e['message'];
}
?>
