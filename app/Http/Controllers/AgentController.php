<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;


class AgentController extends Controller
{
  

    public function index(Request $request){

        return view('agent.agent-list');
    }

    public function agentsOfTeamLeader(){
        return view('agent.agent-list-tleader');
    }

    public function show($id){
        $agent = User::find($id);
        return view('agent.agent-profile', [
            'agent' => $agent,
        ]);
    }

    public function create(){

        $teams = Team::all();
        return view('agent.agent-create',[
            'teams' => $teams,
        ]);

    }

    public function edit($id){

        $agent = User::findOrFail($id);
        $teams = Team::all();
        return view('agent.agent-edit', [
            'agent' => $agent,
            'teams' => $teams
        ]); 
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
            'agent_code' => 'unique:users',
        ]);

        $agent = new User();
        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->password = $request->password;
        $agent->phone = $request->phone;
        $agent->agent_code = $request->agent_code;
        if (auth()->user()->role === 'team_leader') {
            $teamLeader = auth()->user();
            $agent->team_id = $teamLeader->team_id;
        }else {
            $agent->team_id = $request->team_id;
        }
        $agent->save();
        $agent->assignRole('agent');

        $team = Team::find($agent->team_id);
        $team->tagent_id = $agent->id;
        $team->save();

        return back();
    }

    public function update(Request $request, $id){


        $agent = User::findorFail($id);
        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->phone = $request->phone;
        $agent->agent_code = $request->agent_code;
        if (auth()->user()->role === 'team_leader') {
            $teamLeader = auth()->user();
            $agent->team_id = $teamLeader->team_id;
        }else {
            $agent->team_id = $request->team_id;
        }
        $agent->update();

        $team = Team::find($agent->team_id);
        $team->tagent_id = $agent->id;
        $team->save();

        return back();
    }

    public function destroy($id){
        $agent = User::findOrFail($id);
        $agent->delete();

        return redirect(route('agents.index'));
    }

    public function deleteAgentTLeader($id) {
        $agent = User::findOrFail($id);
        $agent->delete();

        return redirect(route('agents.tleader'));
    }


    

}
