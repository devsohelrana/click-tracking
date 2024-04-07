<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <canvas id="clickChart" class="w-100 h-auto"></canvas>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('clickChart').getContext('2d');

        var queries = {!! json_encode($clicksData->pluck('query')) !!};
        var clickCounts = {!! json_encode($clicksData->pluck('click_count')) !!};

        var clickChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: queries,
                datasets: [{
                    label: 'Clicks',
                    data: clickCounts,
                    backgroundColor: '#008DDA',
                    borderColor: 'rgba(75, 192, 192, 1)'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
