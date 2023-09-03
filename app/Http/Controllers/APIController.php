<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Models\Lead;
use App\Models\User;
use App\Models\Attendance;
use App\Models\BreakEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

date_default_timezone_set('Asia/Dubai');

class APIController extends Controller
{
    public function getLeads(Request $request){
        if (Auth::check()) {
            
            $leads = Lead::with('team:id,team_name', 'agent:id,name')
                            ->select(['id', 'phone', 'username', 'ftd', 'amount', 'status',  'country', 'source', 'lead_agent_id', 'team_id', 'created_at'])
                            ->latest();
            return DataTables::of($leads)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="/leads/'.$row["id"].'" class="edit btn btn-success btn-sm">Open</a> <a class="delete btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#delete_lead" data-lead-id="'.$row['id'].'"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                return $actionBtn;
            })
            ->addColumn('team_id', function(Lead $lead){
                return $lead->team->team_name;
            })
            ->addColumn('source', function(Lead $lead){
                return strtoupper($lead->source);
            })
            ->addColumn('lead_agent_id', function(Lead $lead){
                return ucfirst($lead->agent->name);
            })
            ->addColumn('ftd', function(Lead $lead){
                if($lead->ftd == 1){
                    return '<span class="badge badge-pill badge-success">Yes</span>';
                }else {
                    return '<span class="badge badge-pill badge-danger">No</span>';
                }
            })
            ->addColumn('status', function(Lead $lead){
                if($lead->status == 18){
                    return '<span class="badge bg-inverse-primary">Follow Up</span>';
                }elseif($lead->status == 1){
                    return '<span class="badge bg-inverse-primary">Interested</span>';
                }elseif($lead->status == 2){
                    return '<span class="badge bg-inverse-warning">Not Interested</span>';
                }elseif($lead->status == 3){
                    return '<span class="badge bg-inverse-primary">Existing Customer</span>';
                }elseif($lead->status == 4){
                    return '<span class="badge bg-inverse-danger">Invalid Number</span>';
                }elseif($lead->status == 5){
                    return '<span class="badge bg-inverse-info">New</span>';
                }elseif($lead->status == 6){
                    return '<span class="badge bg-inverse-primary">Switched Off</span>';
                }elseif($lead->status == 7){
                    return '<span class="badge bg-inverse-warning">Call Busy</span>';
                }elseif($lead->status == 8){
                    return '<span class="badge bg-inverse-primary">Message Sent</span>';
                }elseif($lead->status == 9){
                    return '<span class="badge bg-inverse-warning">No Response</span>';
                }elseif($lead->status == 10){
                    return '<span class="badge bg-inverse-success">ID Created</span>';
                }elseif($lead->status == 11){
                    return '<span class="badge bg-inverse-primary">Demo ID Sent</span>';
                }elseif($lead->status == 12){
                    return '<span class="badge bg-inverse-primary">Call After</span>';
                }elseif($lead->status == 13){
                    return '<span class="badge bg-inverse-warning">Waiting Response</span>';
                }elseif($lead->status == 14){
                    return '<span class="badge bg-inverse-primary">Play Later</span>';
                }elseif($lead->status == 15){
                    return '<span class="badge bg-inverse-primary">No Payment Option</span>';
                }elseif($lead->status == 16){
                    return '<span class="badge bg-inverse-danger">Blocked Number</span>';
                }elseif($lead->status == 17){
                    return '<span class="badge bg-inverse-danger">Declined</span>';
                }
            })
            ->addColumn('checkbox', '<input type="checkbox" name="leads_checkbox[]" class="leads_checkbox" value="{{$id}}" />')
            ->filter(function($instance) use ($request){
                if($request->get('ftd') == '0' || $request->get('ftd') == '1'){
                    $instance->where('ftd', $request->get('ftd'));
                }
                if($request->get('status')){
                    $instance->where('status', $request->get('status'));
                }
                if($request->get('team_id')) {
                    $instance->where('team_id', $request->get('team_id'));
                }
                if(!empty($request->get('agent'))) {
                    $agent = $request->get('agent');
                    $instance->where(function($w) use ($agent){
                        $w->orWhereHas('agent', function($q) use ($agent){
                            $q->where('name', 'LIKE', "%$agent%");
                        });
                    });
                }
                if(!empty($request->get('source'))) {
                    $source = $request->get('source');
                    $instance->where(function($w) use ($source){
                        $w->orWhere('source', 'LIKE', "%$source%");
                    });
                }
                if(!empty($request->get('phone'))) {
                    $phone = $request->get('phone');
                    $instance->where(function($w) use ($phone){
                        $w->orWhere('phone', 'LIKE', "%$phone%");
                    });
                }
                if(!empty($request->get('username'))) {
                    $username = $request->get('username');
                    $instance->where(function($w) use ($username){
                        $w->orWhere('username', 'LIKE', "%$username%");
                    });
                }
                if (!empty($request->get('from_date')) && !empty($request->get('to_date'))) {
                    $fromDate = $request->get('from_date');
                    $toDate = $request->get('to_date');
                    $instance->whereBetween('created_at', [$fromDate, $toDate]);
                }
                if ($request->has_amount) {
                    $instance->whereNotNull('amount');
                }
            })
            ->editColumn('created_at', function(Lead $lead){
                return \Carbon\Carbon::parse($lead->created_at)->format('j F Y  h:i A');
            })
            ->order(function ($query) {
                if (request()->has('created_at')) {
                    $query->orderBy('created_at', 'desc');
                }
            })
            ->rawColumns(['checkbox', 'action', 'ftd', 'status', 'from_date', 'to_date', 'has_amount'])
            ->toJson();
        } else {
            return response()->json(['error' => 'Authentication failed'], 401);
        }
    }

    public function getTeamLeads(Request $request){

        if (Auth::check()) {
            $tleader = $request->user()->id;
            $leads = Lead::with('agent:id,name')
                        ->select(['id', 'phone', 'username', 'ftd', 'amount', 'status', 'country', 'source', 'lead_agent_id', 'created_at'])
                        ->whereHas('team', function ($query) use ($tleader) {
                            $query->where('tleader_id', $tleader);
                        })
                        ->latest();
        
            return DataTables::of($leads)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="/leads/'.$row["id"].'" class="edit btn btn-success btn-sm">Open</a>';
                return $actionBtn;
            })
            ->addColumn('lead_agent_id', function(Lead $lead){
                return ucfirst($lead->agent->name);
            })
            ->addColumn('source', function(Lead $lead){
                return strtoupper($lead->source);
            })
            ->addColumn('ftd', function(Lead $lead){
                if($lead->ftd == 1){
                    return '<span class="badge badge-pill badge-success">Yes</span>';
                }else {
                    return '<span class="badge badge-pill badge-danger">No</span>';
                }
            })
            ->addColumn('status', function(Lead $lead){
                if($lead->status == 18){
                    return '<span class="badge bg-inverse-primary">Follow Up</span>';
                }elseif($lead->status == 1){
                    return '<span class="badge bg-inverse-primary">Interested</span>';
                }elseif($lead->status == 2){
                    return '<span class="badge bg-inverse-warning">Not Interested</span>';
                }elseif($lead->status == 3){
                    return '<span class="badge bg-inverse-primary">Existing Customer</span>';
                }elseif($lead->status == 4){
                    return '<span class="badge bg-inverse-danger">Invalid Number</span>';
                }elseif($lead->status == 5){
                    return '<span class="badge bg-inverse-info">New</span>';
                }elseif($lead->status == 6){
                    return '<span class="badge bg-inverse-primary">Switched Off</span>';
                }elseif($lead->status == 7){
                    return '<span class="badge bg-inverse-warning">Call Busy</span>';
                }elseif($lead->status == 8){
                    return '<span class="badge bg-inverse-primary">Message Sent</span>';
                }elseif($lead->status == 9){
                    return '<span class="badge bg-inverse-warning">No Response</span>';
                }elseif($lead->status == 10){
                    return '<span class="badge bg-inverse-success">ID Created</span>';
                }elseif($lead->status == 11){
                    return '<span class="badge bg-inverse-primary">Demo ID Sent</span>';
                }elseif($lead->status == 12){
                    return '<span class="badge bg-inverse-primary">Call After</span>';
                }elseif($lead->status == 13){
                    return '<span class="badge bg-inverse-warning">Waiting Response</span>';
                }elseif($lead->status == 14){
                    return '<span class="badge bg-inverse-primary">Play Later</span>';
                }elseif($lead->status == 15){
                    return '<span class="badge bg-inverse-primary">No Payment Option</span>';
                }elseif($lead->status == 16){
                    return '<span class="badge bg-inverse-danger">Blocked Number</span>';
                }elseif($lead->status == 17){
                    return '<span class="badge bg-inverse-danger">Declined</span>';
                }
            })
            ->editColumn('created_at', function(Lead $lead){
                return $lead->created_at->format('d-m-Y');
            })
            ->order(function ($query) {
                if (request()->has('created_at')) {
                    $query->orderBy('created_at', 'desc');
                }
            })
            ->filter(function($instance) use ($request){
                if($request->get('ftd') == '0' || $request->get('ftd') == '1'){
                    $instance->where('ftd', $request->get('ftd'));
                }
                if($request->get('status')){
                    $instance->where('status', $request->get('status'));
                }
                if(!empty($request->get('agent'))) {
                    $agent = $request->get('agent');
                    $instance->where(function($w) use ($agent){
                        $w->orWhereHas('agent', function($q) use ($agent){
                            $q->where('name', 'LIKE', "%$agent%");
                        });
                    });
                }
                if(!empty($request->get('source'))) {
                    $source = $request->get('source');
                    $instance->where(function($w) use ($source){
                        $w->orWhere('source', 'LIKE', "%$source%");
                    });
                }
                if(!empty($request->get('phone'))) {
                    $phone = $request->get('phone');
                    $instance->where(function($w) use ($phone){
                        $w->orWhere('phone', 'LIKE', "%$phone%");
                    });
                }
                if(!empty($request->get('username'))) {
                    $username = $request->get('username');
                    $instance->where(function($w) use ($username){
                        $w->orWhere('username', 'LIKE', "%$username%");
                    });
                }
            })
            ->rawColumns(['action', 'ftd', 'status'])
            ->toJson();
        } else {
            return response()->json(['error' => 'Authentication failed'], 401);
        }

    }

    public function getAgentLeads(Request $request){

        if (Auth::check()) {
            $agent = $request->user()->id;
            $leads = Lead::where('lead_agent_id', $agent)
                        ->select(['id', 'phone', 'username', 'ftd', 'amount', 'status', 'country', 'source', 'created_at', 'updated_at'])
                        ->latest();
        
            return DataTables::of($leads)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="/leads/'.$row["id"].'" class="edit btn btn-success btn-sm">Open</a>';
                return $actionBtn;
            })
            ->addColumn('source', function(Lead $lead){
                return strtoupper($lead->source);
            })
            ->addColumn('ftd', function(Lead $lead){
                if($lead->ftd == 1){
                    return '<span class="badge badge-pill badge-success">Yes</span>';
                }else {
                    return '<span class="badge badge-pill badge-danger">No</span>';
                }
            })
            ->addColumn('status', function(Lead $lead){
                if($lead->status == 18){
                    return '<span class="badge bg-inverse-primary">Follow Up</span>';
                }elseif($lead->status == 1){
                    return '<span class="badge bg-inverse-primary">Interested</span>';
                }elseif($lead->status == 2){
                    return '<span class="badge bg-inverse-warning">Not Interested</span>';
                }elseif($lead->status == 3){
                    return '<span class="badge bg-inverse-primary">Existing Customer</span>';
                }elseif($lead->status == 4){
                    return '<span class="badge bg-inverse-danger">Invalid Number</span>';
                }elseif($lead->status == 5){
                    return '<span class="badge bg-inverse-info">New</span>';
                }elseif($lead->status == 6){
                    return '<span class="badge bg-inverse-primary">Switched Off</span>';
                }elseif($lead->status == 7){
                    return '<span class="badge bg-inverse-warning">Call Busy</span>';
                }elseif($lead->status == 8){
                    return '<span class="badge bg-inverse-primary">Message Sent</span>';
                }elseif($lead->status == 9){
                    return '<span class="badge bg-inverse-warning">No Response</span>';
                }elseif($lead->status == 10){
                    return '<span class="badge bg-inverse-success">ID Created</span>';
                }elseif($lead->status == 11){
                    return '<span class="badge bg-inverse-primary">Demo ID Sent</span>';
                }elseif($lead->status == 12){
                    return '<span class="badge bg-inverse-primary">Call After</span>';
                }elseif($lead->status == 13){
                    return '<span class="badge bg-inverse-warning">Waiting Response</span>';
                }elseif($lead->status == 14){
                    return '<span class="badge bg-inverse-primary">Play Later</span>';
                }elseif($lead->status == 15){
                    return '<span class="badge bg-inverse-primary">No Payment Option</span>';
                }elseif($lead->status == 16){
                    return '<span class="badge bg-inverse-danger">Blocked Number</span>';
                }elseif($lead->status == 17){
                    return '<span class="badge bg-inverse-danger">Declined</span>';
                }
            })
            ->editColumn('created_at', function(Lead $lead){
                return $lead->created_at->format('d-m-Y');
            })
            ->order(function ($query) {
                if (request()->has('updated_at')) {
                    $query->orderBy('updated_at', 'desc');
                }
            })
            ->filter(function($instance) use ($request){
                if($request->get('ftd') == '0' || $request->get('ftd') == '1'){
                    $instance->where('ftd', $request->get('ftd'));
                }
                if($request->get('status')){
                    $instance->where('status', $request->get('status'));
                }
                if(!empty($request->get('source'))) {
                    $source = $request->get('source');
                    $instance->where(function($w) use ($source){
                        $w->orWhere('source', 'LIKE', "%$source%");
                    });
                }
                if(!empty($request->get('phone'))) {
                    $phone = $request->get('phone');
                    $instance->where(function($w) use ($phone){
                        $w->orWhere('phone', 'LIKE', "%$phone%");
                    });
                }
                if(!empty($request->get('username'))) {
                    $username = $request->get('username');
                    $instance->where(function($w) use ($username){
                        $w->orWhere('username', 'LIKE', "%$username%");
                    });
                }
            })
            ->rawColumns(['action', 'ftd', 'status'])
            ->toJson();
        } else {
            return response()->json(['error' => 'Authentication failed'], 401);
        }

    }


    public function getAttendanceForManager(Request $request){
        if (Auth::check()) {
            $teamId = $request->get('team_id');

            $attendances = Attendance::with(['user', 'breaks'])
                ->whereHas('user', function ($query) use ($teamId) {
                    $query->where('role', 'agent')
                        ->when($teamId, function ($query) use ($teamId) {
                            $query->where('team_id', $teamId);
                        });
                })
                ->whereDate('created_at', Carbon::today())
                ->latest();
    
            return Datatables::of($attendances)
                ->addIndexColumn()
                ->addColumn('name', function ($attendance) {
                    return ucfirst($attendance->user->name);
                })
                ->addColumn('date', function ($attendance) {
                    return \Carbon\Carbon::parse($attendance->created_at)->format('j F Y');
                })
                ->addColumn('time_in', function ($attendance) {
                    return $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '00:00';
                })
                ->addColumn('breaks', function ($attendance) {
                    if ($attendance->breaks->isEmpty()) {
                        return 'No break entries found.';
                    }
    
                    $breaks = '';
                    foreach ($attendance->breaks as $breakEntry) {
                        $breaks .= \Carbon\Carbon::parse($breakEntry->break_in)->format('h:i A');
                        $breaks .= $breakEntry->break_out ? ' - ' . \Carbon\Carbon::parse($breakEntry->break_out)->format('h:i A') : ' -';
                        $breaks .= '<br>';
                    }
                    return $breaks;
                })
                ->addColumn('time_out', function ($attendance) {
                    return $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '00:00';
                })
                ->addColumn('working_hours', function ($attendance) {
                    return $attendance->calculateWorkingHours();
                })
                ->addColumn('break_hours', function ($attendance) {
                    return $attendance->totalBreakHours();
                })
                ->rawColumns(['breaks'])
                ->toJson();
        } else {
            return response()->json(['error' => 'Authentication failed'], 401);
        }
    }



    public function getAttendanceForTeamLeader(Request $request){
        if (Auth::check()) {
            $teamId = auth()->user()->team_id;

            $attendances = Attendance::with(['user', 'breaks'])
                ->whereHas('user', function ($query) use ($teamId) {
                    $query->where('role', 'agent')
                        ->when($teamId, function ($query) use ($teamId) {
                            $query->where('team_id', $teamId);
                        });
                })
                ->whereDate('created_at', Carbon::today())
                ->latest();
    
            return Datatables::of($attendances)
                ->addIndexColumn()
                ->addColumn('name', function ($attendance) {
                    return ucfirst($attendance->user->name);
                })
                ->addColumn('date', function ($attendance) {
                    return \Carbon\Carbon::parse($attendance->created_at)->format('j F Y');
                })
                ->addColumn('time_in', function ($attendance) {
                    return $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '00:00';
                })
                ->addColumn('breaks', function ($attendance) {
                    if ($attendance->breaks->isEmpty()) {
                        return 'No break entries found.';
                    }
    
                    $breaks = '';
                    foreach ($attendance->breaks as $breakEntry) {
                        $breaks .= \Carbon\Carbon::parse($breakEntry->break_in)->format('h:i A');
                        $breaks .= $breakEntry->break_out ? ' - ' . \Carbon\Carbon::parse($breakEntry->break_out)->format('h:i A') : ' - -';
                        $breaks .= '<br>';
                    }
                    return $breaks;
                })
                ->addColumn('time_out', function ($attendance) {
                    return $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '00:00';
                })
                ->addColumn('working_hours', function ($attendance) {
                    return $attendance->calculateWorkingHours();
                })
                ->addColumn('break_hours', function ($attendance) {
                    return $attendance->totalBreakHours();
                })
                ->rawColumns(['breaks'])
                ->toJson();
        } else {
            return response()->json(['error' => 'Authentication failed'], 401);
        }
    }



    public function getBreakForManager(Request $request)
    {
        if (Auth::check()) {
            
            $break = BreakEntry::with(['attendance.user'])
                ->whereDate('created_at', Carbon::today())
                ->whereNotNull('break_in')
                ->whereNull('break_out')
                ->whereHas('attendance', function ($query) {
                    $query->whereNotNull('break_in')
                        ->whereNull('break_out');
                })
                ->latest();

            return Datatables::of($break)
                ->addIndexColumn()
                ->addColumn('name', function ($break) {
                    return ucfirst($break->attendance->user->name);
                })
                ->addColumn('break_in', function ($break) {
                    return \Carbon\Carbon::parse($break->break_in)->format('h:i A');
                })
                ->toJson();
        } else {
            return response()->json(['error' => 'Authentication failed'], 401);
        }
    }

    public function getBreakForTeamLeader(Request $request)
    {
        if (Auth::check()) {
            $teamId = auth()->user()->team_id;
            $break = BreakEntry::with(['attendance.user'])
                    ->whereDate('created_at', Carbon::today())
                    ->whereNotNull('break_in')
                    ->whereNull('break_out')
                    ->whereHas('attendance', function ($query) use ($teamId) {
                        $query->whereNotNull('break_in')
                            ->whereNull('break_out')
                            ->whereHas('user', function ($query) use ($teamId) {
                                $query->where('team_id', $teamId);
                            });
                    })
                    ->latest();

            return Datatables::of($break)
                ->addIndexColumn()
                ->addColumn('name', function ($break) {
                    return ucfirst($break->attendance->user->name);
                })
                ->addColumn('break_in', function ($break) {
                    return \Carbon\Carbon::parse($break->break_in)->format('h:i A');
                })
                ->toJson();
        } else {
            return response()->json(['error' => 'Authentication failed'], 401);
        }
    }

    public function getAbsentForManager(Request $request)
    {
        if (Auth::check()) {
            $teamId = $request->get('team_id');
            $today = Carbon::today();
    
            $absent = User::with(['leaves' => function ($query) use ($today) {
                $query->whereDate('date', '<=', $today)
                      ->whereDate('to_date', '>=', $today);
            }, 'team:id,team_name'])
                ->whereDoesntHave('attendance', function ($query) use ($today) {
                    $query->whereDate('created_at', $today);
                })
                ->where('users.role', 'agent')
                ->when($teamId, function ($query) use ($teamId) {
                    $query->where('users.team_id', $teamId);
                })
                ->latest();
    
            return Datatables::of($absent)
                ->addIndexColumn()
                ->addColumn('name', function ($absent) {
                    return ucfirst($absent->name);
                })
                ->addColumn('status', function ($absent) use ($today) {
                    if ($absent->leaves->isEmpty()) {
                        return 'No Leave Applied';
                    }
    
                    $status = '';
                    foreach ($absent->leaves as $leave) {
                        if($leave->status == 0){
                            return 'Pending';
                        }elseif($leave->status == 1){
                            return 'Accepted';
                        }elseif($leave->status == 2){
                            return 'Declined';
                        }
                    }
                    return $status;
                })
                ->addColumn('team_id', function ($absent) {
                    return $absent->team->team_name;
                })
                ->rawColumns(['status'])
                ->toJson();
        } else {
            return response()->json(['error' => 'Authentication failed'], 401);
        }
    }

    public function getAbsentForTeamLeader(Request $request)
    {
        if (Auth::check()) {
            $teamId = auth()->user()->team_id;
            $today = Carbon::today();

            $absent = User::with(['leaves' => function ($query) use ($today) {
                            $query->whereDate('date', '<=', $today)
                                  ->whereDate('to_date', '>=', $today);
                        }, 'team:id,team_name'])
                        ->whereDoesntHave('attendance', function ($query) {
                            $query->whereDate('created_at', Carbon::today());
                        })
                        ->where('users.role', 'agent')
                        ->when($teamId, function ($query) use ($teamId) {
                            $query->where('users.team_id', $teamId);
                        })
                        ->latest();

            return Datatables::of($absent)
                ->addIndexColumn()
                ->addColumn('name', function ($absent) {
                    return ucfirst($absent->name);
                })
                ->addColumn('status', function ($absent) {
                    if ($absent->leaves->isEmpty()) {
                        return 'No Leave Applied';
                    }
    
                    $status = '';
                    foreach ($absent->leaves as $leave) {
                        if($leave->status == 0){
                            return 'Pending';
                        }elseif($leave->status == 1){
                            return 'Accepted';
                        }elseif($leave->status == 2){
                            return 'Declined';
                        }
                    }
                    return $status;
                })
                ->rawColumns(['status'])
                ->toJson();
        } else {
            return response()->json(['error' => 'Authentication failed'], 401);
        }
    }


    public function getAgentList() {
        if (Auth::check()) {
            $isAdmin = Auth::user()->role === 'admin';

            $agent = User::with('team:id,team_name')
                    ->select('id', 'name', 'agent_code', 'email', 'phone', 'team_id')
                    ->where('role', 'agent')
                    ->latest();

            return Datatables::of($agent)
                    ->addIndexColumn()
                    ->addColumn('team_id', function($agent){
                        return $agent->team->team_name;
                    })
                    ->addColumn('name', function($agent){
                        return '<h2 class="table-avatar">
                        <a href="/agents/'.$agent["id"].'" class="avatar"><img alt="" src="https://eu.ui-avatars.com/api/?name='.$agent['name'].'&background=e63946&color=fff&length=1"></a>
                        <a class="text-capitalize" href="/agents/'.$agent["id"].'">'.$agent["name"].'</a>
                        </h2>';
                    })
                    ->addColumn('action', function($agent) use ($isAdmin){
                        $actionBtn = '';
                        $actionBtn = '<a href="/agents/'.$agent["id"].'/edit" class="edit btn btn-success btn-sm">Edit</a> ';

                        if($isAdmin) {
                            $actionBtn .= ' <a class="delete btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#delete_agent" data-agent-id="' . $agent['id'] . '"><i class="fa fa-trash-o m-r-5"></i> Delete</a>';
                        }
                        
                        return $actionBtn;
                    })
                    ->rawColumns(['action', 'name'])
                    ->toJson();
        } else {
            return response()->json(['error' => 'Authentication failed'], 401);
        }
    }

    public function getAgentListForTeamLeader() {
        if (Auth::check()) {
            $teamId = auth()->user()->team_id;
            $agent = User::select('id', 'name', 'agent_code', 'email', 'phone')
                    ->where('role', 'agent')
                    ->where('team_id', $teamId)
                    ->latest();

            return Datatables::of($agent)
                    ->addIndexColumn()
                    ->addColumn('name', function($agent){
                        return '<h2 class="table-avatar">
                        <a href="/agents/'.$agent["id"].'" class="avatar"><img alt="" src="https://eu.ui-avatars.com/api/?name='.$agent['name'].'&background=e63946&color=fff&length=1"></a>
                        <a class="text-capitalize" href="/agents/'.$agent["id"].'">'.$agent["name"].'</a>
                        </h2>';
                    })
                    ->addColumn('action', function($agent){
                        $actionBtn = '<a href="/agents/'.$agent["id"].'/edit" class="edit btn btn-success btn-sm">Edit</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action', 'name'])
                    ->toJson();
        } else {
            return response()->json(['error' => 'Authentication failed'], 401);
        }
    }

}

