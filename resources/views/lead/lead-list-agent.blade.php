<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leads</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('attend.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leads</li>
                    </ul>
                </div>
                {{-- <div class="col-auto float-right ml-auto">
                    <a href="{{ route('leads.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Lead</a>
                </div> --}}
            </div>
        </div>
    </x-slot>

    @if ($hasFollowUpLeads > 0)
        <div class="alert alert-danger d-flex align-items-center justify-content-center p-4">
            <i class="las la-exclamation-triangle h1 mr-2"></i>
            <h1 class="h2">You have {{$hasFollowUpLeads}} leads with a "follow up" status. Please review them.</h1>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row">
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
                            <option value="18">Follow up</option>
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
                        <label for="source">Search By Source</label>
                        <input type="text" name="source" id="source" class="form-control"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="phone">Search By Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="username">Search By Username</label>
                        <input type="text" name="username" id="username" class="form-control"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-nowrap custom-table mb-0 mydatatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Phone Number</th>
                            <th>Username</th>
                            <th>FTD</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Source</th>
                            <th>Country</th>
                            <th>Created</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-admin-layout>


<script type="text/javascript">
    $(function () {
      
      var table = $('.mydatatable').DataTable({
          processing: true,
          searching: false,
          serverSide: true,
          ajax: {
                url: "{{ route('api.leads-agent.index') }}",
                data: function (d) {
                        d.ftd = $('#ftd').val(),
                        d.status = $('#status').val(),
                        d.source = $('#source').val(),
                        d.phone = $('#phone').val(),
                        d.username = $('#username').val()
                    }
            },
          columns: [
              {data: 'DT_RowIndex', name: 'id'},
              {data: 'phone', name: 'phone'},
              {data: 'username', name: 'username'},
              {data: 'ftd', name: 'ftd'},
              {data: 'amount', name: 'amount'},
              {data: 'status', name: 'status'},
              {data: 'source', name: 'source'},
              {data: 'country', name: 'country'},
              {data: 'created_at', name: 'created_at'},
              {
                  data: 'action', 
                  name: 'action',
                  orderable: false, 
                  searchable: false
              },
          ]
      });

    $('#ftd').change(function(){
        table.draw();
    });
    $('#status').change(function(){
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
      
    });
  </script>