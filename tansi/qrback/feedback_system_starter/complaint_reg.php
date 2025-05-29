<?php
session_start();
include 'inc/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    die("Access denied.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);

    $sql = "INSERT INTO TANS.COMPLAINTS (USER_ID, CATEGORY, DESCRIPTION, STATUS, DATE_RAISED)
            VALUES (:p_uid, :p_cat, :p_descr, 'New', SYSDATE)";

    $stmt = oci_parse($conn, $sql);

    // Use simple alphanumeric bind names (no reserved words, no special chars)
    oci_bind_by_name($stmt, ":p_uid", $user_id);
    oci_bind_by_name($stmt, ":p_cat", $category);
    oci_bind_by_name($stmt, ":p_descr", $description);

    if (oci_execute($stmt)) {
        echo "<p style='color:green;'>Complaint registered successfully!</p>";
    } else {
        $e = oci_error($stmt);
        echo "<p style='color:red;'>Error: " . htmlentities($e['message']) . "</p>";
    }
}
?>

<!-- HTML Form -->
<h2>Register Complaint</h2>
<form method="POST" action="">
    <label>Category:</label><br>
    <input type="text" name="category" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="5" cols="40" required></textarea><br><br>

    <button type="submit">Submit</button>
</form>
