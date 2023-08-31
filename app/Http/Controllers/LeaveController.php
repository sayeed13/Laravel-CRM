<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Notifications\LeaveRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

date_default_timezone_set('Asia/Dubai');
class LeaveController extends Controller
{

    public function check(){

        $userId = auth()->user()->id;
        $leaves = Leave::where('user_id', $userId)->latest()->get();

        
        return view('leave.leave-check', [
            'leaves' => $leaves,
        ]);
    }

    
    public function apply(Request $request){

        $request->validate([
            'date' => 'required',
            'reason' => 'required',
        ]);

        $leave =  new Leave();
        $leave->user_id = $request->user_id;
        $leave->date = Carbon::createFromFormat('d/m/Y', $request->date);
        $leave->to_date = Carbon::createFromFormat('d/m/Y', $request->to_date);
        $leave->reason = $request->reason;
        $leave->save();

        $message = auth()->user()->name . ' applied leave from ' . $request->date . ' to ' . $request->to_date;
        $managers = User::role('manager')->get();
        Notification::send($managers, new LeaveRequestNotification($message));

        return redirect()->back();

    }
}
