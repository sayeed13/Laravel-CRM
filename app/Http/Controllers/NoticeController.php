<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notice;
use App\Notifications\NoticeBoardNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NoticeController extends Controller
{
    public function adminIndex(){
        $notices = Notice::with('user')->latest()->get();
        return view('notice.admin-index', [
            'notices' => $notices,
        ]);
    }

    public function tleaderIndex(){
        $ownID = auth()->user()->id;
        $users = User::with('user')->where('role', 'manager')->orWhere('id', $ownID)->get();

        $notices = Notice::whereIn('user_id', $users->pluck('id'))->latest()->get();

        return view('notice.tleader-index', [
            'notices' => $notices,
        ]);
    }

    public function agentIndex(){
        $tleaderID = auth()->user()->team->teamLeader->id;

        $users = User::where('role', 'manager')->orWhere('id', $tleaderID)->get();

        $notices = Notice::with('user')->whereIn('user_id', $users->pluck('id'))->latest()->get();

        return view('notice.agent-index', [
            'notices' => $notices,
        ]);
    }

    public function noticeCreate(){
        return view('notice.notice-create');
    }

    public function noticeStore(Request $request){
 
        $userID = auth()->user()->id;

        $notice = new Notice();
        $notice->user_id = $userID;
        $notice->content = $request->content;
        $notice->save();


        $agentsAndTeamLeaders = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['agent', 'team_leader']);
        })->get();
        $message = 'A new announcement has been published!';
        Notification::send($agentsAndTeamLeaders, new NoticeBoardNotification($message));   

        
        // Check the role of the authenticated user
        if (Auth::user()->role === 'team_leader') {

            return redirect(route('notice.tleader.index'));
        }elseif (Auth::user()->role === 'agent') {
            return redirect(route('notice.agent.index'));
        }else {
            return redirect(route('notice.admin.index'));
        }
    }

    public function noticeDestry($id){
        $notice = Notice::findOrFail($id);
        $notice->delete();

        return redirect(route('notice.admin.index'))->with('message', 'Notice has been deleted successfully!');
    }

}
