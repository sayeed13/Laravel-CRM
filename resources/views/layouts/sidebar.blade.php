<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                @hasanyrole('admin|manager')
                <li>
                    <a href="{{ route('performance.total-leads') }}"><i class="la la-dashboard"></i> <span> Dashboard</span></a>
                </li>
                @endhasanyrole

                

                @role('manager')
                <li> 
                    <a href="{{route('attendance.report')}}"><i class="la la-clipboard-list"></i> <span>Attendance Report</span></a>
                </li>
                <li> 
                    <a href="{{route('attendance.month.report')}}"><i class="la la-clipboard-list"></i> <span>Monthly Report</span></a>
                </li>
                <li> 
                    <a href="{{ route('leads.index') }}" class="noti-dot"><i class="la la-layer-group"></i> <span>Leads</span></a>
                </li>
                <li> 
                    <a href="{{ route('notes.index') }}" ><i class="la la-comment"></i> <span>Notes</span></a>
                </li>
                <li> 
                    <a href="{{ route('teams.index') }}"><i class="la la-handshake-o"></i> <span>Teams</span></a>
                </li>
                <li> 
                    <a href="{{ route('team-leaders.index') }}"><i class="la la-user-friends"></i> <span>Team Leaders</span></a>
                </li>
                <li>
                    <a href="{{ route('agents.index') }}"><i class="la la-users"></i> <span> Agents</span> </a>
                </li>
                <li> 
                    <a href="{{ route('leave.edit') }}"><i class="la la-user-clock"></i> <span>Leaves Request</span></a>
                </li>
                <li> 
                    <a href="{{route('notice.admin.index')}}"><i class="la la-bell"></i> <span>Notice board</span></a>
                </li>
                <li> 
                    <a href="{{ route('profile.edit') }}"><i class="la la-user-circle-o"></i> <span>Profile</span></a>
                </li>
                @endrole

                @role('s_team_leader')
                <li> 
                    <a href="{{ route('leads.index') }}" class="noti-dot"><i class="la la-layer-group"></i> <span>Leads</span></a>
                </li>
                <li>
                    <a href="{{ route('agents.index') }}"><i class="la la-users"></i> <span> Agents</span> </a>
                </li>
                <li> 
                    <a href="{{ route('leads.import.page') }}"><i class="la la-cloud-upload"></i> <span>Leads Import</span></a>
                </li>
                <li> 
                    <a href="{{ route('leads.transfer.page') }}"><i class="las la-exchange-alt"></i> <span>Leads Transfer</span></a>
                </li>
                <li> 
                    <a href="{{ route('leads.report.count') }}"><i class="las la-poll"></i> <span>Leads Report</span></a>
                </li>
                @endrole

                @role('team_leader')
                <li>
                    <a href="{{ route('performance.total-leads-for-tl') }}"><i class="la la-dashboard"></i> <span> Dashboard</span></a>
                </li>
                <li> 
                    <a href="{{ route('attendance.report.tleader') }}"><i class="la la-clipboard-list"></i> <span>Attendance Report</span></a>
                </li>
                <li> 
                    <a href="{{ route('attend.dashboard') }}"><i class="la la-clipboard-check"></i> <span>Attendance</span></a>
                </li>
                <li> 
                    <a href="{{ route('leads.tleader') }}" class="noti-dot"><i class="la la-layer-group"></i> <span>Leads</span></a>
                </li>
                <li>
                    <a href="{{ route('agents.tleader') }}"><i class="la la-users"></i> <span> Agents</span> </a>
                </li>
                <li> 
                    <a href="{{ route('leave.check') }}"><i class="la la-user-times"></i> <span>Leave Apply</span></a>
                </li>
                <li> 
                    <a href="{{ route('leave.edit.tleader') }}"><i class="la la-user-clock"></i> <span>Leaves Request</span></a>
                </li>
                <li> 
                    <a href="{{route('notice.tleader.index')}}"><i class="la la-bell"></i> <span>Notice board</span></a>
                </li>
                <li> 
                    <a href="{{ route('profile.edit') }}"><i class="la la-user-circle-o"></i> <span>Profile</span></a>
                </li>
                @endrole


                @role('agent')
                <li> 
                    <a href="{{ route('attend.dashboard') }}"><i class="la la-clipboard-check"></i> <span>Attendance</span></a>
                </li>
                <li> 
                    <a href="{{ route('leads.agent') }}" class="noti-dot"><i class="la la-layer-group"></i> <span>Leads</span></a>
                </li>
                <li> 
                    <a href="{{ route('leave.check') }}"><i class="la la-user-times"></i> <span>Leaves</span></a>
                </li>
                <li> 
                    <a href="{{route('notice.agent.index')}}"><i class="la la-bell"></i> <span>Notice board</span></a>
                </li>
                <li> 
                    <a href="{{ route('profile.edit') }}"><i class="la la-user-circle-o"></i> <span>Profile</span></a>
                </li>
                @endrole

                @role('admin')
                <li> 
                    <a href="{{ route('managers.index') }}"><i class="la la-user-secret"></i> <span>Managers</span></a>
                </li>
                <li> 
                    <a href="{{ route('attend.dashboard') }}"><i class="la la-clipboard-check"></i> <span>Attendance</span></a>
                </li>
                <li> 
                    <a href="{{ route('leave.check') }}"><i class="la la-user-times"></i> <span>Leaves</span></a>
                </li>
                <li> 
                    <a href="{{route('attendance.report')}}"><i class="la la-clipboard-list"></i> <span>Attendance Report</span></a>
                </li>
                <li> 
                    <a href="{{route('attendance.month.report')}}"><i class="la la-clipboard-list"></i> <span>Monthly Report</span></a>
                </li>
                <li> 
                    <a href="{{ route('leads.index') }}" class="noti-dot"><i class="la la-layer-group"></i> <span>Leads</span></a>
                </li>
                <li> 
                    <a href="{{ route('notes.index') }}" ><i class="la la-comment"></i> <span>Notes</span></a>
                </li>
                <li> 
                    <a href="{{ route('teams.index') }}"><i class="la la-handshake-o"></i> <span>Teams</span></a>
                </li>
                <li> 
                    <a href="{{ route('team-leaders.index') }}"><i class="la la-user-friends"></i> <span>Team Leaders</span></a>
                </li>
                <li> 
                    <a href="{{ route('support-teams.index') }}"><i class="lab la-rocketchat"></i> <span>Support Team</span></a>
                </li>
                <li>
                    <a href="{{ route('agents.index') }}"><i class="la la-users"></i> <span> Agents</span> </a>
                </li>
                <li> 
                    <a href="{{ route('leave.edit') }}"><i class="la la-user-clock"></i> <span>Leaves Request</span></a>
                </li>
                <li> 
                    <a href="{{ route('leads.import.page') }}"><i class="la la-cloud-upload"></i> <span>Leads Import</span></a>
                </li>
                <li> 
                    <a href="{{ route('leads.transfer.page') }}"><i class="las la-exchange-alt"></i> <span>Leads Transfer</span></a>
                </li>
                <li> 
                    <a href="{{route('notice.admin.index')}}"><i class="la la-bell"></i> <span>Notice board</span></a>
                </li>
                <li> 
                    <a href="{{ route('leads.report.count') }}"><i class="las la-poll"></i> <span>Leads Report</span></a>
                </li>
                <li> 
                    <a href="{{ route('profile.edit') }}"><i class="la la-user-circle-o"></i> <span>Profile</span></a>
                </li>
                @endrole

                
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->