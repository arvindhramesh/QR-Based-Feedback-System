<!-- negative_feedback.php -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Negative Feedbacks - TNSCHE</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
   <style>
  body {
    font-family: Arial;
    background: #f0f8f5;
    padding: 20px;
  }

  h2 {
    text-align: center;
  }

  .summary {
    display: flex;
    justify-content: space-around;
    margin: 20px 0;
  }

   .card { background: #F88175; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center; }

  .chart-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 40px;
  }

  canvas {
    width: 100% !important;
    height: 200px !important;
  }
</style>

  </style>
</head>
<body>

<h2>Negative Feedback Summary</h2>
<div class="summary">
  <div class="card">
    <h3>Total no Feedbacks</h3>
    <p id="total-no">0</p>
  </div>
  <div class="card">
    <h3>Institution</h3>
    <p id="top-no-institution">-</p>
  </div>
</div>

<div class="chart-container">
  <canvas id="noHistogram"></canvas>
</div>

<script>
fetch('get_negative_feedback.php')
  .then(res => res.json())
  .then(data => {
    document.getElementById('total-no').textContent = data.total;
    document.getElementById('top-no-institution').textContent = data.top_institution;

    new Chart(document.getElementById('noHistogram').getContext('2d'), {
      type: 'bar',
      data: {
        labels: data.histogram.map(item => item.label),
        datasets: [{
          label: 'Negative Feedback Count',
          data: data.histogram.map(item => item.value),
          backgroundColor:'#F88175'
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  });
</script>

</body>
</html>
