<?php
// Initialize and update visit counter
session_start();
if (!isset($_SESSION['visits'])) {
    $_SESSION['visits'] = 0;
}
$_SESSION['visits']++;
$visits = $_SESSION['visits'];
file_put_contents('visits.txt', $visits);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visit Counter</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <style>
        body {
            background: #000;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        #counter {
            font-size: 3em;
            margin-bottom: 20px;
            text-align: center;
        }
        #count {
            color: #00ffcc;
        }
        canvas {
            max-width: 600px;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
        }
        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <div id="counter">Total Visits: <span id="count">0</span></div>
    <canvas id="visitChart"></canvas>

    <script>
        // Animate counter
        const countElement = document.getElementById('count');
        let currentCount = 0;
        const totalCount = <?php echo $visits; ?>;
        const increment = Math.ceil(totalCount / 50);
        const updateCounter = () => {
            if (currentCount < totalCount) {
                currentCount += increment;
                if (currentCount > totalCount) currentCount = totalCount;
                countElement.textContent = currentCount;
                setTimeout(updateCounter, 20);
            }
        };
        updateCounter();

        // Chart.js for interactive chart
        const ctx = document.getElementById('visitChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Array.from({length: 10}, (_, i) => `Visit ${i+1}`),
                datasets: [{
                    label: 'Visits',
                    data: [<?php echo $visits; ?>].concat(Array(9).fill(0)),
                    borderColor: '#00ffcc',
                    backgroundColor: 'rgba(0, 255, 204, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, labels: { color: '#fff' } }
                },
                scales: {
                    x: { ticks: { color: '#fff' } },
                    y: { ticks: { color: '#fff' }, beginAtZero: true }
                }
            }
        });

        // Particles.js for snowflake effect
        particlesJS('particles-js', {
            particles: {
                number: { value: 100, density: { enable: true, value_area: 800 } },
                color: { value: '#ffffff' },
                shape: { type: 'circle', stroke: { width: 0 } },
                opacity: { value: 0.5, random: true },
                size: { value: 3, random: true },
                move: {
                    enable: true,
                    speed: 1,
                    direction: 'bottom',
                    random: true,
                    straight: false,
                    out_mode: 'out',
                    bounce: false,
                    attract: { enable: true, rotateX: 600, rotateY: 1200 }
                }
            },
            interactivity: {
                events: {
                    onhover: { enable: true, mode: 'repulse' },
                    onclick: { enable: true, mode: 'push' }
                }
            }
        });
    </script>
</body>
</html>
