<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Agents</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i> Add Employee</a>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Page Content Start -->
    <!-- Search Filter -->
    <form action="{{ route('agents.search') }}" method="GET">
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">  
                <div class="form-group form-focus">
                    <input type="text" name="agent_id" class="form-control floating">
                    <label class="focus-label">Agent ID</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">  
                <div class="form-group form-focus">
                    <input type="text" name="agent_name" class="form-control floating">
                    <label class="focus-label">Agent Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3"> 
                <div class="form-group form-focus select-focus">
                    <select class="select floating" name="search_team_leader"> 
                        <option>Select Team Leader</option>
                        @foreach ($teamLeaders as $teamLeader)
                            <option {{ request('search_team_leader')==$teamLeader->id ? 'selected="selected"' : '' }} value="{{ $teamLeader->id }}">{{ $teamLeader->name }}</option>
                        @endforeach
                    </select>
                    <label class="focus-label">Team Leader</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">  
                <button type="submit" class="btn btn-success btn-block"> Search </button>  
            </div>     
        </div>
    </form>
    <!-- /Search Filter -->
    
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table datatable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Agent ID</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Team</th>
                            <th>Team Leader</th>
                            <th class="text-right no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agents as $agent)
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar"><img alt="" src="https://eu.ui-avatars.com/api/?name={{ $agent->name }}&background=e63946&color=fff&length=1"></a>
                                        <a href="profile.html">{{ $agent->name }}</span></a>
                                    </h2>
                                </td>
                                <td>
                                    @if ($agent->agent_code)
                                        {{$agent->agent_code}}
                                    @endif
                                </td>
                                <td>
                                    <a href="mailto:{{ $agent->email }}">{{ $agent->email }}</a>
                                </td>
                                <td>
                                    @if ($agent->phone)
                                        <a href="tel:+{{ $agent->phone }}">{{ $agent->phone }}</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($agent->team)
                                        {{ $agent->team->team_name }}
                                    @endif
                                </td>
                                <td>{{ $agent->teamLeader->name }}</td>
                                <td class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_employee"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_employee"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Employee Modal -->
    <div id="add_employee" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            @include('admin.agent.agent-create')
        </div>
    </div>
    <!-- /Add Employee Modal -->

    <!-- Edit Employee Modal -->
    <div id="edit_employee" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            @include('admin.agent.agent-edit')
        </div>
    </div>
    <!-- /Edit Employee Modal -->

    <!-- Delete Employee Modal -->
    <div class="modal custom-modal fade" id="delete_employee" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Employee</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <a href="javascript:void(0);" class="btn btn-primary continue-btn">Delete</a>
                            </div>
                            <div class="col-6">
                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Employee Modal -->
    
</x-admin-layout>