<!DOCTYPE html>
<html>
<head>
    <title>Conditional Multi-Select Dropdown</title>
    <style>
        #options-dropdown {
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<form method="post" action="submit.php">
    <label>Did you find the session helpful?</label><br>

    <input type="checkbox" id="yes" name="response" value="yes" onclick="toggleDropdown('yes')"> Yes<br>
    <input type="checkbox" id="no" name="response" value="no" onclick="toggleDropdown('no')"> No<br>

    <div id="options-dropdown">
        <label>Select reasons (you can choose multiple):</label><br>
        <select name="reason[]" multiple size="6">
            <option value="clarity">Clarity of explanation</option>
            <option value="content">Quality of content</option>
            <option value="engaging">Engaging session</option>
            <option value="materials">Useful materials</option>
            <option value="interaction">Good interaction</option>
            <option value="others">Others</option>
        </select>
    </div>

    <br><br>
    <input type="submit" value="Submit">
</form>

<script>
function toggleDropdown(choice) {
    const yesCheckbox = document.getElementById('yes');
    const noCheckbox = document.getElementById('no');
    const dropdown = document.getElementById('options-dropdown');

    if (choice === 'yes') {
        noCheckbox.checked = false;
        dropdown.style.display = 'block';
    } else {
        yesCheckbox.checked = false;
        dropdown.style.display = 'none';
    }
}
</script>

</body>
</html>
