<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Teams</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('teams.index') }}">Teams</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{ route('teams.index') }}" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back to List</a>
                </div>
            </div>
        </div>
    </x-slot>



    <div class="modal-content">
        <div class="modal-body">
            <form action="{{route('teams.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="team_name">
                        </div>
                        @error('team_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Short Description <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="desc">
                        </div>
                        @error('desc')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Team Leader</label>
                            <select name="tleader_id" class="select">
                                <option selected disabled value="">Select Team Leader</option>
                                @foreach ($team_leaders as $team_leader)
                                    <option value="{{$team_leader->id}}">{{$team_leader->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Manager <span class="text-danger">*</span></label>
                            <select name="tmanager_id" class="select">
                                <option selected disabled value="">Select Manager</option>
                                @foreach ($managers as $manager)
                                    <option value="{{$manager->id}}">{{$manager->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="submit-section">
                    <button style="background-color: #f62d51" type="submit" class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>

</x-admin-layout>