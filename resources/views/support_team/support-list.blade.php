<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Support Team</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Support Team</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{ route('support-teams.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Support Team</a>
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
                            <th>Email</th>
                            <th class="text-right no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supportTeam as $supportTeam)
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="#" class="avatar"><img alt="" src="https://eu.ui-avatars.com/api/?name={{ $supportTeam->name }}&background=e63946&color=fff&length=1"></a>
                                        <a href="profile.html">{{ ucfirst($supportTeam->name) }}</span></a>
                                    </h2>
                                </td>
                                <td>
                                    <a href="mailto:{{ $supportTeam->email }}">{{ $supportTeam->email }}</a>
                                </td>
                                <td class="text-right">
                                    <div class="d-flex">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_s_team" data-support-id="{{$supportTeam->id}}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
    <div class="modal custom-modal fade" id="delete_s_team" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-header">
                        <h3>Delete Support Team</h3>
                        <p>Are you sure want to delete?</p>
                    </div>
                    <div class="modal-btn delete-action">
                        <div class="row">
                            <div class="col-6">
                                <form id="delete-s-team-form" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                    <button onclick="deleteSupportTeam()" style="padding:10px 75px" aria-label="delete" type="submit" class="btn btn-primary continue-btn">Delete</button>
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
    function deleteSupportTeam(){
        var deleteSupportTeam = document.getElementById('delete-s-team-form');
        deleteSupportTeam.submit();
    }

    $(document).ready(function(){
        // Event listener for the delete modal
        $('#delete_s_team').on('show.bs.modal', function(event) {
            var supportId = $(event.relatedTarget).data('support-id');
            var deleteForm = $('#delete-s-team-form');

            // Set the action of the delete form using the lead ID
            deleteForm.attr('action', '/support-teams/' + supportId);
        });
    });
</script>