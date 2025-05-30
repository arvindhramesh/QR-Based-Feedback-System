<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$apiKey = "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"; // Replace with your actual API key

$url = "https://api.brevo.com/v3/smtp/emails";

// Optional query parameters (you can add more like limit, offset, etc.)
$queryParams = http_build_query([
    'limit' => 10, // Number of emails to fetch
]);

$ch = curl_init("$url?$queryParams");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "accept: application/json",
    "api-key: " . $apiKey
));

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Display the results
if ($httpcode == 200) {
    $data = json_decode($response, true);

    echo "<h2>Sent Emails (Last 10)</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>To</th><th>Subject</th><th>Date</th><th>Status</th></tr>";

    if (!empty($data['emails'])) {
        foreach ($data['emails'] as $email) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($email['to'][0]['email'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($email['subject'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($email['date'] ?? '') . "</td>";
            echo "<td>" . htmlspecialchars($email['event'] ?? '') . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No sent emails found.</td></tr>";
    }

    echo "</table>";
} else {
    echo "Failed to fetch sent emails. HTTP $httpcode<br>Response: $response";
}
?>

</body>
</html>