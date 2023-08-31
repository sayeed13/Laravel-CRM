<x-admin-layout>

    <x-slot name="header">
        <h3 class="page-title">
            Welcome {{ $agent->name }}
        </h3>
    </x-slot>

    <div class="card mb-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                <img src="https://eu.ui-avatars.com/api/?name={{ $agent->name }}&background=e63946&color=fff&size=128" alt="">
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0 text-capitalize h3">{{ $agent->name }}</h3>
                                        <h6 class="text-muted">{{ $agent->role }}</h6>
                                        <div class="staff-id">Employee ID : {{$agent->agent_code}}</div>
                                        <div class="staff-msg"><a class="btn btn-custom" href="/chat">Send Message</a></div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Phone:</div>
                                            <div class="text"><a href="">{{$agent->phone}}</a></div>
                                        </li>
                                        <li>
                                            <div class="title">Email:</div>
                                            <div class="text"><a href="mailto:{{ $agent->email }}">{{ $agent->email }}</a></div>
                                        </li>
                                        <li>
                                            <div class="title">Birthday:</div>
                                            <div class="text">24th July</div>
                                        </li>
                                        <li>
                                            <div class="title">Team Leader:</div>
                                            <div class="text">
                                                <div class="avatar-box">
                                                    <div class="avatar avatar-xs">
                                                        <img src="https://eu.ui-avatars.com/api/?name={{ $agent->team?->teamLeader->name }}&background=e63946&color=fff&size=64" alt="">
                                                    </div>
                                                </div>
                                                <a href="">
                                                    {{$agent->team?->teamLeader->name}}
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="pro-edit"><a class="edit-icon" href="{{route('agents.edit', $agent->id)}}"><i class="fa fa-pencil"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div class="card tab-box">
        <div class="row user-tabs">
            <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                <ul class="nav nav-tabs nav-tabs-bottom">
                    <li class="nav-item"><a href="#team" data-toggle="tab" class="nav-link">Team</a></li>
                </ul>
            </div>
        </div>
        </div>
    
        <div class="tab-content">
    
            <!-- Team Info Tab -->
            <div id="team" class="pro-overview tab-pane fade show active">
                <div class="row">
                    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="project-title h4"><a href="project-view.html">{{$agent->team->team_name}}</a></h4>
                                <p class="text-muted">
                                    {{$agent->team->desc}}
                                </p>
                                <div class="pro-deadline m-b-15">
                                    <div class="sub-title">
                                        Members:
                                    </div>
                                    <div class="text-muted">
                                        {{ $agent->team->agents->count(); }}
                                    </div>
                                </div>
                                <div class="project-members m-b-15">
                                    <div>Team Leader:</div>
                                    <ul class="team-members">
                                        <li>
                                            <a href="#" data-toggle="tooltip" title="{{ $agent->team?->teamLeader->name }}"><img alt="" src="https://eu.ui-avatars.com/api/?name={{ $agent->team?->teamLeader->name }}&background=e63946&color=fff&size=64"></a>
                                        </li>
                                    </ul>
                                </div>
                                <p class="m-b-5">Progress <span class="text-success float-right">40%</span></p>
                                <div class="progress progress-xs mb-0">
                                    <div style="width: 40%" title="" data-toggle="tooltip" role="progressbar" class="progress-bar bg-success" data-original-title="40%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Team Info Tab -->
            
        </div>



</x-admin-layout>
