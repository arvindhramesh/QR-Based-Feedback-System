<?php
if (!isset($_GET['univer']) || !isset($_GET['dept'])) exit;

$univer = $_GET['univer'];
$dept = $_GET['dept'];
include '../connection.php';

$sql = "
    SELECT ASNO, STAFFNO, FNAME, DESGN, QUAL, DTJOIN, DTSUP, CONTNO, MAILID
    FROM TANS.TEACH_UNIVER
    WHERE UNIVER = :univer AND DEPT = :dept
    ORDER BY DTJOIN
";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ":univer", $univer);
oci_bind_by_name($stid, ":dept", $dept);
oci_execute($stid);

echo "<table width='100%' border='1'>
        <tr>
            <th>ASNO</th>
            <th>Staff No</th>
            <th>Name</th>
            <th>Designation</th>
            <th>Qualification</th>
            <th>Join Date</th>
            <th>Superannuation</th>
            <th>Contact No</th>
            <th>Email</th>
        </tr>";

while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo "<tr>
            <td>" . htmlspecialchars($row['ASNO']) . "</td>
            <td>" . htmlspecialchars($row['STAFFNO']) . "</td>
            <td>" . htmlspecialchars($row['FNAME']) . "</td>
            <td>" . htmlspecialchars($row['DESGN']) . "</td>
            <td>" . htmlspecialchars($row['QUAL']) . "</td>
            <td>" . htmlspecialchars($row['DTJOIN']) . "</td>
            <td>" . htmlspecialchars($row['DTSUP']) . "</td>
            <td>" . htmlspecialchars($row['CONTNO']) . "</td>
            <td>" . htmlspecialchars($row['MAILID']) . "</td>
          </tr>";
}

echo "</table>";
?>
