<div class="card tab-box">
    <div class="row user-tabs">
        <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
            <ul class="nav nav-tabs nav-tabs-bottom">
                {{-- <li class="nav-item"><a href="#team" data-toggle="tab" class="nav-link">Team</a></li> --}}
                <li class="nav-item"><a href="#password" data-toggle="tab" class="nav-link">Password</a></li>
            </ul>
        </div>
    </div>
    </div>

    <div class="tab-content">

        <!-- Team Info Tab -->
        {{-- <div id="team" class="pro-overview tab-pane fade show active">
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="project-title h4"><a href="project-view.html">Team Name</a></h4>
                            <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry. When an unknown printer took a galley of type and
                                scrambled it...
                            </p>
                            <div class="pro-deadline m-b-15">
                                <div class="sub-title">
                                    Members:
                                </div>
                                <div class="text-muted">
                                    20
                                </div>
                            </div>
                            <div class="project-members m-b-15">
                                <div>Team Leader:</div>
                                <ul class="team-members">
                                    <li>
                                        <a href="#" data-toggle="tooltip" title="Jeffery Lalor"><img alt="" src="assets/img/profiles/avatar-16.jpg"></a>
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
        </div> --}}
        <!-- /Team Info Tab -->
        
        <!-- Password Tab -->
        <div class="tab-pane fade show active" id="password">
            <div class="row">
                <div class="col-md-4">
                    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                        <div>
                            <x-input-label for="current_password" :value="__('Current Password')" />
                            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('New Password')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>

                            @if (session('status') === 'password-updated')
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
        <!-- /Password Tab -->
        
    </div>