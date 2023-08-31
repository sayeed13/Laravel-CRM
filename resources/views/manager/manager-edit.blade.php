<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Managers</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('managers.index') }}">Team Leader</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{ route('managers.index') }}" class="btn add-btn"><i class="fa fa-arrow-left"></i> Back to List</a>
                </div>
            </div>
        </div>
    </x-slot>



    <div class="modal-content">
        <div class="modal-body">
            <form action="{{route('managers.update', $manager->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" value="{{ $manager->name }}">
                        </div>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Email <span class="text-danger">*</span></label>
                            <input class="form-control" type="email" name="email" value="{{ $manager->email }}">
                        </div>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6">  
                        <div class="form-group">
                            <label class="col-form-label">Agent ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="agent_code" value="{{ $manager->agent_code }}">
                        </div>
                        @error('agent_code')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label">Phone </label>
                            <input name="phone" class="form-control" type="text" value="{{ $manager->phone }}">
                        </div>
                        @error('phone')
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











