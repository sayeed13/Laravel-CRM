<x-admin-layout>
    <x-slot name="header">
        <h3 class="page-title">
            Welcome {{ auth()->user()->name }}
        </h3>
    </x-slot>

    <!-- Previous Month and Team Selection -->
    <form action="{{ route('attendance.month.report') }}" method="GET">
        @csrf
        <div class="row align-items-end">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="month">Select Month</label>
                    <select name="month" id="month" class="form-control">
                        @php
                            $currentMonth = date('n');
                        @endphp
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $selectedMonth == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="team">Select Team</label>
                    <select name="team" id="team" class="form-control">
                        <option value="all" {{ $selectedTeam == 'all' ? 'selected' : '' }}>All Teams</option>
                        @foreach ($teams as $team)
                            <option value="{{ $team->id }}" {{ $selectedTeam == $team->id ? 'selected' : '' }}>
                                {{ $team->team_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <button style="background-color: #55ce63" type="submit" class="btn btn-block btn-success">Generate Report</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Attendance Report Table -->
    @php
        $selectedMonth = $selectedMonth ?? date('n'); // Default to current month if not selected
        $currentMonth = date('n');
    @endphp

    <table class="table table-striped custom-table mb-0">
        <thead>
            <tr>
                <th>Agent Name</th>
                @for ($day = 1; $day <= \Carbon\Carbon::createFromDate(date('Y'), $selectedMonth, 1)->daysInMonth; $day++)
                    <th>{{ $day }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $agent)
                <tr>
                    <td>{{ ucfirst($agent->name) }}</td>
                    @for ($day = 1; $day <= \Carbon\Carbon::createFromDate(date('Y'), $selectedMonth, 1)->daysInMonth; $day++)
                        <td>
                            @php
                                $date = \Carbon\Carbon::createFromDate(now()->year, $selectedMonth, 1)
                                    ->startOfMonth()
                                    ->addDays($day - 1);
                                $today = \Carbon\Carbon::today();
                                $attendanceRecord = $attendanceData->first(function ($record) use ($agent, $date) {
                                    return $record->user_id == $agent->id && \Carbon\Carbon::parse($record->created_at)->format('Y-m-d') === \Carbon\Carbon::parse($date)->format('Y-m-d');
                                });
                                $attendanceStatus = $attendanceRecord ? ($attendanceRecord->time_in ? 'present' : 'absent') : 'absent';
                                $workingHours = $attendanceRecord ? $attendanceRecord->check11Hours() : 0;
                                $isLessThan11Hours = $workingHours < 660;
                                
                                
                                $leave = $agent->leaves->first(function ($leave) use ($date) {
                                    return $date->between($leave->date, $leave->to_date);
                                });
                                $leaveStatus = $leave ? $leave->status : null;
                            @endphp

                            @if ($date->greaterThan($today))
                                {{-- Show null for future dates --}}
                                --
                            @elseif ($attendanceStatus === 'present' && !$isLessThan11Hours)
                                <a href="" data-toggle="modal" data-target="#attendance_info" class="attendance-details" data-attendance="{{ json_encode($attendanceRecord) }}" data-working-hours="{{ $attendanceRecord ? $attendanceRecord->calculateWorkingHours() : '' }}" data-break-hours="{{ $attendanceRecord ? $attendanceRecord->totalBreakHours() : '' }}">
                                    <i class="fa fa-check text-success"></i>
                                </a>
                            @elseif ($isLessThan11Hours && $attendanceStatus === 'present')
                                <a href="" data-toggle="modal" data-target="#attendance_info" class="attendance-details" data-attendance="{{ json_encode($attendanceRecord) }}" data-working-hours="{{ $attendanceRecord ? $attendanceRecord->calculateWorkingHours() : '' }}" data-break-hours="{{ $attendanceRecord ? $attendanceRecord->totalBreakHours() : '' }}">
                                    <i class="fa fa-circle-o text-warning"></i>
                                </a>
                            @elseif ($attendanceStatus === 'absent')
                                @if ($leave)
                                    {{-- Agent has a leave entry for the current day --}}
                                    @if ($leaveStatus == 1)
                                        <span class="text-success">AL</span>
                                    @else
                                        <span class="text-danger">UL</span>
                                    @endif
                                @else
                                    {{-- Agent is absent, but no leave entry found --}}
                                    <i class="fa fa-close text-danger"></i>
                                @endif
                            @endif
                        </td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal custom-modal fade" id="attendance_info" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card punch-status">
                                <div class="card-body">
                                    <h5 class="card-title">Timesheet <small class="text-muted" id="timesheet_date"></small></h5>
                                    <div class="punch-det text-center">
                                        <h6>Working Hours</h6>
                                    </div>
                                    <div class="punch-info">
                                        <div class="punch-hours">
                                            <span id="working_hours"></span>
                                        </div>
                                    </div>
                                    <div class="punch-det text-center">
                                        <h6>Break Hours</h6>
                                    </div>
                                    <div class="punch-info">
                                        <div class="punch-hours">
                                            <span id="break_hours"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card recent-activity">
                                <div class="card-body">
                                    <h5 class="card-title">Activity</h5>
                                    <ul class="res-activity-list">
                                        <li>
                                            <p class="mb-0">Time In at</p>
                                            <p class="res-activity-time">
                                                <i class="fa fa-clock-o"></i>
                                                <span id="time_in"></span>
                                            </p>
                                        </li>
                                        <li>
                                            <p class="mb-0">Time Out at</p>
                                            <p class="res-activity-time">
                                                <i class="fa fa-clock-o"></i>
                                                <span id="time_out"></span>
                                            </p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('script')
<script>
    $(document).ready(function () {
        $('.attendance-details').click(function () {
            var attendance = $(this).data('attendance');
            var date = moment(attendance.created_at).format('D MMMM, YYYY');
            var timeIn = moment(attendance.time_in);
            var timeOut = moment(attendance.time_out);

            $('#timesheet_date').text(date);
            $('#time_in').text(timeIn.format('h:mm A'));
            $('#time_out').text(timeOut.format('h:mm A'));
            $('#working_hours').text($(this).data('working-hours'));
            $('#break_hours').text($(this).data('break-hours'));
        });
    });
</script>
@endsection
</x-admin-layout>


