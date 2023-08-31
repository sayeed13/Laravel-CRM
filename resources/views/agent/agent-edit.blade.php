<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Agents</h3>
                    <ul class="breadcrumb">
                        @if (auth()->user()->role === 'team_leader')
                            <li class="breadcrumb-item"><a href="{{ route('teamleader.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('agents.tleader') }}">Agents</a></li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('agents.index') }}">Agents</a></li>
                        @endif
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    @if (auth()->user()->role === 'team_leader')
                        <a href="{{route('agents.tleader')}}" class="btn add-btn" ><i class="fa fa-arrow-left"></i> Back to List</a>
                    @else
                        <a href="{{route('agents.index')}}" class="btn add-btn" ><i class="fa fa-arrow-left"></i> Back to List</a>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>



<div class="modal-content">
    <div class="modal-body">
        <form action="{{route('agents.update', $agent->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label">Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="name" value="{{ $agent->name }}">
                    </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label">Email <span class="text-danger">*</span></label>
                        <input class="form-control" type="email" name="email" value="{{ $agent->email }}">
                    </div>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6">  
                    <div class="form-group">
                        <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="agent_code" value="{{$agent->agent_code}}">
                    </div>
                    @error('agent_code')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label">Phone </label>
                        <input name="phone" class="form-control" type="text" value="{{$agent->phone}}">
                    </div>
                    @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6">
                    @if (auth()->user()->role === 'team_leader')
                        <div class="form-group">
                            <label class="col-form-label" for="team_id">Team ID</label>
                            <select class="select" id="team_id" name="team_id" disabled>
                            <option value="{{ auth()->user()->team_id }}">{{ auth()->user()->team->team_name }}</option>
                            </select>
                        </div>
                    @else
                        <div class="form-group">
                            <label class="col-form-label">Teams</label>
                            <select name="team_id" class="select">
                                <option selected disabled value="">Select Team</option>
                                @foreach ($teams as $team)
                                    <option {{ $team->id == $agent->team?->id ? 'selected="selected"' : '' }} value="{{$team->id}}">{{$team->team_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            </div>

            <div class="submit-section">
                <button style="background-color: #f62d51" type="submit" class="btn btn-primary submit-btn">Update</button>
            </div>
        </form>
    </div>
</div>

</x-admin-layout>