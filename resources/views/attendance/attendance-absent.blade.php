<x-admin-layout>
    <x-slot name="header">
        <h3 class="page-title">
            Absent List
        </h3>
    </x-slot>

    <!-- Page Content Start -->
    <div class="row justify-content-end">
        <div class="col-md-4 col-sm-6 col-lg-4 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="la la-user-slash"></i></span>
                    <div class="dash-widget-info">
                        <h3><a href="{{route('attendance.report')}}">Attendance</a></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-lg-4 col-xl-3">
            <div class="card dash-widget">
                <div class="card-body">
                    <span class="dash-widget-icon"><i class="la la-utensils"></i></span>
                    <div class="dash-widget-info">
                        <h3><a href="{{route('attendance.report.break')}}">In Break</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>



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
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0" id="absent-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Team</th>
                            <th>Leave</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@section('script')
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#absent-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('api.absentReport.manager') }}",
                data: function (data) {
                    data.team_id = $('#team_id').val(); // Get the selected team ID from the filter
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'team_id', name: 'team_id' },
                { data: 'status', name: 'status' }
            ]
        });

        $('#team_id').on('change', function () {
            table.ajax.reload();
        });
    });
</script>
@endsection

</x-admin-layout>

