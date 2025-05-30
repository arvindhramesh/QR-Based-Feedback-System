
<!DOCTYPE html>
<html>
<head>

    <title>Scholar Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 30px;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 700px;
            box-shadow: 0 0 10px #aaa;
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-top: 3px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn-group {
            margin-top: 15px;
            text-align: center;
        }
        input[type="submit"] {
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            background-color: #5cb85c;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            opacity: 0.9;
        }
        .delete {
            background-color: #d9534f;
        }
        .update {
            background-color: #f0ad4e;
        }
        .search {
            background-color: #0275d8;
        }
		table {
        margin-top: 20px;
        width: 100%;
        border: 1px solid #ccc;
    }
    th {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
    }
    td {
        padding: 8px;
        text-align: center;
    }
    </style>
</head>
<body>

<h2>Scholar Information Form</h2>
<form method="post" action="process.php">
    <label>SLNO</label>
    <input type="text" name="slno" required>

    <label>Reg No</label>
    <input type="text" name="regno">

    <label>Scholar Name</label>
    <input type="text" name="scholar">

    <label>Registration Date</label>
    <input type="date" name="regdt">

    <label>Gender</label>
    <input type="text" name="gender">

    <label>Time Status</label>
    <input type="text" name="timestatus">

    <label>Discipline</label>
    <input type="text" name="discipline">

    <label>Institution Name</label>
    <input type="text" name="name_inst">

    <label>Community</label>
    <input type="text" name="community">

    <label>Scholar Mobile</label>
    <input type="text" name="sch_mobile">

    <label>Scholar Email</label>
    <input type="email" name="sch_mail">

    <label>Guide</label>
    <input type="text" name="guide">

    <label>Guide Mobile</label>
    <input type="text" name="guide_mobile">

    <label>Guide Email</label>
    <input type="email" name="guide_mail">

    <label>University</label>
    <input type="text" name="university">

    <label>DTF</label>
    <input type="text" name="dtf">

    <div class="btn-group">
        <input type="submit" name="insert" value="Insert">
        <input type="submit" name="update" class="update" value="Update">
        <input type="submit" name="delete" class="delete" value="Delete">
        <input type="submit" name="search" class="search" value="Search">
    </div>
</form>

</body>
</html>
