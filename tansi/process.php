<?php
$conn = oci_connect("tans", "tans", "tans");

if (!$conn) {
    $e = oci_error();
    die("Connection failed: " . $e['message']);
}

function bindFields($stid, $data) {
    foreach ($data as $key => $val) {
        oci_bind_by_name($stid, ":$key", $data[$key]);
    }
}

$data = array (
    'slno' => $_POST['slno'],
    'regno' => $_POST['regno'],
    'scholar' => $_POST['scholar'],
    'regdt' => $_POST['regdt'],
    'gender' => $_POST['gender'],
    'timestatus' => $_POST['timestatus'],
    'discipline' => $_POST['discipline'],
    'name_inst' => $_POST['name_inst'],
    'community' => $_POST['community'],
    'sch_mobile' => $_POST['sch_mobile'],
    'sch_mail' => $_POST['sch_mail'],
    'guide' => $_POST['guide'],
    'guide_mobile' => $_POST['guide_mobile'],
    'guide_mail' => $_POST['guide_mail'],
    'university' => $_POST['university'],
    'dtf' => $_POST['dtf'],
);

if (isset($_POST['insert'])) {
    $sql = "INSERT INTO SCHOLARS (
        SLNO, REGNO, SCHOLAR, REGDT, GENDER, TIMESTATUS, DISCIPLINE, NAME_INST,
        COMMUNITY, SCH_MOBILE, SCH_MAIL, GUIDE, GUIDE_MOBILE, GUIDE_MAIL,
        UNIVERSITY, DTF
    ) VALUES (
        :slno, :regno, :scholar, TO_DATE(:regdt, 'YYYY-MM-DD'), :gender, :timestatus, :discipline, :name_inst,
        :community, :sch_mobile, :sch_mail, :guide, :guide_mobile, :guide_mail,
        :university, :dtf
    )";

    $stid = oci_parse($conn, $sql);
    bindFields($stid, $data);
    $exec = oci_execute($stid);
    if ($exec) {
        echo "Insert successful.";
    } else {
        $e = oci_error($stid);
        echo "Insert Error: " . $e['message'];
    }
}

elseif (isset($_POST['update'])) {
    $sql = "UPDATE SCHOLARS SET
        REGNO = :regno,
        SCHOLAR = :scholar,
        REGDT = TO_DATE(:regdt, 'YYYY-MM-DD'),
        GENDER = :gender,
        TIMESTATUS = :timestatus,
        DISCIPLINE = :discipline,
        NAME_INST = :name_inst,
        COMMUNITY = :community,
        SCH_MOBILE = :sch_mobile,
        SCH_MAIL = :sch_mail,
        GUIDE = :guide,
        GUIDE_MOBILE = :guide_mobile,
        GUIDE_MAIL = :guide_mail,
        UNIVERSITY = :university,
        DTF = :dtf
        WHERE SLNO = :slno";

    $stid = oci_parse($conn, $sql);
    bindFields($stid, $data);
    $exec = oci_execute($stid);
    if ($exec) {
        echo "Update successful.";
    } else {
        $e = oci_error($stid);
        echo "Update Error: " . $e['message'];
    }
}

elseif (isset($_POST['delete'])) {
    $sql = "DELETE FROM SCHOLARS WHERE SLNO = :slno";
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':slno', $data['slno']);
    $exec = oci_execute($stid);
    if ($exec) {
        echo "Delete successful.";
    } else {
        $e = oci_error($stid);
        echo "Delete Error: " . $e['message'];
    }
}

elseif (isset($_POST['search'])) {
    $sql = "SELECT * FROM SCHOLARS WHERE SLNO = :slno";
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':slno', $data['slno']);
    $exec = oci_execute($stid);
    if ($exec) {
        $row = oci_fetch_assoc($stid);
        if ($row) {
            
			
			
			echo "<h2>Search Result</h2>";
echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; font-family: Arial, sans-serif;'>";
echo "<tr style='background-color: #f2f2f2;'>";
foreach ($row as $key => $value) {
    echo "<th>$key</th>";
}
echo "</tr><tr>";
foreach ($row as $value) {
    echo "<td>" . htmlspecialchars(isset($value) ? $value : '') . "</td>";
}
echo "</tr></table>";

        } else {
            echo "No record found for SLNO " . htmlspecialchars($data['slno']);
        }
    } else {
        $e = oci_error($stid);
        echo "Search Error: " . $e['message'];
    }
}

oci_free_statement($stid);
oci_close($conn);
?>
