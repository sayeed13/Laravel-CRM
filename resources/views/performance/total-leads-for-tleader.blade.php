
<x-admin-layout>

    <div class="row">
        <div class="col-md-12 text-center">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Leads</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-lg-9">
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option selected disabled value="">Select Agent</option>
                                        @foreach ($agents as $agent)
                                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="nav justify-content-end">
                                <li class="d-inline mr-2">
                                    <label for="startDate">Start Date:</label>
                                    <input type="date" id="startDate">
                                </li>
                                <li class="d-inline">
                                    <label for="endDate">End Date:</label>
                                    <input type="date" id="endDate">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="chartContainer" style="height: 560px;">
                        <canvas id="comboChartForTleader"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
      
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

     
    document.addEventListener('DOMContentLoaded', function() {
        // Retrieve the date range filter inputs
        const startDateInput = document.getElementById('startDate');
        const endDateInput = document.getElementById('endDate');

        // Set default date range (last 15 days)
        const defaultEndDate = new Date();
        const defaultStartDate = new Date();
        defaultStartDate.setDate(defaultStartDate.getDate() - 14);
        startDateInput.valueAsDate = defaultStartDate;
        endDateInput.valueAsDate = defaultEndDate; 
        
        // Retrieve the team select input
        const agentSelect = document.getElementById('user_id');

        // Create the initial combo chart instance (without data)
        const comboChartForTleader = new Chart(document.getElementById('comboChartForTleader'), {
            type: 'bar',
            data: {
                labels: [],
                datasets: []
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Total'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: true
                    }
                },
                bar: {groupWidth: "100%"}
            }
        });

        // Function to update the chart based on the selected team and date range
        function updateChart() {
            const selectedStartDate = new Date(startDateInput.value);
            const selectedEndDate = new Date(endDateInput.value);
            selectedEndDate.setDate(selectedEndDate.getDate() + 1); // Increment by one day to include the end date
            const selectedAgentId = agentSelect.value;

            // Fetch data from the server based on selected team and date range
            let apiUrl = '/lead-for-tl-api';
            if (selectedAgentId) {
                apiUrl += `?user_id=${selectedAgentId}`;
            }

            fetch(apiUrl)
                .then(response => response.json())
                .then(jsonData => {
                    const chartData = jsonData.map(item => {
                        return {
                            date: item.date,
                            value: item.value,
                            ftd_leads: parseInt(item.ftd_leads),
                            username_leads: parseInt(item.username_leads),
                            conversion_ratio: parseFloat(item.conversion_ratio)
                        };

                    });
                    
                    const labels = chartData.map(item => item.date);
                    const datasets = [
                        {
                            label: 'Ratio',
                            data: chartData.map(item => item.conversion_ratio),
                            type: 'line',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            fill: true
                        },
                        {
                            label: 'Leads',
                            data: chartData.map(item => item.value),
                            type: 'bar',
                            backgroundColor: '#023047'
                        },
                        {
                            label: 'FTD',
                            data: chartData.map(item => item.ftd_leads),
                            type: 'bar',
                            backgroundColor: '#2ec4b6',
                        },
                        {
                            label: 'Sign Up',
                            data: chartData.map(item => item.username_leads),
                            type: 'bar',
                            backgroundColor: '#ff7d00'
                        }
                    ];

                    // Update the chart with new data
                    comboChartForTleader.data.labels = labels;
                    comboChartForTleader.data.datasets = datasets;

                    //Filter the data based on the selected date range
                    const filteredData = chartData.filter(item => {
                        const itemDate = new Date(item.date);
                        return itemDate >= selectedStartDate && itemDate < selectedEndDate;
                    });

                    // Update the chart with the filtered data
                    comboChartForTleader.data.labels = filteredData.map(item => item.date);
                    comboChartForTleader.data.datasets.forEach((dataset, index) => {
                        dataset.data = filteredData.map(item => {
                            if (index === 0) return item.conversion_ratio;
                            if (index === 1) return item.value;
                            if (index === 2) return item.ftd_leads;
                            if (index === 3) return item.username_leads;
                        });
                    });

                    comboChartForTleader.update();
                })
                .catch(error => {
                    console.error('Error fetching JSON data:', error);
                });
        }

        // Attach event listeners to the team select and date range filter inputs
        agentSelect.addEventListener('change', updateChart);
        startDateInput.addEventListener('change', updateChart);
        endDateInput.addEventListener('change', updateChart);

        // Initialize the chart with the default team and date range
        updateChart();
    });

</script>
    
    
</x-admin-layout>
