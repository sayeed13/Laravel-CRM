<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Agents</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Agents</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{ route('agents.create') }}" class="btn add-btn" ><i class="fa fa-plus"></i> Add Agent</a>
                </div>
            </div>
        </div>
    </x-slot>
    
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-nowrap custom-table mb-0 mydatatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Employee ID</th>
                            <th>Team</th>
                            <th class="text-right no-sort">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Employee Modal -->
    <div class="modal custom-modal fade" id="delete_agent" role="dialog">
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
                                <form id="delete-agent-form" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                    <button onclick="deleteAgent()" style="padding:10px 75px" aria-label="delete" type="submit" class="btn btn-primary continue-btn">Delete</button>
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
    function deleteAgent(){
        var deleteForm = document.getElementById('delete-agent-form');
        deleteForm.submit();
    }

    $(document).ready(function(){
        // Event listener for the delete modal
        $('#delete_agent').on('show.bs.modal', function(event) {
            var agentId = $(event.relatedTarget).data('agent-id');
            var deleteForm = $('#delete-agent-form');

            // Set the action of the delete form using the lead ID
            deleteForm.attr('action', '/agents/' + agentId);
        });
    });
</script>

<script type="text/javascript">
    $(function () {
        var table = $('.mydatatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('api.agentList.manager') }}"
                },
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                {data: 'agent_code', name: 'agent_code'},
                {data: 'team_id', name: 'team_id'},
                {
                    data: 'action', 
                    name: 'action',
                    orderable: false, 
                    searchable: false
                },
            ]
        });  
    });
</script>