<?php
session_start();
include 'inc/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $stmt = oci_parse($conn, "INSERT INTO TANS.COMPLAINTS (USER_ID, CATEGORY, DESCRIPTION) VALUES (:uid, :cat, :desc)");
    oci_bind_by_name($stmt, ":uid", $user_id);
    oci_bind_by_name($stmt, ":cat", $category);
    oci_bind_by_name($stmt, ":desc", $description);
    
    if (oci_execute($stmt)) {
        echo "Complaint submitted.";
    } else {
        echo "Submission failed.";
    }
}
?>

<form method="POST">
    Category: <input type="text" name="category"><br>
    Description:<br>
    <textarea name="description"></textarea><br>
    <button type="submit">Submit Complaint</button>
</form>
