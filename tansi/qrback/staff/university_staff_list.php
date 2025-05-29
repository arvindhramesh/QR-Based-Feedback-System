<?php
include '../connection.php';

$query = "
    SELECT 
        U.AISHECD, 
        U.UNNAME, 
        U.DISTRICT,
        (SELECT COUNT(*) FROM TANS.TEACH_UNIVER TU WHERE TU.UNIVER = AISHECD) AS STAFF_COUNT
    FROM TANS.UNIVERSITY U
    ORDER BY U.ORD
";

$stid = oci_parse($conn, $query);
oci_execute($stid);
?>

<!DOCTYPE html>
<html>
<head>
    <title>University Staff List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
        .sub-details-scroll {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 8px;
            background: #f9f9f9;
        }
        .hidden-row {
            display: none;
        }
        th {
            background-color: #f0f0f0;
        }
        button {
            padding: 4px 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>University Staff List</h2>

<table>
    <tr>
        <th>AISHE Code</th>
        <th>University Name</th>
        <th>District</th>
        <th>Staff Count</th>
        <th>Action</th>
    </tr>

    <?php while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) { ?>
        <tr>
            <td><?= htmlspecialchars($row['AISHECD']) ?></td>
            <td><?= htmlspecialchars($row['UNNAME']) ?></td>
            <td><?= htmlspecialchars($row['DISTRICT']) ?></td>
            <td><?= htmlspecialchars($row['STAFF_COUNT']) ?></td>
            <td><button onclick="toggleDetails(this, '<?= $row['AISHECD'] ?>')">▶ View</button></td>
        </tr>
        <tr class="hidden-row">
            <td colspan="5">
                <div class="sub-details-scroll"></div>
            </td>
        </tr>
    <?php } ?>
</table>

<script>
function toggleDetails(button, univer) {
    var $btn = $(button);
    var $row = $btn.closest('tr').next('.hidden-row');
    var $content = $row.find('.sub-details-scroll');

    if ($row.is(':visible')) {
        $row.slideUp();
        $btn.text('▶ View');
    } else {
        if ($content.is(':empty')) {
            $.get("staff_dept_group.php", { univer: univer }, function(data) {
                $content.html(data);
                $row.slideDown();
                $btn.text('▼ Hide');
            });
        } else {
            $row.slideDown();
            $btn.text('▼ Hide');
        }
    }
}
</script>

</body>
</html>
