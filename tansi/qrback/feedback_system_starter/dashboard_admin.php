<?php
session_start();
include 'inc/db_connect.php';

if ($_SESSION['role'] != 'admin') exit("Unauthorized");

$query = "SELECT C.COMP_ID, U.NAME, C.CATEGORY, C.DESCRIPTION, C.STATUS FROM TANS.COMPLAINTS C JOIN TANS.USERS U ON C.USER_ID = U.USER_ID";
$statement = oci_parse($conn, $query);
oci_execute($statement);

echo "<h2>All Complaints</h2><table border='1'>";
echo "<tr><th>ID</th><th>User</th><th>Category</th><th>Description</th><th>Status</th></tr>";
while ($row = oci_fetch_assoc($statement)) {
    echo "<tr>
        <td>{$row['COMP_ID']}</td>
        <td>{$row['NAME']}</td>
        <td>{$row['CATEGORY']}</td>
        <td>{$row['DESCRIPTION']}</td>
        <td>{$row['STATUS']}</td>
    </tr>";
}
echo "</table>";
?>
