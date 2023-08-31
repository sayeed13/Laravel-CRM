<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Notice</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('teamleader.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Notice</li>
                    </ul>
                </div>
                <div class="col-auto float-right ml-auto">
                    <a href="{{ route('notice.create')}}" class="btn add-btn"><i class="fa fa-plus"></i> Add Notice</a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-nowrap custom-table mb-0 datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Notice</th>
                            <th>Published By</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notices as $notice)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    @if ($notice->content)
                                        {{\Illuminate\Support\Str::limit($notice->content, 25, $end='...')}}
                                    @endif
                                </td>
                                <td>
                                    @if ($notice->user_id)
                                        {{$notice->user->name}}
                                    @endif
                                </td>
                                <td>
                                    @if ($notice->created_at)
                                        {{\Carbon\Carbon::parse($notice?->created_at)->format('j F Y')}}
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
