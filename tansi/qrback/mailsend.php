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
