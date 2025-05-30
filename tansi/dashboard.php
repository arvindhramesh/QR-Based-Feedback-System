<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - TNSCHE</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f5f5f5;
      padding: 20px;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
    }

    .summary, .charts, .table-section {
      background: white;
      padding: 20px;
      margin-bottom: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .summary {
      display: flex;
      justify-content: space-around;
      text-align: center;
    }

    .summary div {
      flex: 1;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #004080;
      color: white;
    }

    canvas {
      max-width: 600px;
      margin: auto;
    }
  </style>
</head>
<body>

  <h1>TNSCHE Feedback Dashboard</h1>

  <div class="summary">
    <div>
      <h2>Total Responses</h2>
      <p id="total-responses">0</p>
    </div>
    <div>
      <h2>Yes Responses</h2>
      <p id="yes-count">0</p>
    </div>
    <div>
      <h2>No Responses</h2>
      <p id="no-count">0</p>
    </div>
  </div>

  <div class="charts">
    <h2>Responses by Question</h2>
    <canvas id="barChart"></canvas>
  </div>

  <div class="charts">
    <h2>Overall Yes vs No</h2>
    <canvas id="pieChart"></canvas>
  </div>

  <div class="table-section">
    <h2>All Responses</h2>
    <table>
      <thead>
        <tr>
          <th>Question</th>
          <th>Status</th>
          <th>Category</th>
        </tr>
      </thead>
      <tbody id="response-table">
        <!-- Data will be inserted here -->
      </tbody>
    </table>
  </div>

  <script>
    const data = [
      { question: "IS THERE ENOUGH SEATING IN THE CLASSROOM", status: "NO", category: 15 },
      { question: "IS THE RESTROOM CLEANED AND MAINTAINED PROPERLY?", status: "YES", category: 16 },
      { question: "IS THERE SUFFICIENT WATER FACILITY ACCESSIBLE?", status: "NO", category: 16 },
      { question: "IS THE RESTROOM CLEANED AND MAINTAINED PROPERLY?", status: "YES", category: 16 },
      { question: "IS THERE SUFFICIENT WATER FACILITY ACCESSIBLE?", status: "NO", category: 16 },
      { question: "IS THERE PROPER LIGHTING IN THE CLASSROOM", status: "YES", category: 15 },
      { question: "IS THERE ENOUGH SEATING IN THE CLASSROOM", status: "NO", category: 15 },
      { question: "IS THE FOOD SERVED INGOOD QUALITY ?", status: "YES", category: 14 },
      // ... repeat pattern for rest of entries
    ];

    // Fill remaining entries (cut for brevity)
    for (let i = 0; i < 25; i++) {
      data.push({ question: "IS THE FOOD SERVED INGOOD QUALITY ?", status: "YES", category: 14 });
      data.push({ question: "IS THERE ENOUGH SEATING AVAILABLE?", status: "NO", category: 14 });
    }

    // Update counts
    document.getElementById("total-responses").textContent = data.length;
    document.getElementById("yes-count").textContent = data.filter(d => d.status === "YES").length;
    document.getElementById("no-count").textContent = data.filter(d => d.status === "NO").length;

    // Populate table
    const tbody = document.getElementById("response-table");
    data.forEach(entry => {
      const row = `<tr>
        <td>${entry.question}</td>
        <td>${entry.status}</td>
        <td>${entry.category}</td>
      </tr>`;
      tbody.insertAdjacentHTML("beforeend", row);
    });

    // Prepare bar chart data
    const questionGroups = {};
    data.forEach(entry => {
      if (!questionGroups[entry.question]) questionGroups[entry.question] = { YES: 0, NO: 0 };
      questionGroups[entry.question][entry.status]++;
    });

    const questions = Object.keys(questionGroups);
    const yesCounts = questions.map(q => questionGroups[q].YES || 0);
    const noCounts = questions.map(q => questionGroups[q].NO || 0);

    new Chart(document.getElementById("barChart"), {
      type: "bar",
      data: {
        labels: questions,
        datasets: [
          { label: "Yes", data: yesCounts, backgroundColor: "#4CAF50" },
          { label: "No", data: noCounts, backgroundColor: "#F44336" }
        ]
      },
      options: {
        responsive: true,
        scales: {
          x: { ticks: { autoSkip: false, maxRotation: 90, minRotation: 60 } },
          y: { beginAtZero: true }
        }
      }
    });

    // Pie Chart
    new Chart(document.getElementById("pieChart"), {
      type: "pie",
      data: {
        labels: ["Yes", "No"],
        datasets: [{
          data: [data.filter(d => d.status === "YES").length, data.filter(d => d.status === "NO").length],
          backgroundColor: ["#4CAF50", "#F44336"]
        }]
      }
    });
  </script>

</body>
</html>
