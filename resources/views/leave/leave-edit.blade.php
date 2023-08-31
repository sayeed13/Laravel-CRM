<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leave Request</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
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
                            <th class="text-center">Action</th>
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
                                        $total = $from_date->diff($to_date)->days + 1;
                                    @endphp
                                    {{ $total }} day
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
                                        <div class="action-label">
                                            <a class="btn btn-white btn-sm btn-rounded" href="">
                                                <i class="fa fa-dot-circle-o text-danger"></i> Declined
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($leave?->status == 1)
                                        <p>Approved</p>
                                    @elseif ($leave?->status == 2)
                                        <p>Declined: {{$leave?->reason_for_rejection}}</p>
                                    @else
                                        <form style="display: inline-block;" action="{{route('leave.update', $leave->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                            <button style="background-color: #55ce63" type="submit" name="status" class="btn btn-success btn-rounded" action="action" value="1">Accept</button>
                                        </form>
                                        <button style="background-color: #f62d51" type="button" class="btn btn-danger btn-rounded" data-toggle="modal" data-target="#rejectModal-{{$leave->id}}">Reject</button>
                                    @endif
                                </td>
                            </tr>
                            <div class="modal fade" id="rejectModal-{{$leave->id}}" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel-{{$leave->id}}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rejectModalLabel-{{$leave->id}}">Reject Leave Request</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{route('leave.update', $leave->id)}}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <input type="hidden" name="status" value="2"/>
                                                    <label for="reason">Reason for Rejection:</label>
                                                    <textarea class="form-control" name="reason_for_rejection" id="reason" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button style="background-color: #f62d51" type="submit" class="btn btn-danger">Submit Reason</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    




</x-admin-layout>