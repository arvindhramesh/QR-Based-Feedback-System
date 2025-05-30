<!DOCTYPE html>
<html>
<head>
  <title>Import PHD_TN1 Excel</title>
</head>
<body>
<?php include 'connection.php' ?>
  <h2>Upload Excel File for PHD_TN1</h2>
  <form action="upload.php" method="post" enctype="multipart/form-data">
    <label>Select Excel File: </label>
    <input type="file" name="excel_file" required />
    <br><br>
    <input type="submit" name="import" value="Import Data" />
  </form>
</body>
</html>
