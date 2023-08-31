<style>
    .profile-view .profile-img-wrap {
	height: 95px;
	width: 95px;
}
.profile-view .profile-img {
	width: 95px;
	height: 95px;
}
.profile-img-wrap img {
    border-radius: 50%;
    height: 95px;
    width: 120px;
}
</style>


<div class="card mb-0">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="profile-view">
                    <div class="profile-img-wrap">
                        <div class="profile-img">
                            <img src="https://eu.ui-avatars.com/api/?name={{ auth()->user()->name }}&background=e63946&color=fff&size=95" alt="">
                        </div>
                    </div>
                    <div class="profile-basic">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="profile-info-left">
                                    <h3 class="user-name m-t-0 mb-0 text-capitalize h3">{{ auth()->user()->name }}</h3>
                                    <h6 class="text-muted">{{ auth()->user()->role }}</h6>
                                    @if (auth()->user()->role === 'agent')
                                        <div class="staff-id">Employee ID : {{auth()->user()->agent_code}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-7">
                                <ul class="personal-info">
                                    <li>
                                        <div class="title">Phone:</div>
                                        <div class="text"><a href="">{{ auth()->user()->phone ? auth()->user()->phone : 'none' }}</a></div>
                                    </li>
                                    <li>
                                        <div class="title">Email:</div>
                                        <div class="text"><a href="mailto:{{ auth()->user()->email }}">{{ auth()->user()->email ? auth()->user()->email : 'None'  }}</a></div>
                                    </li>
                                    <li>
                                        <div class="title">Team:</div>
                                        <div class="text">{{ auth()->user()->team?->team_name}}</div>
                                    </li>
                                    @role('agent')
                                    <li>
                                        <div class="title">Team Leader:</div>
                                        <div class="text">
                                            <div class="avatar-box">
                                                <div class="avatar avatar-xs">
                                                    <img src="https://eu.ui-avatars.com/api/?name={{ auth()->user()->team?->teamLeader->name}}&background=e63946&color=fff&size=64" alt="">
                                                </div>
                                            </div>
                                            <a href="profile.html">
                                                {{ auth()->user()->team?->teamLeader->name}}
                                            </a>
                                        </div>
                                    </li>
                                    @endrole
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Profile Modal -->
<div id="profile_info" class="modal custom-modal fade" role="dialog">
<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Profile Information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input id="name" name="name" value="{{ old('name', $user->name) }}" type="text" class="form-control" required autofocus autocomplete="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" equired autocomplete="username">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" value="631-889-3206">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="submit-section">
                    <button class="btn btn-primary submit-btn">Submit</button>
                    @if (session('status') === 'profile-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- /Profile Modal -->