<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leads</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leads</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{ route('leads.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Lead</a>
                </div>
            </div>
        </div>
    </x-slot>

    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="ftd">Team:</label>
                        <select id='team_id' name="team_id" class="form-control">
                            <option selected disabled value="">Select Team</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="ftd">FTD:</label>
                        <select id='ftd' name="ftd" class="form-control">
                            <option selected disabled value="">Select FTD</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id='status' name="status" class="form-control">
                            <option selected disabled value="">Select Status</option>
                            <option value="0">Follow up</option>
                            <option value="1">Interested</option>
                            <option value="2">Not Interested</option>
                            <option value="3">Existing Customer</option>
                            <option value="4">Invalid Number</option>
                            <option value="5">New</option>
                            <option value="6">Switch Off</option>
                            <option value="7">Call Busy</option>
                            <option value="8">Message Sent</option>
                            <option value="9">No Response</option>
                            <option value="10">Id Created</option>
                            <option value="11">Sent Demo Id</option>
                            <option value="12">Call After Sometimes</option>
                            <option value="13">Waiting Response</option>
                            <option value="14">Play Later</option>
                            <option value="15">No Payment Option</option>
                            <option value="16">Blocked My Number</option>
                            <option value="17">Declined</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="agent">Search By Agent</label>
                        <input type="text" name="agent" id="agent" class="form-control"/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="source">Search By Source</label>
                        <input type="text" name="source" id="source" class="form-control"/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="phone">Search By Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control"/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="username">Search By Username</label>
                        <input type="text" name="username" id="username" class="form-control"/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="from_date">From Date:</label>
                        <input type="date" name="from_date" id="from_date" class="form-control" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="to_date">To Date:</label>
                        <input type="date" name="to_date" id="to_date" class="form-control" />
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="has_amount">Amount:</label>
                        <input type="checkbox" value="has_amount" name="has_amount" id="has_amount" class="form-control">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @hasanyrole('admin|manager|s_team_leader')
            <a href="{{ route('leads.export')}}" class="btn add-btn"><i class="fa fa-download"></i>Export</a>
            @endhasanyrole
            <div class="table-responsive">
                <table class="table table-striped table-nowrap custom-table mb-0 mydatatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Agent</th>
                            <th>Phone Number</th>
                            <th>Username</th>
                            <th>FTD</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Source</th>
                            <th>Team</th>
                            <th>Country</th>
                            <th>Created</th>
                            <th class="text-right">Actions</th>
                            <th width="50px">
                                <a href="" name="bulk_delete" id="bulk_delete" class="delete btn btn-danger btn-sm">Delete</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Delete Lead Modal -->
<div class="modal custom-modal fade" id="delete_lead" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Lead</h3>
                    <p>Are you sure you want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <form id="delete-lead-form" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="deleteLead()" style="padding: 10px 75px" aria-label="delete" type="submit" class="btn btn-primary continue-btn">Delete</button>
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
<!-- /Delete Lead Modal -->



</x-admin-layout>

<script>
    function deleteLead() {
        var deleteForm = document.getElementById('delete-lead-form');
        deleteForm.submit();
    }

    $(document).ready(function() {
        // Event listener for the delete modal
        $('#delete_lead').on('show.bs.modal', function(event) {
            var leadId = $(event.relatedTarget).data('lead-id');
            var deleteForm = $('#delete-lead-form');

            // Set the action of the delete form using the lead ID
            deleteForm.attr('action', '/leads/' + leadId);
        });

        
    });

    $(document).on('click', '#bulk_delete', function(){
        var id = [];
        if(confirm("Are you sure you want to Delete this data?"))
        {
            $('.leads_checkbox:checked').each(function(){
                id.push($(this).val());
                
            });
            if(id.length > 0)
            {
                $.ajax({
                    url:"{{ route('leads.removeall') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method:"POST",
                    data:{id:id},
                    success:function(data)
                    {
                        console.log(data);
                        window.location.reload();
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });
            }
            else
            {
                alert("Please select atleast one checkbox");
            }
        }
    });

    
</script>

<script type="text/javascript">
    $(function () {
        var table = $('.mydatatable').DataTable({
            processing: true,
            searching: false,
            serverSide: true,
            ajax: {
                url: "{{ route('api.leads.index') }}",
                data: function (d) {
                        d.ftd = $('#ftd').val(),
                        d.status = $('#status').val(),
                        d.team_id =$('#team_id').val(),
                        d.agent = $('#agent').val(),
                        d.source = $('#source').val(),
                        d.phone = $('#phone').val(),
                        d.username = $('#username').val(),
                        d.from_date = $('#from_date').val(),
                        d.to_date = $('#to_date').val(),
                        d.has_amount = $('#has_amount').is(':checked') ? '1' : null;
                    }
                },
            columns: [
                {data: 'DT_RowIndex', name: 'index'},
                {data: 'lead_agent_id', name: 'lead_agent_id'},
                {data: 'phone', name: 'phone'},
                {data: 'username', name: 'username'},
                {data: 'ftd', name: 'ftd'},
                {data: 'amount', name: 'amount'},
                {data: 'status', name: 'status'},
                {data: 'source', name: 'source'},
                {data: 'team_id', name: 'team_id'},
                {data: 'country', name: 'country'},
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'action', 
                    name: 'action',
                    orderable: false, 
                    searchable: false
                },
                {
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable:false,
                    searchable:false
                },
            ],
            
        });


        $('#ftd').change(function(){
            table.draw();
        });
        $('#team_id').change(function(){
            table.draw();
        });
        $('#agent').keyup(function(){
            table.draw();
        });
        $('#source').keyup(function(){
            table.draw();
        });
        $('#phone').keyup(function(){
            table.draw();
        });
        $('#username').keyup(function(){
            table.draw();
        });
        $('#status').change(function(){
            table.draw();
        });
        $('#from_date, #to_date').change(function(){
            table.draw();
        });
        $('#has_amount').change(function(){
            table.draw();
        });

        
      
    });
  </script>

{{-- UPDATE `leads` SET `lead_agent_id` = 31 WHERE `created_at` BETWEEN '2023-07-01' AND '2023-08-01' AND `team_id` = 3 AND `status` = 3 AND `username` IS Null LIMIT 35; --}}