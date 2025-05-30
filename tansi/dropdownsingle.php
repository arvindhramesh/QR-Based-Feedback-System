<!DOCTYPE html>
<html>
<head>
    <title>Conditional Dropdown</title>
    <style>
        #options-dropdown {
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>


    <label>Did you find the session helpful?</label><br>

    <input type="checkbox" id="yes" name="response" value="yes" onclick="toggleDropdown('yes')"> Yes<br>
    <input type="checkbox" id="no" name="response" value="no" onclick="toggleDropdown('no')"> No<br>

    <div id="options-dropdown">
        <label>Select reason:</label>
        <select name="grievance" id="grievance">
            <option value="">-- Select --</option>
            <option value="7.5">7.5</option>
            <option value="SCHOLARSHIP">Scholarship</option>
            <option value="PMS">PMS</option>
            <option value="NAAN MUDHALVAN">Naan Mudhalvan/option>
            <option value="FEES COLLECTION">Fees Collection</option>
            </select>
    </div>
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
		document.getElementById('grievance').value='';}
}
</script>

</body>
</html>
