<x-admin-layout>  

    
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Total Leads </h4>
                    <h1 class="h1">{{ number_format($totalLeads, 0 , '.', ','); }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-gradient-info text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Total User </h4>
                    <h1 class="h1">{{ number_format($totalSignup, 0 , '.', ','); }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-gradient-success text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Total FTD </h4>
                    <h1 class="h1">{{ number_format($totalFtd, 0 , '.', ','); }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-gradient-danger text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">FTD Amount </h4>
                    <h1 class="h1">₹ {{ number_format($totalAmount, 0 , '.', ','); }}</h1>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 text-center">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Leads</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-lg-9">
                                    <select name="team_id" id="team_id" class="form-control">
                                        <option selected disabled value="">Select Team</option>
                                        @foreach ($teams as $team)
                                            <option value="{{ $team->id }}">{{ $team->team_name }}</option>
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
                        <canvas id="comboChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p class="text-center h3">All Teams Performance</p>
                    <div id="teamChartContainer" style="height: 400px;">
                        <canvas id="teamComboChart"></canvas>
                    </div>
                </div>
            </div>  
        </div>
    </div> --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p class="text-center h3">Agent Performance</p>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">Team</label>
                                <select name="sec_team_id" id="sec_team_id" class="team-select select form-control">
                                    <option selected disabled value="">Select Team</option>
                                    @foreach ($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label">Employee</label>
                                <select required id="agent_id" name="lead_agent_id" class="form-control agent-select" disabled>
                                    <option selected disabled value="">Select Agent</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <ul class="nav justify-content-end">
                                <li class="d-inline mr-2">
                                    <label for="agentStartDate">Start Date:</label>
                                    <input type="date" id="agentStartDate">
                                </li>
                                <li class="d-inline">
                                    <label for="agentEndDate">End Date:</label>
                                    <input type="date" id="agentEndDate">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="teamChartContainer" style="height: 400px;">
                        <canvas id="agentComboChart"></canvas>
                    </div>
                </div>
            </div>  
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Top 5 Source</h3>
                    <ul class="list-group list-group-flush">
                        @foreach ($sources as $index => $data)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ strtoupper($data->source) }}
                                <span class="badge badge-primary badge-pill">{{$data->count}}</span>
                            </li>
                        @endforeach
                      </ul>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Top 5 Country</h3>
                    <ul class="list-group list-group-flush">
                        @foreach ($countries as $index => $data)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{$data->country}}
                                <span class="badge badge-primary badge-pill">{{$data->count}}</span>
                            </li>
                        @endforeach
                      </ul>
                </div>
            </div>
        </div> --}}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Top 5 Agent</h3>
                    <ul class="list-group list-group-flush">
                        @foreach ($agentCounts as $index => $agent)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{$topAgents[$index]->name}}
                                <span class="badge badge-primary badge-pill">{{$agent->count}}</span>
                            </li>
                        @endforeach
                      </ul>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center">Top 5 Agent of the Month</h3>
                    <ul class="list-group list-group-flush">
                        @foreach ($tmCount as $index => $agent)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{$tmAgents[$index]->name}}
                                <span class="badge badge-primary badge-pill">{{$agent->count}}</span>
                            </li>
                        @endforeach
                      </ul>
                </div>
            </div>
        </div>
    </div>



    <style>
        .li-active {
            color: #fff;
            background-color: #e63946;
            border-radius: 5px;
        }
    </style>
      
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <script>

        
        
        
        // // Fetch the JSON data from the API
        //  fetch('/team-api')
        //      .then(response => response.json())
        //      .then(jsonData => {
        //          // Transform the JSON data for Chart.js
        //          const teamChartData = jsonData.map(item => {
        //              return {
        //                 team_name: item.team_name,
        //                 lead_count: item.lead_count,
        //                 ftd_count: parseInt(item.ftd_count),
        //                 signup_count: parseInt(item.signup_count),
        //                 conversion_ratio: parseFloat(item.conversion_ratio)
        //              };
        //          });
                

        //          // Prepare the chart labels
        //          const teamLabels = teamChartData.map(item => item.team_name);
        
        //          // Prepare the datasets
        //          const teamDatasets = [
        //              {
        //                 label: 'Ratio',
        //                 data: teamChartData.map(item => item.conversion_ratio),
        //                 type: 'line',
        //                 borderColor: 'rgba(54, 162, 235, 1)',
        //                 fill: true
        //             },
        //             {
        //                 label: 'Leads',
        //                 data: teamChartData.map(item => item.lead_count),
        //                 type: 'bar',
        //                 backgroundColor: '#023047'
        //             },
        //             {
        //                 label: 'FTD',
        //                 data: teamChartData.map(item => item.ftd_count),
        //                 type: 'bar',
        //                 backgroundColor: '#2ec4b6',
        //             },
        //             {
        //                 label: 'Sign Up',
        //                 data: teamChartData.map(item => item.signup_count),
        //                 type: 'bar',
        //                 backgroundColor: '#ff7d00'
        //             }
                    
        //         ];

        //         // Create the combo chart
        //         new Chart(document.getElementById('teamComboChart'), {
        //             type: 'bar',
        //             data: {
        //                 labels: teamLabels,
        //                 datasets: teamDatasets
        //             },
        //             options: {
        //                 responsive: true,
        //                 scales: {
        //                     x: {
        //                         display: true,
        //                         title: {
        //                             display: true,
        //                             text: 'Teams'
        //                         }
        //                     },
        //                     y: {
        //                         display: true,
        //                         title: {
        //                             display: true,
        //                             text: 'Total'
        //                         }
        //                     }
        //                 },
        //                 plugins: {
        //                     tooltip: {
        //                         mode: 'index',
        //                         intersect: true
        //                     },
        //                     eforeDraw: function(chart, args, options) {
        //                         chart.canvas.parentNode.style.height = '400px';
        //                     }           
        //                 }
        //             }
        //         });
        //     })
        //     .catch(error => {
        //         console.error('Error fetching JSON data:', error);
        //     });

 
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
        const teamSelect = document.getElementById('team_id');

        // Create the initial combo chart instance (without data)
        const comboChart = new Chart(document.getElementById('comboChart'), {
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
            const selectedTeamId = teamSelect.value;

            // Fetch data from the server based on selected team and date range
            let apiUrl = '/lead-api';
            if (selectedTeamId) {
                apiUrl += `?team_id=${selectedTeamId}`;
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
                    comboChart.data.labels = labels;
                    comboChart.data.datasets = datasets;

                    //Filter the data based on the selected date range
                    const filteredData = chartData.filter(item => {
                        const itemDate = new Date(item.date);
                        return itemDate >= selectedStartDate && itemDate < selectedEndDate;
                    });

                    // Update the chart with the filtered data
                    comboChart.data.labels = filteredData.map(item => item.date);
                    comboChart.data.datasets.forEach((dataset, index) => {
                        dataset.data = filteredData.map(item => {
                            if (index === 0) return item.conversion_ratio;
                            if (index === 1) return item.value;
                            if (index === 2) return item.ftd_leads;
                            if (index === 3) return item.username_leads;
                        });
                    });

                    comboChart.update();
                })
                .catch(error => {
                    console.error('Error fetching JSON data:', error);
                });
        }

        // Attach event listeners to the team select and date range filter inputs
        teamSelect.addEventListener('change', updateChart);
        startDateInput.addEventListener('change', updateChart);
        endDateInput.addEventListener('change', updateChart);

        // Initialize the chart with the default team and date range
        updateChart();
    });

    document.addEventListener('DOMContentLoaded', function() {
    // Function to load agents based on the selected team
        function loadAgents(teamId) {
            var agentSelect = $('.agent-select');

            // Clear existing options
            agentSelect.empty();

            // Disable the agent select initially
            agentSelect.prop('disabled', true);

            // If a team is selected, make an AJAX request to fetch the agents
            if (teamId) {
                $.ajax({
                    url: '/teams/' + teamId + '/agents',
                    type: 'GET',
                    success: function (response) {
                        // Enable the agent select
                        agentSelect.prop('disabled', false);

                        // Add the agents as options in the select element
                        response.agents.forEach(function (agent) {
                            agentSelect.append($('<option></option>').attr('value', agent.id).text(agent.name));
                        });

                        agentSelect.val(response.agents[0].id).trigger('change');
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        // Handle the error if any
                        console.error(xhr.responseText);
                    },
                });
            }
        }

    // Event listener for the team select element
    $('.team-select').on('change', function () {
        var teamId = $(this).val();
        loadAgents(teamId);
    });

    // Event listener for the agent select element
    $('.agent-select').on('change', function () {
        var teamId = $('.team-select').val();
        var agentId = $(this).val();
        fetchData(teamId, agentId);
    });

    
    const agentComboChart = new Chart(document.getElementById('agentComboChart'), {
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
                        text: 'Date',
                    },
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Total',
                    },
                },
            },
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: true,
                },
            },
        },
    });
    
    const agentStartDateInput = document.getElementById('agentStartDate');
    const agentEndDateInput = document.getElementById('agentEndDate');

    // Set default date range (last 15 days)
    const agentDefaultEndDate = new Date();
    const agentDefaultStartDate = new Date();
    agentDefaultStartDate.setDate(agentDefaultStartDate.getDate() - 14);
    agentStartDateInput.valueAsDate = agentDefaultStartDate;
    agentEndDateInput.valueAsDate = agentDefaultEndDate; 
    

    // Fetch agent data and update the chart
    function fetchData(teamId, agentId) {
        function updateAgentChart(){
            const selectedStartDate = new Date(agentStartDateInput.value);
            const selectedEndDate = new Date(agentEndDateInput.value);
            selectedEndDate.setDate(selectedEndDate.getDate() + 1);

            fetch(`/agent-api/${teamId}/${agentId}`)
            .then((response) => response.json())
            .then((jsonData) => {
                // Transform the JSON data for Chart.js
                const chartData = jsonData.map((item) => {
                    return {
                        date: item.date,
                        value: item.leads,
                        ftd_leads: parseInt(item.ftd_leads),
                        username_leads: parseInt(item.username_leads),
                        conversion_ratio: parseFloat(item.conversion_ratio),
                    };
                });

                // Prepare the chart labels
                const labels = chartData.map((item) => item.date);

                // Prepare the datasets
                const datasets = [
                    {
                        label: 'Ratio',
                        data: chartData.map((item) => item.conversion_ratio),
                        type: 'line',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        fill: true,
                    },
                    {
                        label: 'Leads',
                        data: chartData.map((item) => item.value),
                        type: 'bar',
                        backgroundColor: '#023047',
                    },
                    {
                        label: 'FTD',
                        data: chartData.map((item) => item.ftd_leads),
                        type: 'bar',
                        backgroundColor: '#2ec4b6',
                    },
                    {
                        label: 'Sign Up',
                        data: chartData.map((item) => item.username_leads),
                        type: 'bar',
                        backgroundColor: '#ff7d00',
                    },
                ];

                agentComboChart.data.labels = labels;
                agentComboChart.data.datasets = datasets;

                //Filter the data based on the selected date range
                const filteredData = chartData.filter(item => {
                    const itemDate = new Date(item.date);
                    return itemDate >= selectedStartDate && itemDate < selectedEndDate;
                });

                // Update the chart with the filtered data
                agentComboChart.data.labels = filteredData.map(item => item.date);
                agentComboChart.data.datasets.forEach((dataset, index) => {
                    dataset.data = filteredData.map(item => {
                        if (index === 0) return item.conversion_ratio;
                        if (index === 1) return item.value;
                        if (index === 2) return item.ftd_leads;
                        if (index === 3) return item.username_leads;
                    });
                });

                agentComboChart.update();         

            })
            .catch((error) => {
                console.error('Error fetching JSON data:', error);
            });
        }

        agentStartDateInput.addEventListener('change', updateAgentChart);
        agentEndDateInput.addEventListener('change', updateAgentChart);
        updateAgentChart();
    }
    
});

</script>
    
    
</x-admin-layout>
