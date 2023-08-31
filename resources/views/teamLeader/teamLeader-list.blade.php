<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Team Leaders</h3>
                    <ul class="breadcrumb">
                        @if (auth()->user()->role === 'team_leader')
                            <li class="breadcrumb-item"><a href="{{ route('teamleader.dashboard') }}">Dashboard</a></li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        @endif
                        <li class="breadcrumb-item active">Team Leaders</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{ route('team-leaders.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Team Leader</a>
                </div>
            </div>
        </div>
    </x-slot>


    <!-- Page Content Start -->

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table datatable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Team</th>
                            <th>Manager</th>
                            <th class="text-right no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($team_leaders as $team_leader)
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar"><img alt="" src="https://eu.ui-avatars.com/api/?name={{ $team_leader->name }}&background=e63946&color=fff&length=1"></a>
                                        <a href="profile.html">{{ $team_leader->name }}</span></a>
                                    </h2>
                                </td>
                                <td>
                                    @if ($team_leader->agent_code)
                                        {{$team_leader->agent_code}}
                                    @endif
                                </td>
                                <td>
                                    <a href="mailto:{{ $team_leader->email }}">{{ $team_leader->email }}</a>
                                </td>
                                <td>
                                    @if ($team_leader->phone)
                                        <a href="tel:+{{ $team_leader->phone }}">{{ $team_leader->phone }}</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($team_leader->team)
                                        {{ $team_leader->team->team_name }}
                                    @endif
                                </td>
                                <td>
                                    {{ $team_leader->team?->manager?->name }}
                                </td>
                                <td class="text-right">
                                    <div class="d-flex">
                                       <a class="dropdown-item" href="{{route('team-leaders.edit', ['team_leader' => $team_leader->id])}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_teamleader" data-teamleader-id="{{$team_leader->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Employee Modal -->
    <div class="modal custom-modal fade" id="delete_teamleader" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Team Leader</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <form id="delete-teamleader-form" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                    <button onclick="deleteTeamLeader()" style="padding:10px 75px" aria-label="delete" type="submit" class="btn btn-primary continue-btn">Delete</button>
                                </form>
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
<script>
    function deleteTeamLeader(){
        var deleteTeamLeader = document.getElementById('delete-teamleader-form');
        deleteTeamLeader.submit();
    }

    $(document).ready(function() {
        $('#delete_teamleader').on('show.bs.modal', function(event) {
            var teamLeaderId = $(event.relatedTarget).data('teamleader-id');
            var deleteForm = $('#delete-teamleader-form');

            // Set the action of the delete form using the lead ID
            deleteForm.attr('action', '/team-leaders/' + teamLeaderId);
        });
    });
</script>