<?php
session_start();
include 'inc/db_connect.php';

// Only staff/admin should access this
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'admin')) {
    die("Access denied.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comp_id = $_POST['comp_id'];
    $resolution = trim($_POST['resolution']);
    $staff_id = $_SESSION['user_id'];

    $sql = "UPDATE TANS.COMPLAINTS 
            SET STATUS = 'Resolved',
                RESOLUTION = :res,
                ASSIGNED_TO = :sid,
                DATE_RESOLVED = SYSDATE
            WHERE COMP_ID = :cid";

    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":res", $resolution);
    oci_bind_by_name($stmt, ":sid", $staff_id);
    oci_bind_by_name($stmt, ":cid", $comp_id);

    if (oci_execute($stmt)) {
        echo "<p style='color:green;'>Complaint #$comp_id marked as resolved.</p>";
    } else {
        $e = oci_error($stmt);
        echo "<p style='color:red;'>Error: " . htmlentities($e['message']) . "</p>";
    }
}

// Show unresolved complaints
$sql = "SELECT C.COMP_ID, U.NAME AS USER_NAME, C.CATEGORY, C.DESCRIPTION, C.STATUS
        FROM TANS.COMPLAINTS C
        JOIN TANS.USERS U ON C.USER_ID = U.USER_ID
        WHERE C.STATUS != 'Resolved'
        ORDER BY C.COMP_ID DESC";

$stmt = oci_parse($conn, $sql);
oci_execute($stmt);
?>

<h2>Unresolved Complaints</h2>

<?php while ($row = oci_fetch_assoc($stmt)) { ?>
    <form method="POST" action="">
        <div style="border:1px solid #ccc; padding:10px; margin:10px 0;">
            <strong>Complaint #<?= $row['COMP_ID'] ?></strong><br>
            <strong>User:</strong> <?= htmlentities($row['USER_NAME']) ?><br>
            <strong>Category:</strong> <?= htmlentities($row['CATEGORY']) ?><br>
            <strong>Description:</strong><br>
            <p><?= nl2br(htmlentities($row['DESCRIPTION'])) ?></p>
            <label>Resolution:</label><br>
            <textarea name="resolution" rows="3" cols="50" required></textarea><br>
            <input type="hidden" name="comp_id" value="<?= $row['COMP_ID'] ?>">
            <button type="submit">Mark as Resolved</button>
        </div>
    </form>
<?php } ?>
