<?php
session_start();
include 'inc/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    die("Access denied. Please log in as a user.");
}

$user_id = $_SESSION['user_id'];
$user_id=1;
?>

<h2>Welcome, User</h2>

<!-- Complaint Form -->
<h3>Raise a New Complaint</h3>
<form method="POST" action="">
    <label>Category:</label><br>
    <input type="text" name="category" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="5" cols="50" required></textarea><br><br>

    <button type="submit" name="submit_complaint">Submit Complaint</button>
</form>

<?php
// Handle complaint submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_complaint'])) {
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);

    $sql = "INSERT INTO TANS.COMPLAINTS (USER_ID, CATEGORY, DESCRIPTION, STATUS, DATE_RAISED)
            VALUES (:p_uid, :p_cat, :p_descr, 'New', SYSDATE)";

    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":p_uid", $user_id);
    oci_bind_by_name($stmt, ":p_cat", $category);
    oci_bind_by_name($stmt, ":p_descr", $description);

    if (oci_execute($stmt)) {
        echo "<p style='color:green;'>Complaint submitted successfully!</p>";
    } else {
        $e = oci_error($stmt);
        echo "<p style='color:red;'>Error: " . htmlentities($e['message']) . "</p>";
    }
}
?>

<hr>

<!-- View User's Complaints -->
<h3>Your Complaints</h3>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Category</th>
        <th>Description</th>
        <th>Status</th>
        <th>Date Raised</th>
        <th>Resolved On</th>
        <th>Resolution</th>
    </tr>

<?php
$sql = "SELECT COMP_ID, CATEGORY, DESCRIPTION, STATUS, DATE_RAISED, DATE_RESOLVED, RESOLUTION
        FROM TANS.COMPLAINTS
        ORDER BY COMP_ID DESC";

$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":uid", $user_id);
oci_execute($stmt);

while ($row = oci_fetch_assoc($stmt)) {
    echo "<tr>";
    echo "<td>" . $row['COMP_ID'] . "</td>";
    echo "<td>" . htmlentities($row['CATEGORY']) . "</td>";
    echo "<td>" . nl2br(htmlentities($row['DESCRIPTION'])) . "</td>";
    echo "<td>" . htmlentities($row['STATUS']) . "</td>";
    echo "<td>" . $row['DATE_RAISED'] . "</td>";
 echo "<td>" . (isset($row['DATE_RESOLVED']) ? $row['DATE_RESOLVED'] : '-') . "</td>";
echo "<td>" . nl2br(htmlentities(isset($row['RESOLUTION']) ? $row['RESOLUTION'] : '')) . "</td>";

    echo "</tr>";
}
?>
</table>
