<?php
require 'vendor/autoload.php';
require 'connection.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['import']) && isset($_FILES['excel_file'])) {
    $file = $_FILES['excel_file']['tmp_name'];

    $spreadsheet = IOFactory::load($file);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray(null, true, true, true);

    $rowCount = 0;
    foreach ($data as $index => $row) {
        if ($index == 1) continue; // skip header

        $sql = "INSERT INTO TANS.PHD_TN (
            SLNO, REGNO, SCHOLAR, REGDT, GENDER, TIMESTATUS, DISCIPLINE,
            NAME_INST, COMMUNITY, SCH_MOBILE, SCH_MAIL,
            GUIDE, GUIDE_MOBILE, GUIDE_MAIL, UNIVERSITY, UN_CODE
        ) VALUES (
            :SLNO, :REGNO, UPPER(:SCHOLAR), TO_DATE(:REGDT, 'DD-MM-YYYY'),
            UPPER(:GENDER), UPPER(:TIMESTATUS), UPPER(:DISCIPLINE), UPPER(:NAME_INST),
           UPPER( :COMMUNITY), :SCH_MOBILE, :SCH_MAIL,
            UPPER(:GUIDE), :GUIDE_MOBILE, :GUIDE_MAIL, UPPER(:UNIVERSITY), :UN_CODE
        )";

        $stid = oci_parse($conn, $sql);

        oci_bind_by_name($stid, ":SLNO", $row['A']);
        oci_bind_by_name($stid, ":REGNO", $row['B']);
        oci_bind_by_name($stid, ":SCHOLAR", $row['C']);
        oci_bind_by_name($stid, ":REGDT", $row['D']);
        oci_bind_by_name($stid, ":GENDER", $row['E']);
        oci_bind_by_name($stid, ":TIMESTATUS", $row['F']);
        oci_bind_by_name($stid, ":DISCIPLINE", $row['G']);
        oci_bind_by_name($stid, ":NAME_INST", $row['H']);
        oci_bind_by_name($stid, ":COMMUNITY", $row['I']);
        oci_bind_by_name($stid, ":SCH_MOBILE", $row['J']);
        oci_bind_by_name($stid, ":SCH_MAIL", $row['K']);
        oci_bind_by_name($stid, ":GUIDE", $row['L']);
        oci_bind_by_name($stid, ":GUIDE_MOBILE", $row['M']);
        oci_bind_by_name($stid, ":GUIDE_MAIL", $row['N']);
        oci_bind_by_name($stid, ":UNIVERSITY", $row['O']);
        oci_bind_by_name($stid, ":UN_CODE", $row['P']);

        
		$r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
        if (!$r) {
            $e = oci_error($stid);
            echo "Error at row $index: " . $e['message'] . "<br>";
			die;

        } else {
            $rowCount++;
        }
    }
    oci_commit($conn);
    echo "$rowCount rows imported successfully.";
}
?>
