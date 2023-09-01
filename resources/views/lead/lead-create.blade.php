
<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leads</h3>
                    <ul class="breadcrumb">
                        @if (auth()->user()->role === 'team_leader')
                            <li class="breadcrumb-item"><a href="{{ route('teamleader.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('leads.tleader') }}">All Leads</a></li>
                        @elseif (auth()->user()->role === 'agent')
                            <li class="breadcrumb-item"><a href="{{ route('attend.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('leads.agent') }}">All Leads</a></li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">All Leads</a></li>
                        @endif
                        <li class="breadcrumb-item active">Create</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                        @if (auth()->user()->role === 'team_leader')
                            <a href="{{ route('leads.tleader') }}" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back to List</a>
                        @elseif (auth()->user()->role === 'agent')
                        <a href="{{ route('leads.agent') }}" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back to List</a>
                        @else
                        <a href="{{ route('leads.index') }}" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back to List</a>
                        @endif
                </div>
            </div>
        </div>
    </x-slot>


    <div class="modal-content">
    <div class="modal-body">
        <form action="{{route('leads.store')}}" method="POST" id="lead-form">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    {{-- <div class="form-group">
                        <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                        <input required class="form-control @error('phone') is-invalid @enderror" maxlength="18" id="mobile_code" type="text" name="phone" value="{{ old('phone') }}">
                    </div>
                    @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror --}}


                    <label class="col-form-label col-lg-2">Phone <span class="text-danger">*</span></label>
                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <select id="country_code" name="country_code">
                                        <option value="+91">India (+91)</option>
                                        <option value="+92">Pakistan (+92)</option>
                                        <option value="+880">Bangladesh (+880)</option>
                                        <option value="+997">Nepal (+997)</option>
                                        <option value="+971">UAE (+971)</option>
                                        <!-- Add more country options as needed -->
                                      </select>
                                </div>
                                <input required type="text" class="form-control @error('phone') is-invalid @enderror" id="phone_number" name="phone_number" minlength="9" maxlength="10" value="{{ old('phone') }}">
                                <input required class="form-control" maxlength="18" type="hidden" id="phone" name="phone" value="{{ old('phone') }}">
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label">Status</label>
                        <select name="status" class="select" id="status-select">
                            <option value="" disabled selected>Select Status</option>
                            <option value="5">New</option>
                            <option value="18">Follow up</option>
                            <option value="1">Interested</option>
                            <option value="2">Not Interested</option>
                            <option value="3">Existing Customer</option>
                            <option value="4">Invalid Number</option>
                            <option value="6">Switched OFF</option>
                            <option value="7">Call Busy</option>
                            <option value="8">Message Sent</option>
                            <option value="9">No Response</option>
                            <option value="10">Id Created</option>
                            <option value="11">Demo ID Sent</option>
                            <option value="12">Call Later</option>
                            <option value="13">Waiting for Response</option>
                            <option value="14">Play Later</option>
                            <option value="15">No Payment Option</option>
                            <option value="16">Blocked My Number</option>
                            <option value="17">Declined</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label">Username</label>
                        <input class="form-control" type="text" name="username" value="{{ old('username') }}" disabled>
                    </div>
                    @error('username')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="col-form-label">FTD Status</label>
                        <select name="ftd" class="select" id="ftd">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="col-form-label">FTD Amount</label>
                        <input type="text" class="form-control" value="{{ old('amount') }}" name="amount">
                    </div>
                </div>
                <div class="col-sm-6">  
                    <div class="form-group">
                        <label class="col-form-label">Country</label>
                        <input type="text" class="form-control" value="{{ old('country') }}" name="country">
                    </div>
                    @error('country')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label">Source </label>
                        <input name="source" class="form-control" type="text" value="{{ old('source') }}">
                    </div>
                    @error('source')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label">Team <span class="text-danger">*</span></label>
                        @if ($agent)
                            <select name="team_id" class="team-select select form-control" disabled>
                                <option selected disabled value="{{ $agent->team_id }}">{{ $agent->team->team_name }}</option>
                            </select>
                        @else
                            <select required name="team_id" class="team-select select form-control">
                                <option selected disabled value="">Select Team</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                @endforeach
                            </select>
                        @endif
                        @error('team_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label">Employee <span class="text-danger">*</span></label>
                        @if (auth()->user()->role === 'agent')
                        <input type="hidden" name="lead_agent_id" value="{{auth()->user()->id}}">
                        @else
                        <select required name="lead_agent_id" class="form-control agent-select" disabled>
                            <option selected disabled value="">Select Agent</option>
                        </select>
                        @endif
                        
                    </div>
                    @error('lead_agent_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="submit-section">
                <button style="background-color: #f43b48" type="submit" class="btn btn-primary submit-btn">Submit</button>
            </div>
        </form>
    </div>
    </div>

    <style>
        .intl-tel-input,
        .iti{
        width: 100%;
        }
    </style>

    <script>
    var input = document.querySelector("#mobile_code");
    window.intlTelInput(input, {
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
        initialCountry: "in",
        separateDialCode: true,

    });
    </script>

</x-admin-layout>
<script>
    $(document).ready(function() {

        $('#status-select').on('change', function() {
            var selectedStatus = $(this).val();
            var ftdSelect = $('#ftd');
            var usernameInput = $('input[name="username"]');

            // Disable or enable the username field based on the selected status
            if (selectedStatus === '2' || selectedStatus === '4') {
                ftdSelect.val('0').find('option[value="1"]').prop('disabled', true);
                usernameInput.val('').prop('disabled', true);
            } else {
                ftdSelect.find('option[value="1"]').prop('disabled', false);
                usernameInput.prop('disabled', false);
            }
        });

        



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
                    success: function(response) {
                        // Enable the agent select
                        agentSelect.prop('disabled', false);

                        // Add the agents as options in the select element
                        response.agents.forEach(function(agent) {
                            agentSelect.append($('<option></option>').attr('value', agent.id).text(agent.name));
                        });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the error if any
                        console.error(xhr.responseText);
                    }
                });
            }
        }

        // Event listener for the team select element
        $('.team-select').on('change', function() {
            var teamId = $(this).val();
            loadAgents(teamId);
        });


        $('#lead-form').on('submit', function(event) {
        event.preventDefault();
        
        var countryCode = $('#country_code').val();
        var phoneNumber = $('#phone_number').val();
        var completePhoneNumber = countryCode + phoneNumber;
        
        $('#phone').val(completePhoneNumber);
        $('#lead-form').unbind('submit').submit();
      });
        
    });
</script>

