<?php
if (!isset($_GET['un_code']) || !isset($_GET['discipline'])) exit;

$un_code = $_GET['un_code'];
$discipline = $_GET['discipline'];
include '../connection.php';

$sql = "
    SELECT SLNO, REGNO, SCHOLAR, REGDT, GENDER
    FROM TANS.PHD_TN
    WHERE UN_CODE = :un_code AND DISCIPLINE = :discipline
    ORDER BY REGDT
";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ":un_code", $un_code);
oci_bind_by_name($stid, ":discipline", $discipline);
oci_execute($stid);

echo "<table width='100%' border='1'>
        <tr>
            <th>SL No</th>
            <th>Reg No</th>
            <th>Scholar</th>
            <th>Reg Date</th>
            <th>Gender</th>
        </tr>";

while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo "<tr>
            <td>" . htmlspecialchars($row['SLNO']) . "</td>
            <td>" . htmlspecialchars($row['REGNO']) . "</td>
            <td>" . htmlspecialchars($row['SCHOLAR']) . "</td>
            <td>" . htmlspecialchars($row['REGDT']) . "</td>
            <td>" . htmlspecialchars($row['GENDER']) . "</td>
          </tr>";
}

echo "</table>";
?>
