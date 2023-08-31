<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Managers</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manager</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{ route('managers.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Manager</a>
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
                            <th class="text-right no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($managers as $manager)
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar"><img alt="" src="https://eu.ui-avatars.com/api/?name={{ $manager->name }}&background=e63946&color=fff&length=1"></a>
                                        <a href="profile.html">{{ $manager->name }}</span></a>
                                    </h2>
                                </td>
                                <td>
                                    @if ($manager->agent_code)
                                        {{$manager->agent_code}}
                                    @endif
                                </td>
                                <td>
                                    <a href="mailto:{{ $manager->email }}">{{ $manager->email }}</a>
                                </td>
                                <td>
                                    @if ($manager->phone)
                                        <a href="tel:+{{ $manager->phone }}">{{ $manager->phone }}</a>
                                    @endif
                                </td>
                                <td>
                                    @if ($manager->managerOfTeams ?? false)
                                            @foreach ($manager->managerOfTeams as $team)
                                                <a href="#" class="btn btn-white btn-sm btn-rounded">{{ $team->team_name }}</a>
                                            @endforeach
                                    @else
                                        <p>No teams assigned</p>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="d-flex">
                                       <a class="dropdown-item" href="{{route('managers.edit', ['manager' => $manager->id])}}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_manager" data-manager-id="{{$manager->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
    <div class="modal custom-modal fade" id="delete_manager" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Manager</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <form id="delete-manager-form" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                    <button onclick="deleteManager()" style="padding:10px 75px" aria-label="delete" type="submit" class="btn btn-primary continue-btn">Delete</button>
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
    function deleteManager(){
        var deleteManager = document.getElementById('delete-manager-form');
        deleteManager.submit();
    }

    $(document).ready(function(){
        // Event listener for the delete modal
        $('#delete_manager').on('show.bs.modal', function(event) {
            var managerId = $(event.relatedTarget).data('manager-id');
            var deleteForm = $('#delete-manager-form');

            // Set the action of the delete form using the lead ID
            deleteForm.attr('action', '/managers/' + managerId);
        });
    });
</script>