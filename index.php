<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Últimos Registros</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Adicionando o Chart.js -->
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 20px; }
        table { width: 50%; margin: auto; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #4CAF50; color: white; }
        canvas { max-width: 600px; margin: auto; display: block; }
    </style>
</head>
<body>
    <h2>Últimos 10 Registros</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Número</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody id="data-table">
            <!-- Dados serão inseridos aqui -->
        </tbody>
    </table>

    <h2>Gráfico dos Últimos 2 Dígitos</h2>
    <canvas id="chart"></canvas>

    <script>
        let chart;

        function formatDateTime(dateString) {
            const date = new Date(dateString);
            return date.toLocaleString("pt-BR", { timeZone: "America/Sao_Paulo" });
        }

        async function fetchData() {
            try {
                const response = await fetch('get_data.php'); // Chama a API em PHP
                const data = await response.json();

                const tableBody = document.getElementById('data-table');
                tableBody.innerHTML = ""; // Limpa a tabela antes de inserir novos dados

                const lastDigits = {};

                data.forEach(item => {
                    const lastTwoDigits = String(item.number).slice(-2); // Pegando os 2 últimos dígitos
                    lastDigits[lastTwoDigits] = (lastDigits[lastTwoDigits] || 0) + 1;

                    const row = `<tr>
                                    <td>${item.id}</td>
                                    <td>${item.number}</td>
                                    <td>${formatDateTime(item.data)}</td>
                                </tr>`;
                    tableBody.innerHTML += row;
                });

                updateChart(lastDigits);
            } catch (error) {
                console.error("Erro ao buscar dados:", error);
            }
        }

        function updateChart(lastDigits) {
            const labels = Object.keys(lastDigits).sort(); // Ordenando os números
            const values = labels.map(key => lastDigits[key]);

            if (!chart) {
                const ctx = document.getElementById('chart').getContext('2d');
                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Ocorrências dos Últimos 2 Dígitos',
                            data: values,
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            } else {
                chart.data.labels = labels;
                chart.data.datasets[0].data = values;
                chart.update();
            }
        }

        // Atualiza os dados a cada 5 segundos
        setInterval(fetchData, 1000);

        // Carrega os dados imediatamente ao abrir a página
        fetchData();
    </script>
</body>
</html>
