
<x-admin-layout>

    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Attendance Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Attendance</li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>

    @php
        $currentDate = now()->format('d-m-Y');
    @endphp

    <div class="row flex justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="card punch-status">
                <div class="card-body">
                    <h5 class="card-title">Attendance Record <small class="text-muted">{{ $currentDate }}</small></h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="punch-btn-section">
                                <form id="time-in-form" action="{{ route('timeEntry.store') }}" method="POST">
                                    @csrf
                                    <button id="time-in-button" style="background-color: #f43b48; margin-bottom:10px" type="submit" class="btn btn-primary punch-btn"
                                        >Time In</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="punch-btn-section">
                                <form id="break-in-form" action="{{ route('breakEntry.store') }}" method="POST">
                                    @csrf
                                    <button id="break-in-button" style="background-color: #f43b48; margin-bottom:10px" type="submit" class="btn btn-primary punch-btn"
                                        >Break In</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="punch-btn-section">
                                <form id="break-out-form" action="{{ route('breakOut.store') }}" method="POST">
                                    @csrf
                                    <button id="break-out-button" style="background-color: #f43b48; margin-bottom:10px" type="submit" class="btn btn-primary punch-btn"
                                        >Break Out</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="punch-btn-section">
                                <form id="time-out-form" action="{{ route('timeOut.store') }}" method="POST">
                                    @csrf
                                    <button id="time-out-button" style="background-color: #f43b48; margin-bottom:10px" type="submit" class="btn btn-primary punch-btn"
                                        >Time Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time In</th>
                            <th>Breaks</th>
                            <th>Time Out</th>
                            <th>Working Hours</th>
                            <th>Break Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td>{{\Carbon\Carbon::parse($attendance?->created_at)->format('j F Y')}}</td>
                                <td>
                                    @if ($attendance?->time_in)
                                        {{\Carbon\Carbon::parse($attendance?->time_in)->format('h:i A')}}
                                    @else
                                        00:00
                                    @endif
                                </td>
                                <td>
                                    @if ($attendance?->breaks)
                                        @foreach ($attendance?->breaks as $breakEntry)
                                            {{\Carbon\Carbon::parse($breakEntry->break_in)->format('h:i A')}} {{$breakEntry->break_out ? ' - ' . \Carbon\Carbon::parse($breakEntry->break_out)->format('h:i A') : ' -';}}<br>
                                        @endforeach
                                    @else
                                        No break entries found.
                                    @endif
                                </td>
                                <td>
                                    @if ($attendance?->time_out)
                                        {{\Carbon\Carbon::parse($attendance?->time_out)->format('h:i A')}}
                                    @else
                                        00:00
                                    @endif
                                </td>
                                <td>
                                    {{$attendance?->calculateWorkingHours()}}
                                </td>
                                <td>
                                    {{$attendance?->totalBreakHours()}}
                                </td>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-admin-layout>

