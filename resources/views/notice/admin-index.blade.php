<x-admin-layout>
    <x-slot name="header">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Notice</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('manager.dashboard') }}">Dashboard</a></li>
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
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    {{-- {{\Illuminate\Support\Str::limit($notice->content, 25, $end='...')}} --}}
                    <tbody>
                        @foreach ($notices as $notice)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    @if ($notice->content)
                                        {{ $notice->content }}
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
                                <td class="text-right">
                                    <div class="d-flex">
                                        @role('admin')
                                       <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_content" data-content-id="{{ $notice->id }}"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <!-- Delete Lead Modal -->
<div class="modal custom-modal fade" id="delete_content" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-header">
                    <h3>Delete Notice</h3>
                    <p>Are you sure you want to delete?</p>
                </div>
                <div class="modal-btn delete-action">
                    <div class="row">
                        <div class="col-6">
                            <form id="delete-content-form" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="deleteContent()" style="padding: 10px 75px" aria-label="delete" type="submit" class="btn btn-primary continue-btn">Delete</button>
                            </form>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Delete Lead Modal -->



</x-admin-layout>

<script>
    function deleteContent() {
        var deleteForm = document.getElementById('delete-content-form');
        deleteForm.submit();
    }

    $(document).ready(function() {
        // Event listener for the delete modal
        $('#delete_content').on('show.bs.modal', function(event) {
            var contentId = $(event.relatedTarget).data('content-id');
            var deleteForm = $('#delete-content-form');

            // Set the action of the delete form using the lead ID
            deleteForm.attr('action', '/notices-admin/' + contentId);
        });
    });
</script>