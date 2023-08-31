<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leave Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Leaves</li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="modal-content">
        <div class="modal-body">
            <form action="{{route('leave.request')}}" method="POST">
                @csrf
                <div class="row">
                    <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="col-form-label">From </label>
                            <div class="cal-icon"><input id="leave_dates" class="form-control datetimepicker" name="date" type="text"></div>
                        </div>
                        @error('date_of_birth')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="col-form-label">To </label>
                            <div class="cal-icon" id="leave_dates"><input class="form-control datetimepicker" name="to_date" type="text"></div>
                        </div>
                        @error('date_of_birth')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label">Reason</label>
                            <textarea rows="5" cols="5" class="form-control" name="reason" placeholder="Enter text here"></textarea>
                        </div>
                    </div>
                </div>
                <div class="submit-section">
                    <button style="background-color: #f43b48" type="submit" class="btn btn-primary submit-btn">Request</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>From</th>
                            <th>To</th>
                            <th>No of Days</th>
                            <th>Reason</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaves as $leave)
                            <tr>
                                <td>{{$loop->iteration}}</td>
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