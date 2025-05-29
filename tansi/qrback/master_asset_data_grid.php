<?php
// Oracle DB Connection
//$conn = oci_connect('your_username', 'your_password', 'your_host/service_name');
include 'connection.php';

// Fetch data from the table
$sql = "SELECT CAT_NAME, PARAMETER, QUESTIONS,  STATUS, GNDATE, TICKET, BLOCK FROM TANS.MASTER_ASSET_DATA where  TICKET is not null and status='NO'";
$stid = oci_parse($conn, $sql);
oci_execute($stid);
?>

<!DOCTYPE html>
<html>
<head>
    <title>MASTER_ASSET_DATA Grid</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        thead {
            background-color: #333;
            color: #fff;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        tbody tr:hover {
            background-color: #f5f5f5;
        }
        .details {
            display: none;
            background-color: #f9f9f9;
        }
        .expand-btn {
            cursor: pointer;
            color: blue;
        }
        .scrollable-container {
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #ccc;
        }
		
		.scrollable-container {
    max-height: 500px;
    overflow-y: auto;
    border: 1px solid #ccc;
    position: relative;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead th {
    position: sticky;
    top: 0;
    background-color: #333;
    color: #fff;
    z-index: 1; /* ensures it stays on top of scroll */
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
}

    </style>
    <script>
        function toggleDetails(index) {
            const row = document.getElementById('details-' + index);
            if (row.style.display === 'table-row') {
                row.style.display = 'none';
            } else {
                row.style.display = 'table-row';
            }
        }
    </script>
</head>
<body>

<h2>MASTER_ASSET_DATA Table</h2>

<div class="scrollable-container">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Category Name</th>
                <th>Parameter</th>
                <th>Question</th>
                <th>Status</th>
                <th>Ticket</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        while ($row = oci_fetch_assoc($stid)) {
            $catName = htmlspecialchars($row['CAT_NAME']);
            $param = htmlspecialchars($row['PARAMETER']);
            $question = htmlspecialchars($row['QUESTIONS']);
            $status = htmlspecialchars($row['STATUS']);
            $ticket = htmlspecialchars($row['TICKET']);
            $gndate = htmlspecialchars($row['GNDATE']);
            $block = htmlspecialchars($row['BLOCK']);

            echo "<tr>";
            echo "<td>{$i}</td>";
            echo "<td>{$catName}</td>";
            echo "<td>{$param}</td>";
            echo "<td>".substr($question,0,strrpos($question,'|')). "<br>" . substr($question,strrpos($question,'|')+1). "</td>";
            echo "<td>{$status}</td>";
            echo "<td>{$ticket}</td>";
			echo "<td><span class='expand-btn' onclick=\"updateGNDate('{$ticket}', {$i})\">View</span></td>";
            echo "</tr>";

            echo "<tr id='details-{$i}' class='details'>";
echo "<td colspan='7'>
        <strong>GNDATE:</strong> <span id='gndate-{$i}'>{$gndate}</span><br>
        <strong>BLOCK:</strong> {$block}
      </td>";
echo "</tr>";

            $i++;
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
oci_free_statement($stid);
oci_close($conn);
?>


<script>
function updateGNDate(ticket, index) {
    fetch("update_resolved.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: "ticket=" + encodeURIComponent(ticket)
    })
    .then(response => {
        if (!response.ok) throw new Error("HTTP status " + response.status);
        return response.text();
    })
    .then(result => {
        if (result.trim() === "success") {
            document.getElementById("row-" + index).remove();
            document.getElementById("details-" + index).remove();
        } else {
            alert("Failed to update GNDATE. Response: " + result);
        }
    })
    .catch(error => {
        alert("Error contacting server: " + error);
        console.error(error);
    });
}

</script>

