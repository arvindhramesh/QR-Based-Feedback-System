<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
</head>
<body>
    <h2>Send a Message</h2>
    <form action="send_email.php" method="POST">
        <label>Name: <input type="text" name="name" required></label><br><br>
        <label>Email: <input type="email" name="email" required></label><br><br>
        <label>Subject: <input type="text" name="subject" required></label><br><br>
        <label>Message:<br>
            <textarea name="message" rows="6" cols="40" required></textarea>
        </label><br><br>
        <input type="submit" value="Send Email">
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Brevo API key
    $apiKey = "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"; // Replace with your real API key
    $senderEmail = "arvindhjeswin@gmail.com"; // Must be a verified sender on Brevo

    // Get form data (sanitize)
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = nl2br(htmlspecialchars($_POST['message']));

    // Build email content
    $htmlContent = "<p>Dear $name,</p><p>$message</p><p>Regards,<br>Aravindh</p>";

    // Prepare API payload
    $payload = array(
        "sender" => array("email" => $senderEmail),
        "to" => array(
            array(
                "email" => $email,
                "name" => $name
            )
        ),
        "subject" => $subject,
        "htmlContent" => $htmlContent
    );

    // Send email using Brevo
    $ch = curl_init("https://api.brevo.com/v3/smtp/email");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "accept: application/json",
        "content-type: application/json",
        "api-key: " . $apiKey
    ));

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode == 201) {
        echo "Email sent successfully to $name ($email)";
    } else {
        echo "Failed to send email. HTTP $httpcode<br>Response: $response";
    }
} 
?>
