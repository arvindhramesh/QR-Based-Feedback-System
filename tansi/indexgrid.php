<?php include 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>PhD Scholar DataGrid</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #888; padding: 6px; }
        th { background: #eee; }
        form input { margin: 5px; }
    </style>
</head>
<body>

<h2>PhD Scholar DataGrid</h2>

<!-- Filter -->
<form method="get">
    <input type="text" name="regno" placeholder="Filter by REGNO" value="<?= $_GET['regno'] ?? '' ?>">
    <input type="text" name="scholar" placeholder="Filter by SCHOLAR" value="<?= $_GET['scholar'] ?? '' ?>">
    <button type="submit">Filter</button>
    <a href="index.php">Clear</a>
</form>

<!-- Form for Add/Edit -->
<h3 id="formTitle">Add / Edit Scholar</h3>
<form method="post" action="save.php">
    <input type="hidden" name="slno" id="slno">
    <input type="text" name="regno" id="regno" placeholder="REGNO" required>
    <input type="text" name="scholar" id="scholar" placeholder="SCHOLAR" required>
    <input type="text" name="discipline" id="discipline" placeholder="DISCIPLINE">
    <button type="submit">Save</button>
</form>

<!-- Data Grid -->
<table>
    <thead>
        <tr>
            <th>SLNO</th>
            <th>REGNO</th>
            <th>SCHOLAR</th>
            <th>DISCIPLINE</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $regno = $_GET['regno'] ?? '';
        $scholar = $_GET['scholar'] ?? '';
        $where = [];

        if ($regno) $where[] = "UPPER(REGNO) LIKE UPPER('%$regno%')";
        if ($scholar) $where[] = "UPPER(SCHOLAR) LIKE UPPER('%$scholar%')";

        $sql = "SELECT * FROM PHD_TN1";
        if ($where) $sql .= " WHERE " . implode(" AND ", $where);
        $sql .= " ORDER BY SLNO";

        $stmt = oci_parse($conn, $sql);
        oci_execute($stmt);

        $count = 0;
        while ($row = oci_fetch_assoc($stmt)) {
            $count++;
            echo "<tr>";
            echo "<td>{$row['SLNO']}</td>";
            echo "<td>{$row['REGNO']}</td>";
            echo "<td>{$row['SCHOLAR']}</td>";
            echo "<td>{$row['DISCIPLINE']}</td>";
            echo "<td>
                <button onclick='editRecord(" . json_encode($row) . ")'>Edit</button>
                <a href='delete.php?slno={$row['SLNO']}' onclick='return confirm(\"Delete record?\")'>Delete</a>
            </td>";
            echo "</tr>";
        }
    ?>
    </tbody>
</table>

<p>Total Records: <?= $count ?></p>

<script>
function editRecord(data) {
    document.getElementById('formTitle').innerText = 'Edit Scholar';
    document.getElementById('slno').value = data.SLNO;
    document.getElementById('regno').value = data.REGNO;
    document.getElementById('scholar').value = data.SCHOLAR;
    document.getElementById('discipline').value = data.DISCIPLINE;
}
</script>

</body>
</html>
