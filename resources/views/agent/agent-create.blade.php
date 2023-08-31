
<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Agent</h3>
                    <ul class="breadcrumb">
                        @if (auth()->user()->role === 'team_leader')
                            <li class="breadcrumb-item"><a href="{{ route('teamleader.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('agents.tleader') }}">Agents</a></li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('agents.index') }}">Agents</a></li>
                        @endif
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{ route('agents.index') }}" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back to List</a>
                </div>
            </div>
        </div>
    </x-slot>


    <div class="modal-content">
    <div class="modal-body">
        <form action="{{route('agents.store')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label">Name <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="name">
                    </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label">Email <span class="text-danger">*</span></label>
                        <input class="form-control" type="email" name="email">
                    </div>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label">Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" required>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label">Confirm Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" name="password_confirmation" type="password" required>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-sm-6">  
                    <div class="form-group">
                        <label class="col-form-label">Employee ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="agent_code">
                    </div>
                    @error('agent_code')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-form-label">Phone </label>
                        <input name="phone" class="form-control" type="text">
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
                            <select required name="team_id" class="select">
                                <option selected disabled value="">Select Team</option>
                                @foreach ($teams as $team)
                                    <option value="{{$team->id}}">{{$team->team_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            </div>
            <div class="submit-section">
                <button style="background-color: #f62d51" type="submit" class="btn btn-primary submit-btn">Submit</button>
            </div>
        </form>
    </div>
    </div>

</x-admin-layout>