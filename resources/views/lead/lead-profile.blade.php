<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Lead</h3>
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
                        <li class="breadcrumb-item active">Lead</li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>


    @if (auth()->user()->role === 'admin'
    or auth()->user()->role === 'manager'
    or auth()->user()->role === 'team_leader'
    or auth()->user()->role === 'support_team_leader'
    or auth()->user()->id === $lead->lead_agent_id)

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('leads.update', $lead->id)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="col-form-label">Username</label>
                                        <input class="form-control" type="text" name="username" value="{{ old('username', $lead->username) }}">
                                    </div>
                                    @error('username')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="col-form-label">FTD</label>
                                        <select name="ftd" class="select" id="ftd">
                                            <option value="0" {{ $lead->ftd == 0 ? 'selected' : '' }}>No</option>
                                            <option value="1" {{ $lead->ftd == 1 ? 'selected' : '' }}>Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="col-form-label">Amount</label>
                                        <input class="form-control" type="text" name="amount" value="{{ old('amount', $lead->amount) }}">
                                    </div>
                                    @error('amount')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="col-form-label">Status</label>
                                        <select name="status" class="select" id="status-select">
                                            <option value="" disabled selected>Select Status</option>
                                            <option value="0" {{ $lead->status == 5 ? 'selected' : '' }}>New</option>
                                            <option value="0" {{ $lead->status == 0 ? 'selected' : '' }}>Follow up</option>
                                            <option value="1" {{ $lead->status == 1 ? 'selected' : '' }}>Interested</option>
                                            <option value="2" {{ $lead->status == 2 ? 'selected' : '' }}>Not Interested</option>
                                            <option value="3" {{ $lead->status == 3 ? 'selected' : '' }}>Existing Customer</option>
                                            <option value="4" {{ $lead->status == 4 ? 'selected' : '' }}>Invalid Number</option>
                                            <option value="6" {{ $lead->status == 6 ? 'selected' : '' }}>Switched OFF</option>
                                            <option value="7" {{ $lead->status == 7 ? 'selected' : '' }}>Call Busy</option>
                                            <option value="8" {{ $lead->status == 8 ? 'selected' : '' }}>Message Sent</option>
                                            <option value="9" {{ $lead->status == 9 ? 'selected' : '' }}>No Response</option>
                                            <option value="10" {{ $lead->status == 10 ? 'selected' : '' }}>Id Created</option>
                                            <option value="11" {{ $lead->status == 11 ? 'selected' : '' }}>Demo ID Sent</option>
                                            <option value="12" {{ $lead->status == 12 ? 'selected' : '' }}>Call Later</option>
                                            <option value="13" {{ $lead->status == 13 ? 'selected' : '' }}>Waiting for Response</option>
                                            <option value="14" {{ $lead->status == 14 ? 'selected' : '' }}>Play Later</option>
                                            <option value="15" {{ $lead->status == 15 ? 'selected' : '' }}>No Payment Option</option>
                                            <option value="16" {{ $lead->status == 16 ? 'selected' : '' }}>Blocked My Number</option>
                                            <option value="17" {{ $lead->status == 17 ? 'selected' : '' }}>Declined</option>
                                        </select>
                                    </div>
                                </div>
                                @if (in_array(auth()->user()->role, ['manager', 'admin', 'team_leader', 'support_team_leader']))
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="col-form-label">Employee <span class="text-danger">*</span></label>
                                        <select name="lead_agent_id" class="form-control agent-select">
                                            <option selected disabled value="">Select Agent</option>
                                        </select>
                                    </div>
                                    @error('lead_agent_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                @endif
                            </div>
                            <div class="submit-section">
                                <button style="background-color: #f43b48" type="submit" class="btn btn-primary submit-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title m-b-20">Notes</h5>
                        <ul class="files-list">
                            @if ($notes->count() > 0)
                                @foreach ($notes as $note)
                                <li>
                                    <div>
                                        <span class="text-ellipsis h4">{{$note->text}}</span>
                                        <span class="text-muted">Created by <a href="#">{{$note->user->name}}</a> On {{\Carbon\Carbon::parse($note->created_at)->format('j F h:i A')}}</span>
                                    </div>
                                </li>
                                @endforeach
                            @else
                                <p>No notes found for this lead.</p>
                            @endif
                            
                                <form action="{{ route('leads.notes.store', $lead->id)}}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="form-group mb-0 row">
                                        <div class="col-md-12">
                                            <label class="col-form-label">New Note <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="hidden" name="lead_id" value="{{ $lead->id }}">
                                                <input class="form-control" type="text" name="text">
                                                <div class="input-group-append">
                                                    <button style="background-color: #f43b48" class="btn btn-primary" type="submit">Add Note</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title m-b-15">Lead details</h6>
                        <table class="table table-striped table-border">
                            <tbody>
                                <tr>
                                    <td>Phone:</td>
                                    <td class="text-right">{{$lead->phone}}</td>
                                </tr>
                                <tr>
                                    <td>Username:</td>
                                    <td class="text-right">{{$lead->username}}</td>
                                </tr>
                                <tr>
                                    <td>FTD:</td>
                                    @if ($lead->ftd == 1)
                                        <td class="text-right"><span class="badge badge-pill badge-success">Yes</span></td>
                                    @else
                                        <td class="text-right"><span class="badge badge-pill badge-danger">No</span></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>FTD Amount:</td>
                                    <td class="text-right">{{$lead->amount}}</td>
                                </tr>
                                <tr>
                                    <td>Country:</td>
                                    <td class="text-right">{{$lead->country}}</td>
                                </tr>
                                <tr>
                                    <td>Status:</td>
                                    <td class="text-right">
                                        @if($lead->status == 0)
                                            <span class="badge badge-primary">Follow Up</span>
                                        @elseif($lead->status == 1)
                                            <span class="badge badge-primary">Interested</span>
                                        @elseif($lead->status == 2)
                                            <span class="badge badge-warning">Not Interested</span>
                                        @elseif($lead->status == 3)
                                            <span class="badge badge-primary">Existing Customer</span>
                                        @elseif($lead->status == 4)
                                            <span class="badge badge-danger">Invalid Number</span>
                                        @elseif($lead->status == 5)
                                            <span class="badge badge-info">New</span>
                                        @elseif($lead->status == 6)
                                            <span class="badge badge-primary">Switched Off</span>
                                        @elseif($lead->status == 7)
                                            <span class="badge badge-warning">Call Busy</span>
                                        @elseif($lead->status == 8)
                                            <span class="badge badge-primary">Message Sent</span>
                                        @elseif($lead->status == 9)
                                            <span class="badge badge-warning">No Response</span>
                                        @elseif($lead->status == 10)
                                            <span class="badge badge-success">ID Created</span>
                                        @elseif($lead->status == 11)
                                            <span class="badge badge-primary">Demo ID Sent</span>
                                        @elseif($lead->status == 12)
                                            <span class="badge badge-primary">Call After</span>
                                        @elseif($lead->status == 13)
                                            <span class="badge badge-warning">Waiting Response</span>
                                        @elseif($lead->status == 14)
                                            <span class="badge badge-primary">Play Later</span>
                                        @elseif($lead->status == 15)
                                            <span class="badge badge-primary">No Payment Option</span>
                                        @elseif($lead->status == 16)
                                            <span class="badge badge-danger">Blocked Number</span>
                                        @elseif($lead->status == 17)
                                            <span class="badge badge-danger">Declined</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Created:</td>
                                    <td class="text-right">{{$lead->created_at->diffForHumans()}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card project-user">
                    <div class="card-body">
                        <h6 class="card-title m-b-20">Team </h6>
                        <ul class="list-box">
                            <li>
                                <a href="profile.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar"><img alt="" src="https://eu.ui-avatars.com/api/?name={{$lead->team?->team_name}}&background=e63946&color=fff&length=1"></span>
                                        </div>
                                        <div class="list-body pt-2">
                                            <span class="message-author">{{$lead->team?->team_name}}</span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card project-user">
                    <div class="card-body">
                        <h6 class="card-title m-b-20">
                            Agent
                        </h6>
                        <ul class="list-box">
                            <li>
                                <a href="profile.html">
                                    <div class="list-item">
                                        <div class="list-left">
                                            <span class="avatar"><img alt="" src="https://eu.ui-avatars.com/api/?name={{$lead->agent->name}}&background=e63946&color=fff&length=1"></span>
                                        </div>
                                        <div class="list-body pt-2">
                                            <span class="message-author">{{$lead->agent?->name}}</span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p>You are not authorized to see leads details.</p>
    @endif
    

@section('script')
<script>
    $(document).ready(function() {
        // Function to load agents based on the selected team
        function loadAgents(teamId) {
            var agentSelect = $('.agent-select');

            // If a team is selected, make an AJAX request to fetch the agents
            if (teamId) {
                $.ajax({
                    url: '/teams/' + teamId + '/agents',
                    type: 'GET',
                    success: function(response) {
                        // Enable the agent select
                        //agentSelect.prop('disabled', false);

                        // Add the agents as options in the select element
                        response.agents.forEach(function(agent) {
                            agentSelect.append($('<option></option>').attr('value', agent.id).text(agent.name));
                        });

                        // Set the selected agent based on the lead's agent ID
                        agentSelect.val('{{ $lead->lead_agent_id }}');
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        // Handle the error if any
                        console.error(xhr.responseText);
                    }
                });
            }
        }

        var selectedTeamId = '{{ $lead->team_id }}';
            if (selectedTeamId) {
                loadAgents(selectedTeamId);
            }
    });
</script>
@endsection

</x-admin-layout>

