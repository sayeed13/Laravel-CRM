<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use App\Models\BreakEntry;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

date_default_timezone_set('Asia/Dubai');

class AttendanceController extends Controller
{
    
    public function attendDashboard()
    {
        $user = auth()->user();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->first();

        return view('attendance.attendance-dashboard', [
            'attendance' => $attendance,
        ]);
    }

    public function timeEntry(Request $request){

        $userID = $request->user()->id;
        $currentTime = Carbon::now();

        // Check if a time entry already exists for the employee today
        $existingTimeEntry = Attendance::where('user_id', $userID)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if (!$existingTimeEntry) {
            $timeEntry = new Attendance([
                'user_id' => $userID,
                'time_in' => $currentTime,
            ]);
            $timeEntry->save(); 
            
            return back()->with('success', 'Time In Record Update Successfully!');
        }else{
            return back()->with('error', 'You Already have Time In Record.');
        }
    }

    // public function timeOut(Request $request){
    //     $userID = $request->user()->id;
    //     $currentTime = Carbon::now();

    //     $timeOut = Attendance::where('user_id', $userID)
    //         ->whereDate('created_at', Carbon::today())
    //         ->whereNotNull('time_in')
    //         ->first();

    //     if ($timeOut) {
    //         $timeOut->time_out = $currentTime;
    //         $timeOut->save();
    //     }
    //     return back();
    // }

    public function timeOut(Request $request)
    {
        $userID = $request->user()->id;
        $currentTime = Carbon::now();

        $timeOut = Attendance::where('user_id', $userID)
            ->whereDate('created_at', Carbon::today())
            ->whereNotNull('time_in')
            ->whereNull('time_out')
            ->first();

        if ($timeOut) {
            $breakEntry = BreakEntry::where('attend_id', $timeOut->id)
                ->whereNotNull('break_in')
                ->whereNull('break_out')
                ->latest()
                ->first();

            if ($breakEntry) {
                return back()->with('error', 'Complete your break before logging time out.');
            }

            $timeOut->time_out = $currentTime;
            $timeOut->save();
            return back()->with('success', 'Time Out Record Update Successfully!');
        }else{
            return back()->with('error', ' Time Entry not exist or you already have Time Out Record.');
        }
    }

    // public function breakEntry(Request $request)
    // {
    //     $userID = $request->user()->id;
    //     $attendfind = Attendance::where('user_id', $userID)
    //         ->whereDate('created_at', Carbon::today())
    //         ->whereNotNull('time_in')
    //         ->first();

    //     if ($attendfind) {
    //         // No time entry exists for the day
    //         // Handle the appropriate error response or redirect
    //         $breakEntry = new BreakEntry([
    //             'attend_id' => $attendfind->id,
    //             'break_in' => Carbon::now(),
    //         ]);
    //         $breakEntry->save();
    //     }
    //     return back();
    // }

    public function breakEntry(Request $request)
    {
        $userID = $request->user()->id;
        $attendfind = Attendance::where('user_id', $userID)
            ->whereDate('created_at', Carbon::today())
            ->whereNotNull('time_in')
            ->whereNull('time_out')
            ->first();

        // Check if a break entry already exists for the user today
        if($attendfind) {
        $existingBreakEntry = BreakEntry::where('attend_id', $attendfind->id)
            ->whereNull('break_out')
            ->first();
        }else{
            return back()->with('error', "You didn't Record Time In yet or You already have Time Out Record.");
        }
        if ($existingBreakEntry) {
            return back()->with('error', 'You are already on a break.');
        }

        if ($attendfind) {
            $breakEntry = new BreakEntry([
                'attend_id' => $attendfind->id,
                'break_in' => Carbon::now(),
            ]);
            $breakEntry->save();
            return back()->with('success', 'Break In Record Update Successfully!');
        }else{
            return back()->with('error', "You didn't Record Time In yet or You already have Time Out Record.");
        }
        
    }


    public function breakOut(Request $request)
    {
        $userID = $request->user()->id;
        $attendfind = Attendance::where('user_id', $userID)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if (!$attendfind) {
            // No time entry exists for the day
            return back()->with('error', "No Time In exists for the day.");
        }

        $breakEntry = BreakEntry::where('attend_id', $attendfind->id)
            ->whereNotNull('break_in')
            ->whereNull('break_out')
            ->latest()
            ->first();

        if (!$breakEntry) {
            // No active break entry exists
            return back()->with('error', "No Break In exists.");
        }

        $breakEntry->break_out = Carbon::now();
        $breakEntry->save();
        return back()->with('success', 'Break Out Record Update Successfully!');
    }

    public function todayAttendanceReportForManager()
    {
        $teams = Team::all();
        return view('attendance.attendance-report',[
            'teams' => $teams
        ]);
    }

    public function todayAttendanceReportForTeamLeader()
    {
        return view('attendance.attendance-report-tleader');
    }

    public function todayBreakReportForManager()
    {
        $teams = Team::all();
        return view('attendance.attendance-break',[
            'teams' => $teams
        ]);
    }

    public function todayBreakReportForTeamLeader()
    {
        return view('attendance.attendance-break-tleader');
    }

    public function todayAbsenseReportForManager()
    {
        $teams = Team::all();
        return view('attendance.attendance-absent',[
            'teams' => $teams
        ]);
    }

    public function todayAbsenseReportForTeamLeader()
    {
        return view('attendance.attendance-absent-tleader');
    }

    

    


}
