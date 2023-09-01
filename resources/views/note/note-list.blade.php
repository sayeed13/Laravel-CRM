<x-admin-layout>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Lead Phone</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                    <th>Agent Name</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leads as $lead)
                                    <tr>
                                        @if ($lead->notes->isNotEmpty())
                                            <td>{{ $lead->phone }}</td>
                                            <td>{{ $lead->notes->first()->text }}</td>
                                            <td>
                                                @if($lead->status == 18)
                                                    <span class="badge bg-inverse-primary">Follow Up</span>
                                                @elseif($lead->status == 1)
                                                    <span class="badge bg-inverse-primary">Interested</span>
                                                @elseif($lead->status == 2)
                                                    <span class="badge bg-inverse-warning">Not Interested</span>
                                                @elseif($lead->status == 3)
                                                    <span class="badge bg-inverse-primary">Existing Customer</span>
                                                @elseif($lead->status == 4)
                                                    <span class="badge bg-inverse-danger">Invalid Number</span>
                                                @elseif($lead->status == 5)
                                                    <span class="badge bg-inverse-info">New</span>
                                                @elseif($lead->status == 6)
                                                    <span class="badge bg-inverse-primary">Switched Off</span>
                                                @elseif($lead->status == 7)
                                                    <span class="badge bg-inverse-warning">Call Busy</span>
                                                @elseif($lead->status == 8)
                                                    <span class="badge bg-inverse-primary">Message Sent</span>
                                                @elseif($lead->status == 9)
                                                    <span class="badge bg-inverse-warning">No Response</span>
                                                @elseif($lead->status == 11)
                                                    <span class="badge bg-inverse-primary">Demo ID Sent</span>
                                                @elseif($lead->status == 10)
                                                    <span class="badge bg-inverse-success">ID Created</span>
                                                @elseif($lead->status == 12)
                                                    <span class="badge bg-inverse-primary">Call After</span>
                                                @elseif($lead->status == 13)
                                                    <span class="badge bg-inverse-warning">Waiting Response</span>
                                                @elseif($lead->status == 14)
                                                    <span class="badge bg-inverse-primary">Play Later</span>
                                                @elseif($lead->status == 15)
                                                    <span class="badge bg-inverse-primary">No Payment Option</span>
                                                @elseif($lead->status == 16)
                                                    <span class="badge bg-inverse-danger">Blocked Number</span>
                                                @elseif($lead->status == 17)
                                                    <span class="badge bg-inverse-danger">Declined</span>
                                                @endif
                                            </td>
                                            <td>{{ $lead->agent->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($lead->updated_at)->format('j F Y  h:i A');}}</td>
                                            <td>
                                                <a href="{{route('leads.show', $lead->id)}}" target="_blank" class="edit btn btn-success btn-sm">Open</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $leads->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>





