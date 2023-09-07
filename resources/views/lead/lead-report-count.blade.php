<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leads</li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="card">

        <div class="card-body text-center">
            <form action="{{ route('leads.report.count')}}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="from_datetime">From Date and Time:</label>
                            <input type="datetime-local" name="from_datetime" id="from_datetime" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="to_datetime">To Date and Time:</label>
                            <input type="datetime-local" name="to_datetime" id="to_datetime" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="source">Source:</label>
                            <input type="text" name="source" id="source" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-form-label">Team</label>
                            <select name="team_id" id="team_id" class="team-select select form-control">
                                <option selected disabled value="">Select Team</option>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->team_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <Button type="submit" style="background-color: #f43b48; margin-bottom:10px" class="btn btn-primary punch-btn font-weight-normal">Generate</Button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Total Leads </h4>
                    <h1 class="mb-5 h1">{{ number_format($totalLeads, 0 , '.', ','); }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-gradient-info text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Total User </h4>
                    <h1 class="mb-5 h1">{{ number_format($totalSignup, 0 , '.', ','); }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-gradient-success text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Total FTD </h4>
                    <h1 class="mb-5 h1">{{ number_format($totalFtd, 0 , '.', ','); }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-gradient-danger text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">FTD Amount </h4>
                    <h1 class="mb-5 h1">₹ {{ number_format($totalAmount, 0 , '.', ','); }}</h1>
                </div>
            </div>
        </div>
    </div>



</x-admin-layout>

