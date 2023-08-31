<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamLeaderController extends Controller
{
    public function index(){

        $team_leaders = User::with('roles', 'team.manager')->where('role', 'team_leader')->latest()->get();

        return view('teamLeader.teamLeader-list', [
            'team_leaders' => $team_leaders
        ]);
    }

    public function create(){

        $managers = User::where('role', 'manager')->get();

        return view('teamLeader.teamLeader-create', [
            'managers' => $managers,
        ]);

    }

    public function edit($id){

        $teamLeader = User::findOrFail($id);
        return view('teamLeader.teamLeader-edit', [
            'teamLeader' => $teamLeader,
        ]); 
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
            'agent_code' => 'unique:users',
        ]);

        $teamLeader = new User();
        $teamLeader->name = $request->name;
        $teamLeader->email = $request->email;
        $teamLeader->password = $request->password;
        $teamLeader->phone = $request->phone;
        $teamLeader->agent_code = $request->agent_code;
        $teamLeader->role = 'team_leader';
        $teamLeader->save();
        $teamLeader->assignRole('team_leader');

        

        return redirect(route('team-leaders.index'))->with('message', 'Your Property has been publish successfully!');
    }

    public function update(Request $request, $id){


        $teamLeader = User::findorFail($id);
        $teamLeader->name = $request->name;
        $teamLeader->email = $request->email;
        $teamLeader->phone = $request->phone;
        $teamLeader->agent_code = $request->agent_code;
        $teamLeader->update();

        return redirect(route('team-leaders.index'))->with('message', 'Your Property has been publish successfully!');
    }


    public function destroy($id){
        $teamLeader = User::findOrFail($id);
        $teamLeader->delete();

        return redirect(route('team-leaders.index'))->with('message', 'Your Property has been publish successfully!');
    }
}
