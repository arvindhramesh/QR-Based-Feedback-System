<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Institution List - TNSCHE</title>

    <!-- Bootstrap CSS (optional but looks better) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- jQuery + DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <style>
        body {
            background-color: #f4f6f9;
            padding: 30px;
        }

        .container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Institution List</h2>
    <table id="institutionTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Institution Name</th>
            </tr>
        </thead>
        <tbody>
        <?php
       // $conn = oci_connect("tans", "tans", "tans");
	   include 'connection.php';
        if (!$conn) {
            $e = oci_error();
            die("Connection failed: " . $e['message']);
        }

        $query = "SELECT unname INS_NAME FROM TANS.university ORDER BY 1";
        $stid = oci_parse($conn, $query);
        oci_execute($stid);

        while ($row = oci_fetch_assoc($stid)) {
            $ins = htmlspecialchars($row['INS_NAME']);
            echo "<tr><td>$ins</td></tr>";
        }

        oci_free_statement($stid);
        oci_close($conn);
        ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#institutionTable').DataTable({
        "pageLength": 10,
        "lengthChange": false
    });
});
</script>

</body>
</html>
