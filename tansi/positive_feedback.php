<!-- positive_feedback.php -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Positive Feedbacks - TNSCHE</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: Arial; background: #f0f8f5; padding: 20px; }
    h2 { text-align: center; }
    .summary { display: flex; justify-content: space-around; margin: 20px 0; }
    .card { background: #e0f7ea; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; }
    canvas { max-width: 800px; margin: 0 auto 40px; display: block; }
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
</head>
<body>

<h2>Positive Feedback Summary</h2>
<div class="summary">
  <div class="card">
    <h3>Total YES Feedbacks</h3>
    <p id="total-yes">0</p>
  </div>
  <div class="card">
    <h3>Top Institution</h3>
    <p id="top-yes-institution">-</p>
  </div>
</div>

<div class="chart-container">
  <canvas id="yesHistogram"></canvas>
</div>

<script>
fetch('get_positive_feedback.php')
  .then(res => res.json())
  .then(data => {
    document.getElementById('total-yes').textContent = data.total;
    document.getElementById('top-yes-institution').textContent = data.top_institution;

    new Chart(document.getElementById('yesHistogram').getContext('2d'), {
      type: 'bar',
      data: {
        labels: data.histogram.map(item => item.label),
        datasets: [{
          label: 'Positive Feedback Count',
          data: data.histogram.map(item => item.value),
          backgroundColor: '#4caf50'
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
