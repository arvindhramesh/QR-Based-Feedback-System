<?php
include 'inc/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = oci_parse($conn, "INSERT INTO TANS.USERS (NAME, EMAIL, PASSWORD, ROLE) VALUES (:name, :email, :pass, :role)");
    oci_bind_by_name($stmt, ":name", $name);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":pass", $password);
    oci_bind_by_name($stmt, ":role", $role);

    if (oci_execute($stmt)) {
        echo "User registered successfully.";
    } else {
        echo "Registration failed.";
    }
}
?>

<form method="POST">
    Name: <input type="text" name="name"><br>
    Email: <input type="email" name="email"><br>
    Password: <input type="password" name="password"><br>
    Role: 
    <select name="role">
        <option value="user">User</option>
        <option value="staff">Staff</option>
    </select><br>
    <button type="submit">Register</button>
</form>
