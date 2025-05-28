<?php
//$conn = oci_connect("tans", "tans", "tans","AL32UTF8");
include 'connection.php';
if (!$conn) {
    $e = oci_error();
    die(json_encode(["error" => $e['message']]));
}

$data = [
    "total" => 0,
    "yes" => 0,
    "no" => 0,
    "category_distribution" => []
];

// Total feedback
$q1 = "SELECT count(max(cat_name)) AS TOTAL FROM tans.master_asset_data group by cat_name";
$s1 = oci_parse($conn, $q1);
oci_execute($s1);
$data["total"] = oci_fetch_assoc($s1)["TOTAL"];

// YES / NO count
$q2 = "SELECT status, COUNT(*) AS COUNT FROM tans.master_asset_data GROUP BY status";
$s2 = oci_parse($conn, $q2);
oci_execute($s2);
while ($row = oci_fetch_assoc($s2)) {
    if (strtoupper($row["STATUS"]) === "YES") $data["yes"] = $row["COUNT"];
    else if (strtoupper($row["STATUS"]) === "NO") $data["no"] = $row["COUNT"];
}

// Histogram: Category-wise feedback count
$q3 = "SELECT category, COUNT(*) AS COUNT FROM tans.master_asset_data GROUP BY category";
$s3 = oci_parse($conn, $q3);
oci_execute($s3);
while ($row = oci_fetch_assoc($s3)) {
    $data["category_distribution"][] = [
        "label" => $row["CATEGORY"],
        "value" => $row["COUNT"]
    ];
}

$q4 = "SELECT * FROM tans.master_asset_data";
$s4 = oci_parse($conn, $q4);
oci_execute($s4);

$rows = [];
while ($row = oci_fetch_assoc($s4)) {
    $rows[] = $row;
}
$data["all_feedback"] = $rows;

oci_free_statement($s1);
oci_free_statement($s2);
oci_free_statement($s3);
oci_free_statement($s4);


oci_close($conn);


header('Content-Type: application/json');
echo json_encode($data);
?>
