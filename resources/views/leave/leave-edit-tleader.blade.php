<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leave Request</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('teamleader.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leave Request</li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>From</th>
                            <th>To</th>
                            <th>No of Days</th>
                            <th>Reason</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adminLeave as $leave)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="profile.html" class="avatar"><img alt="" src="https://eu.ui-avatars.com/api/?name={{ $leave->user->name }}&background=e63946&color=fff&length=1"></a>
                                        <a>	{{ucfirst($leave->user->name)}} </a>
                                    </h2>
                                </td>
                                <td>{{\Carbon\Carbon::parse($leave?->date)->format('j F Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($leave?->to_date)->format('j F Y')}}</td>
                                <td>
                                    @php
                                        $from_date = \Carbon\Carbon::parse($leave?->date);
                                        $to_date = \Carbon\Carbon::parse($leave?->to_date);
                                        $total = $from_date->diff($to_date);
                                    @endphp
                                    {{ $total->format("%a days") }}
                                </td>
                                <td>{{$leave->reason}}</td>
                                <td class="text-center">
                                    @if ($leave?->status == 0)
                                        <div class="action-label">
                                            <a class="btn btn-white btn-sm btn-rounded" href="">
                                                <i class="fa fa-dot-circle-o text-purple"></i> Pending
                                            </a>
                                        </div>
                                    @elseif ($leave?->status == 1)
                                        <div class="action-label">
                                            <a class="btn btn-white btn-sm btn-rounded" href="">
                                                <i class="fa fa-dot-circle-o text-success"></i> Accepted
                                            </a>
                                        </div>
                                    @elseif ($leave?->status == 2)
                                            <p>Declined: {{$leave?->reason_for_rejection}}</p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>




</x-admin-layout>