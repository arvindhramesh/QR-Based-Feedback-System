<?php
session_start();
include 'inc/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = oci_parse($conn, "SELECT * FROM TANS.USERS WHERE EMAIL = :email");
    oci_bind_by_name($stmt, ":email", $email);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);
    if ($row && password_verify($password, $row['PASSWORD'])) {
        $_SESSION['user_id'] = $row['USER_ID'];
        $_SESSION['role'] = $row['ROLE'];

        if ($row['ROLE'] === 'admin') header("Location: dashboard_admin.php");
        elseif ($row['ROLE'] === 'staff') header("Location: dashboard_staff.php");
        else header("Location: dashboard_user.php");
        exit();
    } else {
        echo "Invalid login credentials.";
    }
}
?>

<form method="POST">
    Email: <input type="text" name="email"><br>
    Password: <input type="password" name="password"><br>
    <button type="submit">Login</button>
</form>
