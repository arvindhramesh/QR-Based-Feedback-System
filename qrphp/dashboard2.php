<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Feedback Dashboard - TNSCHE</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef3f8;
            padding: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
        }

        .summary {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .card {
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 10px;
            text-align: center;
        }

        .card h3 {
            margin: 0 0 10px;
            font-size: 1.2em;
        }

        canvas {
            max-width: 700px;
            margin: 0 auto 40px;
            display: block;
        }
		.sidebar a.active {
    font-weight: bold;
    background: #ddd;
    border-radius: 5px;
}

    </style>
</head>
<body>

<h2>TNSCHE Feedback Dashboard</h2>


<div class="summary">
    <div class="card">
        <h3>Total Feedbacks</h3>
        <p id="total-count">0</p>
    </div>
    <div style="color:#3F9;" class="card">
        <h3>Positive (YES)</h3>
        <p id="yes-count">0</p>
    </div>
    <div style="color:#F36;"   class="card">
        <h3>Negative (NO)</h3>
        <p id="no-count">0</p>
    </div>
</div>

<canvas id="categoryChart"></canvas>
<canvas id="statusPieChart"></canvas>
<h2>All Feedback Data</h2>
<div style="overflow-x: auto;">
    <table id="feedback-table" border="1" cellspacing="0" cellpadding="8" style="width:100%; border-collapse: collapse; background:#fff; margin-top: 20px;">
        <thead id="feedback-table-head">
            <!-- Will be populated dynamically -->
        </thead>
        <tbody id="feedback-table-body">
            <!-- Will be populated dynamically -->
        </tbody>
    </table>
</div>


<script>
fetch('get_dashboard_data.php')
  .then(res => res.json())
  .then(data => {
      document.getElementById("total-count").textContent = data.total;
      document.getElementById("yes-count").textContent = data.yes;
      document.getElementById("no-count").textContent = data.no;

      const ctx1 = document.getElementById('categoryChart').getContext('2d');
      new Chart(ctx1, {
          type: 'bar',
          data: {
              labels: data.category_distribution.map(d => d.label),
              datasets: [{
                  label: 'Feedback Count per Category',
                  data: data.category_distribution.map(d => d.value),
                  backgroundColor: 'rgba(54, 162, 235, 0.6)'
              }]
          },
          options: {
              responsive: true,
              plugins: {
                  legend: { display: false }
              },
              scales: {
                  y: { beginAtZero: true }
              }
          }
      });

      const ctx2 = document.getElementById('statusPieChart').getContext('2d');
      new Chart(ctx2, {
          type: 'pie',
          data: {
              labels: ['YES', 'NO'],
              datasets: [{
                  data: [data.yes, data.no],
                  backgroundColor: ['#4caf50', '#f44336']
              }]
          },
          options: {
              responsive: true,
              plugins: {
                  legend: {
                      position: 'top'
                  }
              }
          }
      });
	  
	  // After rendering charts...

const tableHead = document.getElementById('feedback-table-head');
const tableBody = document.getElementById('feedback-table-body');

if (data.all_feedback.length > 0) {
    // Generate table headers
    const headers = Object.keys(data.all_feedback[0]);
    let headRow = "<tr>";
    headers.forEach(key => {
        headRow += `<th>${key}</th>`;
    });
    headRow += "</tr>";
    tableHead.innerHTML = headRow;

    // Generate table body rows
    let bodyHTML = "";
    data.all_feedback.forEach(row => {
        bodyHTML += "<tr>";
        headers.forEach(key => {
            bodyHTML += `<td>${row[key] ?? ''}</td>`;
        });
        bodyHTML += "</tr>";
    });
    tableBody.innerHTML = bodyHTML;
} else {
    tableBody.innerHTML = "<tr><td colspan='100%'>No data available.</td></tr>";
}

  });
</script>

</body>
</html>
