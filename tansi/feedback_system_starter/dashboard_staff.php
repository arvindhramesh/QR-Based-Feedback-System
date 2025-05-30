<?php
session_start();
include 'inc/db_connect.php';

if ($_SESSION['role'] != 'staff') {
    exit("Unauthorized access");
}

$staff_id = $_SESSION['user_id'];

// Update complaint if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comp_id = $_POST['comp_id'];
    $status = $_POST['status'];
    $resolution = $_POST['resolution'];

    $stmt = oci_parse($conn, "UPDATE TANS.COMPLAINTS 
        SET STATUS = :status, RESOLUTION = :res, DATE_RESOLVED = SYSDATE 
        WHERE COMP_ID = :id AND ASSIGNED_TO = :sid");

    oci_bind_by_name($stmt, ":status", $status);
    oci_bind_by_name($stmt, ":res", $resolution);
    oci_bind_by_name($stmt, ":id", $comp_id);
    oci_bind_by_name($stmt, ":sid", $staff_id);
    
    oci_execute($stmt);
    echo "<p>Complaint updated.</p>";
}

// Show assigned complaint
