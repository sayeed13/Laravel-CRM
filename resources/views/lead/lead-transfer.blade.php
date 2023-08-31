<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Lead Transfer</h3>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form id="leadTransferForm" action="{{ route('lead.transfer') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="team_id" class="col-md-2">Select Team:</label>
                            <select name="team_id" id="team_id" class="form-control col-md-10" onchange="loadAgents()">
                                <option value="">Select Team</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="source_agent_id" class="col-md-2">Source Agent:</label>
                            <select name="source_agent_id" id="source_agent_id" class="form-control col-md-10">
                                <!-- Options will be loaded dynamically using JavaScript -->
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="target_agent_id" class="col-md-2">Target Agent:</label>
                            <select name="target_agent_id" id="target_agent_id" class="form-control col-md-10">
                                <!-- Options will be loaded dynamically using JavaScript -->
                            </select>
                        </div>
                        <div class="submit-section">
                            <button style="background-color: #f43b48" type="submit" onclick="transferLeads()" class="btn btn-primary submit-btn">Transfer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    

@section('script')
<script>
    
    function loadAgents() {
        const teamId = document.getElementById('team_id').value;
        if (teamId) {
            // Make an AJAX request to fetch agents based on the selected team
            fetch(`/get-agents/${teamId}`)
                .then(response => response.json())
                .then(data => {
                    // Populate the source_agent_id and target_agent_id dropdowns with agents
                    const sourceAgentSelect = document.getElementById('source_agent_id');
                    const targetAgentSelect = document.getElementById('target_agent_id');
                    sourceAgentSelect.innerHTML = '<option value="">Select Source Agent</option>';
                    targetAgentSelect.innerHTML = '<option value="">Select Target Agent</option>';
                    data.forEach(agent => {
                        const option = document.createElement('option');
                        option.value = agent.id;
                        option.text = agent.name;
                        sourceAgentSelect.appendChild(option);
                        targetAgentSelect.appendChild(option.cloneNode(true));
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    }

    function transferLeads() {
        const sourceAgentId = document.getElementById('source_agent_id').value;
        const targetAgentId = document.getElementById('target_agent_id').value;

        if (!sourceAgentId || !targetAgentId) {
            alert('Please select both source and target agents.');
            return;
        }

        if (sourceAgentId === targetAgentId) {
            alert('Source and target agents cannot be the same.');
            return;
        }

        // Submit the form for lead transfer
        document.getElementById('leadTransferForm').submit();
    }
</script>
@endsection

</x-admin-layout>

