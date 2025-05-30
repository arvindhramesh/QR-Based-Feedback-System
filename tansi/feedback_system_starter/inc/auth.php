<?php
session_start();
include 'inc/db_connect.php'; // Oracle DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepare SQL to fetch user by email
    $sql = "SELECT USER_ID, PASSWORD, ROLE FROM TANS.USERS WHERE EMAIL = :email";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":email", $email);
    oci_execute($stmt);

    $user = oci_fetch_assoc($stmt);

    if ($user && password_verify($password, $user['PASSWORD'])) {
        // Authentication successful
        $_SESSION['user_id'] = $user['USER_ID'];
        $_SESSION['role'] = strtolower($user['ROLE']);

        // Redirect based on role
        switch ($_SESSION['role']) {
            case 'admin':
                header("Location: dashboard_admin.php");
                break;
            case 'staff':
                header("Location: dashboard_staff.php");
                break;
            case 'user':
                header("Location: dashboard_user.php");
                break;
            default:
                echo "Unknown role.";
        }
        exit();
    } else {
        echo "<p style='color:red;'>Invalid login credentials.</p>";
    }
} else {
    echo "<p style='color:red;'>Invalid request method.</p>";
}
?>
