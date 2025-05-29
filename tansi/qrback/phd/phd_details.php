<?php
if (!isset($_GET['un_code'])) exit;

$un_code = $_GET['un_code'];
include '../connection.php';

$sql = "
    SELECT DISCIPLINE, COUNT(*) AS PHD_COUNT
    FROM TANS.PHD_TN
    WHERE UN_CODE = :un_code
    GROUP BY DISCIPLINE
    ORDER BY DISCIPLINE
";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ":un_code", $un_code);
oci_execute($stid);

echo "<table width='100%'>
        <tr>
            <th>Discipline</th>
            <th>PhD Count</th>
            <th>Action</th>
        </tr>";

while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    $discipline = htmlspecialchars($row['DISCIPLINE']);
    echo "<tr>
            <td>{$discipline}</td>
            <td>{$row['PHD_COUNT']}</td>
            <td><button onclick=\"toggleScholars(this, '{$un_code}', '{$discipline}')\">▶ View</button></td>
          </tr>
          <tr class='hidden-scholar-row' style='display:none;'>
              <td colspan='3'>
                  <div class='sub-details-scroll sub-scholar-list'></div>
              </td>
          </tr>";
}

echo "</table>";
?>

<script>
function toggleScholars(button, un_code, discipline) {
    var $btn = $(button);
    var $row = $btn.closest('tr').next('.hidden-scholar-row');
    var $target = $row.find('.sub-scholar-list');

    if ($row.is(':visible')) {
        $row.slideUp();
        $btn.text('▶ View');
    } else {
        if ($target.is(':empty')) {
            $.get("phd_scholar_list.php", { un_code: un_code, discipline: discipline }, function(data) {
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
