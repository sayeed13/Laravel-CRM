<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Teams</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Teams</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{ route('teams.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Team</a>
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
                            <th>Description</th>
                            <th>Manager</th>
                            <th>Team Leader</th>
                            <th>Status</th>
                            <th class="text-right no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teams as $team)
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar"><img alt="" src="https://eu.ui-avatars.com/api/?name={{ $team->team_name }}&background=e63946&color=fff&length=1"></a>
                                        <a href="profile.html">{{ $team->team_name }}</span></a>
                                    </h2>
                                </td>
                                <td>
                                    @if ($team->desc)
                                        {{$team->desc}}
                                    @endif
                                </td>
                                <td>
                                    {{$team->manager?->name}}
                                </td>
                                <td>
                                    {{$team->teamLeader?->name}}
                                </td>
                                <td>
                                    @if ($team->status == 0)
                                        <span style="border-radius:15px" class="btn-white btn-sm"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</span>
                                    @elseif ($team->status == 1)
                                        <span style="border-radius:15px" class="btn-white btn-sm"><i class="fa fa-dot-circle-o text-success"></i> Active</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="d-flex">
                                       <a class="dropdown-item" href="{{route('teams.edit', ['team' => $team->id])}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_team" data-team-id="{{ $team->id }}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
    <div class="modal custom-modal fade" id="delete_team" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Team</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <form id="delete-team-form" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                    <button onclick="deleteTeam()" style="padding:10px 75px" aria-label="delete" type="submit" class="btn btn-primary continue-btn">Delete</button>
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
    function deleteTeam() {
        var deleteForm = document.getElementById('delete-team-form');
        deleteForm.submit();
    }

    $(document).ready(function() {
        // Event listener for the delete modal
        $('#delete_team').on('show.bs.modal', function(event) {
            var teamId = $(event.relatedTarget).data('team-id');
            var deleteForm = $('#delete-team-form');

            // Set the action of the delete form using the lead ID
            deleteForm.attr('action', '/teams/' + teamId);
        });
    });
</script>