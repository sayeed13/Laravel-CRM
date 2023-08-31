<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leads</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('teamleader.dashboard') }}">Dashboard</a></li>
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
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @hasanyrole('admin|team_leader')
            <a href="{{ route('leads.export.tleader')}}" class="btn add-btn"><i class="fa fa-download"></i>Export</a>
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
                url: "{{ route('api.leads-tleader.index') }}",
                data: function (d) {
                        d.ftd = $('#ftd').val(),
                        d.status = $('#status').val(),
                        d.agent = $('#agent').val(),
                        d.source = $('#source').val(),
                        d.phone = $('#phone').val(),
                        d.username = $('#username').val()
                    }
            },
          columns: [
              {data: 'DT_RowIndex', name: 'id'},
              {data: 'lead_agent_id', name: 'lead_agent_id'},
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
      
    });
  </script>