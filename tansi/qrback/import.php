<?php
require 'vendor/autoload.php'; // PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

$conn = oci_connect("your_username", "your_password", "your_host/your_service");
if (!$conn) {
    $e = oci_error();
    die("DB Connection failed: " . $e['message']);
}

if (isset($_POST['upload']) && isset($_FILES['excel_file'])) {
    $file = $_FILES['excel_file']['tmp_name'];

    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    // Skip header row
    for ($i = 1; $i < count($rows); $i++) {
        $r = $rows[$i];
        if (empty($r[0])) continue; // skip if SLNO is empty

        $sql = "INSERT INTO TANS.SCHOLARS (
            SLNO, REGNO, SCHOLAR, REGDT, GENDER, TIMESTATUS, DISCIPLINE, NAME_INST,
            COMMUNITY, SCH_MOBILE, SCH_MAIL, GUIDE, GUIDE_MOBILE, GUIDE_MAIL,
            UNIVERSITY, DTF
        ) VALUES (
            :slno, :regno, :scholar, TO_DATE(:regdt, 'YYYY-MM-DD'), :gender, :timestatus, :discipline, :name_inst,
            :community, :sch_mobile, :sch_mail, :guide, :guide_mobile, :guide_mail,
            :university, :dtf
        )";

        $stid = oci_parse($conn, $sql);
        oci_bind_by_name($stid, ':slno', $r[0]);
        oci_bind_by_name($stid, ':regno', $r[1]);
        oci_bind_by_name($stid, ':scholar', $r[2]);
        oci_bind_by_name($stid, ':regdt', $r[3]); // Must be YYYY-MM-DD in Excel
        oci_bind_by_name($stid, ':gender', $r[4]);
        oci_bind_by_name($stid, ':timestatus', $r[5]);
        oci_bind_by_name($stid, ':discipline', $r[6]);
        oci_bind_by_name($stid, ':name_inst', $r[7]);
        oci_bind_by_name($stid, ':community', $r[8]);
        oci_bind_by_name($stid, ':sch_mobile', $r[9]);
        oci_bind_by_name($stid, ':sch_mail', $r[10]);
        oci_bind_by_name($stid, ':guide', $r[11]);
        oci_bind_by_name($stid, ':guide_mobile', $r[12]);
        oci_bind_by_name($stid, ':guide_mail', $r[13]);
        oci_bind_by_name($stid, ':university', $r[14]);
        oci_bind_by_name($stid, ':dtf', $r[15]);

        if (!oci_execute($stid)) {
            $err = oci_error($stid);
            echo "Error inserting row " . ($i+1) . ": " . $err['message'] . "<br>";
        }
    }

    echo "Excel import completed.";
}
?>
