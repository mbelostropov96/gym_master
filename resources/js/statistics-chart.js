import Chart from 'chart.js/auto'

(async function() {
    const canvas = document.getElementById('user-statistics-chart');
    const data = Object.entries(JSON.parse(canvas.getAttribute('data')));
    const consumption = canvas.getAttribute('energy-consumption');

    console.log(data);
    new Chart(
        document.getElementById('user-statistics-chart'),
        {
            type: 'bar',
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    }
                },
            },
            data: {
                labels: data.map(row => row[1].date),
                datasets: [
                    {
                        label: 'Расходы потребления энергии (Ккал)',
                        data: data.map(row => row[1].consumption)
                    },
                    // {
                    //     label: 'Ваша норма потребления',
                    //     data: data.map(row => consumption),
                    // }
                ]
            }
        }
    );
})();
