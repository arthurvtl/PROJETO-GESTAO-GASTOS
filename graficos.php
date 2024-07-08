<?php
require_once './config.php';

// Verifica se a sessão está ativa e se o índice 'login' está definido
if (isset($_SESSION['login']) && isset($_SESSION['login']['id'])) {
    $user_id = $_SESSION['login']['id'];
} else {
    header('Location: login.php');
    exit;
}

require_once './partials/header.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-chart-bar"></i> Gráficos</h1>
        <div class="chart-container">
            <canvas id="myBarChart"></canvas>
        </div>
        <div id="error-message"></div>
    </div>

    <script>
        fetch('graficos_action.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('error-message').innerText = data.error;
                    return;
                }
                const ctx = document.getElementById('myBarChart').getContext('2d');
                const myBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.meses,
                        datasets: [
                            {
                                label: 'Entradas',
                                data: data.entradas,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Saídas',
                                data: data.saidas,
                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                beginAtZero: true
                            },
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                labels: {
                                    font: {
                                        size: 14
                                    },
                                    color: '#333'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.dataset.label || '';
                                        const value = context.raw || 0;
                                        return `${label}: R$ ${value.toFixed(2)}`;
                                    }
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Erro ao buscar dados:', error));
    </script>
</body>
</html>

<?php
require_once './partials/footer.php';
?>



