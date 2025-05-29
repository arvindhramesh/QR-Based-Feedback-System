<?php
// Brevo API key
$apiKey = "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"; // Replace with your actual API key
$senderEmail = "arvindhjeswin@gmail.com"; // Replace with your verified sender email
$commonMessage = "Thank you for being part of our community. Stay connected with us for more updates.";

// Open CSV file


$name="ramesh";
$email ="arvindhramesh@gmail.com";
		

       $payload = array(
    "sender" => array("email" => $senderEmail),
    "to" => array(
        array(
            "email" => $email,
            "name" => $name
        )
    ),
    "subject" => "A Message from Aravindh",
    "textContent" => "Dear " . $name . ",\n\n" . $commonMessage . "\n\nRegards,\nAravindh"
);

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

        if ($httpcode == 201) {
            echo " Email sent to $name ($email)\n";
        } else {
            echo " Failed to send email to $name ($email) - HTTP $httpcode\n";
            echo "Response: $response\n";
        }

        curl_close($ch);


    fclose($handle);
 

?>
