<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Custom Styling -->
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9f9f9;
        padding: 40px;
    }

    label {
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
        font-size: 16px;
        color: #333;
    }

    .select-container {
        max-width: 400px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .select2-container .select2-selection--single {
        height: 45px;
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 8px 12px;
        font-size: 15px;
        background-color: #fff;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px;
        color: #333;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
        right: 10px;
    }
</style>

<div class="select-container">
    <label for="INS_NAME">Select Institution:</label>
    <select name="INS_NAME" id="INS_NAME" style="width: 100%;" required>
        <option value="" disabled selected>-- Choose Institution --</option>
        <?php
        $conn = oci_connect("tans", "tans", "tans");
        $query = "SELECT unname INS_NAME FROM TANS.university ORDER BY 1";
        $stid1 = oci_parse($conn, $query);
        oci_execute($stid1);
        while ($row = oci_fetch_assoc($stid1)) {
            $ins = htmlspecialchars($row['INS_NAME']);
            echo "<option value=\"$ins\">$ins</option>";
        }
        oci_free_statement($stid1);
        oci_close($conn);
        ?>
    </select>
</div>

<script>
$(document).ready(function() {
    $('#INS_NAME').select2({
        placeholder: "-- Choose Institution --",
        allowClear: true
    });
});
</script>
