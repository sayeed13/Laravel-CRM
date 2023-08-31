<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Managers</h3>
                    <ul class="breadcrumb">
                        @if (auth()->user()->role === 'team_leader')
                            <li class="breadcrumb-item"><a href="{{ route('teamleader.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('notice.tleader.index') }}">Notice</a></li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('notice.admin.index') }}">Notice</a></li>
                        @endif
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    @if (auth()->user()->role === 'team_leader')
                        <a href="{{ route('notice.tleader.index') }}" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back to List</a>
                    @else
                    <a href="{{ route('notice.admin.index') }}" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back to List</a>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>



    <div class="modal-content">
        <div class="modal-body">
            <form action="{{route('notice.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Notice Content</label>
                            <div class="col-md-10">
                                <textarea name="content" rows="5" cols="5" class="form-control" placeholder="Enter text here"></textarea>
                            </div>
                        </div>
                        @error('content')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="submit-section">
                    <button style="background-color: #f62d51" type="submit" class="btn btn-primary submit-btn">Submit</button>
                </div>
            </form>
        </div>
    </div>

</x-admin-layout>











