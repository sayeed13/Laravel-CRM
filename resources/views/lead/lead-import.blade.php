{{-- <x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leads Import</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leads Import</li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('leads.import.distribute') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">File Input</label>
                            <div class="col-md-10">
                                <input name="file" class="form-control" type="file">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Source</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="source"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Select Team</label>
                            <div class="col-md-10">
                                <select name="team_id" class="form-control">
                                    <option value="">-- Select --</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button style="background-color: #f43b48" type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




</x-admin-layout>
 --}}






{{-- ================================================
================================================
================================================
================================================ --}}


<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leads Import</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leads Import</li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('leads.import.distribute') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">File Input</label>
                            <div class="col-md-10">
                                <input name="file" class="form-control" type="file" accept=".xlsx">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Source</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="source"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Select Team</label>
                            <div class="col-md-10">
                                <select name="team_id" class="form-control" id="team-select">
                                    <option value="">-- Select --</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row" id="agents-container" style="display: none;">
                            <label class="col-form-label col-md-2">Select Agents</label>
                            <div class="col-md-10">
                                <div id="agents-list"></div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button style="background-color: #f43b48" type="submit" class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('team-select').addEventListener('change', function () {
            var teamId = this.value;
            var agentsContainer = document.getElementById('agents-container');

            // Reset agents list
            document.getElementById('agents-list').innerHTML = '';

            if (teamId) {
                // Show agents container
                agentsContainer.style.display = 'block';

                // Fetch agents for the selected team
                fetch('/get-agents/' + teamId)
                    .then(response => response.json())
                    .then(data => {
                        // Create checkboxes for each agent
                        data.forEach(function (agent) {
                            var checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'selected_agents[]';
                            checkbox.value = agent.id;

                            var label = document.createElement('label');
                            label.classList.add('agent-label'); // Add a CSS class for styling

                            // Customize the label text or add additional styling as needed
                            label.innerHTML = '<span class="agent-name">' + agent.name + '</span>';
                            
                            // Append the checkbox and label to the agents list
                            label.appendChild(checkbox);
                            document.getElementById('agents-list').appendChild(label);
                        });
                    });
            } else {
                // Hide agents container if no team is selected
                agentsContainer.style.display = 'none';
            }
        });
    </script>
</x-admin-layout>
