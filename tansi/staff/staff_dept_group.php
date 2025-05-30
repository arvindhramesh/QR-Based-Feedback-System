<?php
if (!isset($_GET['univer'])) exit;

$univer = $_GET['univer'];
include '../connection.php';

$sql = "
    SELECT DEPT, COUNT(*) AS STAFF_COUNT
    FROM TANS.TEACH_UNIVER
    WHERE UNIVER = :univer
    GROUP BY DEPT
    ORDER BY DEPT
";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ":univer", $univer);
oci_execute($stid);

echo "<table width='100%'>
        <tr>
            <th>Department</th>
            <th>Staff Count</th>
            <th>Action</th>
        </tr>";

while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    $dept = htmlspecialchars($row['DEPT']);
    echo "<tr>
            <td>{$dept}</td>
            <td>{$row['STAFF_COUNT']}</td>
            <td><button onclick=\"toggleStaff(this, '".htmlspecialchars($univer)."', '{$dept}')\">▶ View</button></td>
          </tr>
          <tr class='hidden-staff-row' style='display:none;'>
              <td colspan='3'>
                  <div class='sub-details-scroll sub-staff-list'></div>
              </td>
          </tr>";
}

echo "</table>";
?>

<script>
function toggleStaff(button, univer, dept) {
    var $btn = $(button);
    var $row = $btn.closest('tr').next('.hidden-staff-row');
    var $target = $row.find('.sub-staff-list');

    if ($row.is(':visible')) {
        $row.slideUp();
        $btn.text('▶ View');
    } else {
        if ($target.is(':empty')) {
            $.get("staff_details_list.php", { univer: univer, dept: dept }, function(data) {
                $target.html(data);
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
