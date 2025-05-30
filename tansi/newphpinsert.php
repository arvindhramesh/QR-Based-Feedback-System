<?php
$conn = oci_connect('tans', 'tans', 'tans');

// Fetch distinct DISCIPLINE values for the datalist
$disc_query = "SELECT DISTINCT DISCIPLINE FROM TANS.PHD_TN1 WHERE DISCIPLINE IS NOT NULL ORDER BY DISCIPLINE";
$disc_stmt = oci_parse($conn, $disc_query);
oci_execute($disc_stmt);

$query = "SELECT SLNO,
  REGNO,
  SCHOLAR,
  REGDT,
  GENDER,
  TIMESTATUS,
  DISCIPLINE,
  NAME_INST,
  COMMUNITY,
  SCH_MOBILE,
  SCH_MAIL,
  GUIDE,
  GUIDE_MOBILE,
  GUIDE_MAIL
  FROM TANS.PHD_TN1";
$statement = oci_parse($conn, $query);
oci_execute($statement);
?>

<style>
  .form-container {
    background: #f0f0f0;
    padding: 10px;
    max-width: 700px;
    margin: auto;
    border-radius: 6px;
    font-family: Arial, sans-serif;
    font-size: 12px;
  }

  .form-container h3 {
    text-align: center;
    font-size: 14px;
    margin-bottom: 10px;
  }

  .form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  .form-group {
    flex: 1;
    min-width: 200px;
    margin-bottom: 8px;
  }

  .form-group label {
    display: block;
    margin-bottom: 2px;
    font-weight: bold;
  }

  .form-group input,
  .form-group select,
  .form-group textarea {
    width: 100%;
    padding: 4px;
    font-size: 12px;
    border: 1px solid #aaa;
    border-radius: 3px;
  }

  .form-group textarea {
    resize: vertical;
  }

  .form-group button {
    width: 100%;
    padding: 6px;
    background: #007acc;
    color: white;
    border: none;
    border-radius: 3px;
    font-size: 12px;
    cursor: pointer;
  }

  .form-group button:hover {
    background: #005b99;
  }
</style>

<div class="form-container">
  <h3>Add New Record</h3>
  <form method="POST" action="add_record.php">
    <div class="form-row">
      <div class="form-group">
        <label>REGNO</label>
        <input type="text" name="REGNO" required>
      </div>

      <div class="form-group">
        <label>SCHOLAR</label>
        <textarea name="SCHOLAR" rows="2"></textarea>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>REGDT</label>
        <input type="date" name="REGDT">
      </div>

      <div class="form-group">
        <label>GENDER</label>
        <select name="GENDER">
          <option value="">Select</option>
          <option value="MALE">Male</option>
          <option value="FEMALE">Female</option>
        </select>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>TIMESTATUS</label>
        <input type="text" name="TIMESTATUS">
      </div>

      <div class="form-group">
        <label>DISCIPLINE</label>
        <input list="discipline_list" name="DISCIPLINE">
        <datalist id="discipline_list">
          <?php
          $disc_query = "SELECT DISTINCT DISCIPLINE FROM TANS.PHD_TN1 WHERE DISCIPLINE IS NOT NULL ORDER BY DISCIPLINE";
          $disc_stmt = oci_parse($conn, $disc_query);
          oci_execute($disc_stmt);
          while ($row = oci_fetch_assoc($disc_stmt)) {
            echo '<option value="' . htmlspecialchars($row['DISCIPLINE']) . '">';
          }
          ?>
        </datalist>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>NAME_INST</label>
        <textarea name="NAME_INST" rows="2"></textarea>
      </div>

      <div class="form-group">
        <label>COMMUNITY</label>
        <select name="COMMUNITY">
          <option value="">Select</option>
          <option value="BC">BC</option>
          <option value="MBC">MBC</option>
          <option value="SC">SC</option>
          <option value="ST">ST</option>
          <option value="OC">OC</option>
        </select>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>SCH_MOBILE</label>
        <input type="text" name="SCH_MOBILE">
      </div>

      <div class="form-group">
        <label>SCH_MAIL</label>
        <input type="email" name="SCH_MAIL">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>GUIDE</label>
        <textarea name="GUIDE" rows="2"></textarea>
      </div>

      <div class="form-group">
        <label>GUIDE_MOBILE</label>
        <input type="text" name="GUIDE_MOBILE">
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label>GUIDE_MAIL</label>
        <input type="email" name="GUIDE_MAIL">
      </div>
    </div>

    <div class="form-group">
      <button type="submit">Add Record</button>
    </div>
  </form>
</div>





<!-- Scrollable container -->
<div style="max-height: 400px; overflow: auto; margin-top: 20px; border: 1px solid #ccc;">
  <table border="1" style="width: 100%; border-collapse: collapse;">
    <thead>
      <tr>
        <th>SLNO</th>
        <th>REGNO</th>
        <th>SCHOLAR</th>
        <th>REGDT</th>
        <th>GENDER</th>
        <th>TIMESTATUS</th>
        <th>DISCIPLINE</th>
        <th>NAME_INST</th>
        <th>COMMUNITY</th>
        <th>SCH_MOBILE</th>
        <th>SCH_MAIL</th>
        <th>GUIDE</th>
        <th>GUIDE_MOBILE</th>
        <th>GUIDE_MAIL</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = oci_fetch_assoc($statement)) : ?>
        <tr>
          <?php foreach ($row as $cell) : ?>
            <td><?= htmlspecialchars($cell) ?></td>
          <?php endforeach; ?>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
