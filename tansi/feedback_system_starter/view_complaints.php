<?php
session_start();
include 'inc/db_connect.php';

if ($_SESSION['role'] != 'user') {
    exit("Unauthorized access");
}

$user_id = $_SESSION['user_id'];

$query = "SELECT COMP_ID, CATEGORY, DESCRIPTION, STATUS, DATE_RAISED, DATE_RESOLVED, RESOLUTION 
          FROM TANS.COMPLAINTS 
          WHERE USER_ID = :uid ORDER BY COMP_ID DESC";

$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":uid", $user_id);
oci_execute($stmt);

echo "<h2>Your Complaints</h2><table border='1'>";
echo "<tr><th>ID</th><th>Category</th><th>Description</th><th>Status</th><th>Raised</th><th>Resolved</th><th>Resolution</th></tr>";
while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>
        <td>{$row['COMP_ID']}</td>
        <td>{$row['CATEGORY']}</td>
        <td>{$row['DESCRIPTION']}</td>
        <td>{$row['STATUS']}</td>
        <td>{$row['DATE_RAISED']}</td>
        <td>{$row['DATE_RESOLVED']}</td>
        <td>{$row['RESOLUTION']}</td>
    </tr>";
}
echo "</table>";
?>
