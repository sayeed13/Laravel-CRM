<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\User;
use App\Models\Leave;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\LeaveUpdateNotification;

date_default_timezone_set('Asia/Dubai');
class AdminDashboardController extends Controller
{
    use HasRoles;

    public function dashboard() {
        
        return view('admin.dashboard');
    }

    public function mdashboard() {
        
        return view('admin.dashboard');
    }

    public function tdashboard() {
        
        return view('admin.dashboard');
    }

    public function adashboard() {
        
        return view('admin.dashboard');
    }


    public function leaveEdit(){

        $adminLeave = Leave::with('user')->latest()->get();

        return view('leave.leave-edit', [
            'adminLeave' => $adminLeave
        ]);
        
    }

    public function leaveEditForTeamLeader()
    {
        $tleaderID = auth()->user()->id;
        $tleader = User::find($tleaderID);
        $tleaderTeam = $tleader->team_id;

        $adminLeave = Leave::with('user')
            ->whereHas('user', function ($query) use ($tleaderTeam) {
                $query->where('team_id', $tleaderTeam);
            })
            ->latest()
            ->get();

        return view('leave.leave-edit-tleader', [
            'adminLeave' => $adminLeave
        ]);
    }


    public function leaveUpdate(Request $request, $id){
        $leaveStatus = Leave::find($id);
        $leaveStatus->status = $request->status;
        $leaveStatus->reason_for_rejection = $request->reason_for_rejection;
        $leaveStatus->save();

        $user = User::findOrFail($leaveStatus->user_id);
        if($leaveStatus->status == 1) {
            $message = 'Your Leave request has been Approved!';
        }elseif($leaveStatus->status == 2) {
            $message = 'Your Leave request has been Declined!';
        }
        $user->notify(new LeaveUpdateNotification($message));

        return redirect()->back();
    }

    public function monthAttendanceReport(Request $request) {


        $selectedMonth = $request->input('month', date('n'));
        $selectedTeam = $request->input('team', 'all');
        
        // Retrieve the attendance records for the selected month and team
        $attendanceData = Attendance::with(['user', 'breaks'])
            ->when($selectedTeam != 'all', function ($query) use ($selectedTeam) {
                $query->whereHas('user', function ($query) use ($selectedTeam) {
                    $query->where('team_id', $selectedTeam);
                });
            })
            ->whereMonth('created_at', $selectedMonth)
            ->get();
        

        $users = User::query()
            ->with('team', 'leaves')
            ->where('role', 'agent')
            ->when($selectedTeam != 'all', function ($query) use ($selectedTeam) {
                $query->where('team_id', $selectedTeam);
            })
            ->get();

        $teams = Team::all();

        return view('attendance.attendance-month-report', [
            'attendanceData' => $attendanceData,
            'selectedMonth' => $selectedMonth,
            'selectedTeam' => $selectedTeam,
            'users' => $users,
            'teams' => $teams,
        ]);

    }
}
