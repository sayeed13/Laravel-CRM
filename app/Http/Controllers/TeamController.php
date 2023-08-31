<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function index(){

        $teams = Team::with('manager', 'teamLeader')->latest()->get();

        return view('team.team-list', [
            'teams' => $teams
        ]);
    }

    public function create(){

        $team_leaders = User::with('roles')->where('role', 'team_leader')->get();
        $managers = User::with('roles')->where('role', 'manager')->get();

        return view('team.team-create', [
            'team_leaders' => $team_leaders,
            'managers' => $managers,
        ]);

    }

    public function edit($id){

        $team = Team::findOrFail($id);
        $team_leaders = User::with('roles')->where('role', 'team_leader')->get();
        $managers = User::with('roles')->where('role', 'manager')->get();
        return view('team.team-edit', [
            'team' => $team,
            'team_leaders' => $team_leaders,
            'managers' => $managers,
        ]); 
    }

    public function store(Request $request){
        $request->validate([
            'team_name' => 'required',
        ]);


        DB::transaction(function () use ($request) {
            // Create a new team
            $team = new Team();
            $team->team_name = $request->team_name;
            $team->desc = $request->desc;
            $team->tleader_id = $request->tleader_id;
            $team->tmanager_id = $request->tmanager_id;
            $team->save();


            $leader = User::findOrFail($request->tleader_id);
            $leader->team_id = $team->id;
            $leader->save();

            $manager = User::findOrFail($request->tmanager_id);
            $manager->team_id = $team->id;
            $manager->save();
        });
        

        return redirect(route('teams.index'))->with('message', 'Your Property has been publish successfully!');
    }

    public function update(Request $request, $id){


        DB::transaction(function () use ($request, $id) {
            // Create a new team
            $team = Team::findOrFail($id);
            $team->team_name = $request->team_name;
            $team->desc = $request->desc;
            if($request->tleader_id){
                $pret = $team->teamLeader;
                $pret->team_id = null;
                $pret->save();
            }
            $team->tleader_id = $request->tleader_id;
            if($request->tmanager_id){
                $prem = $team->manager;
                $prem->team_id = null;
                $prem->save();
            }
            $team->tmanager_id = $request->tmanager_id;
            $team->update();

            $leader = User::findOrFail($request->tleader_id);
            $leader->team_id = $team->id;
            $leader->manager_id = $team->tmanager_id;
            $leader->update();


            $manager = User::findOrFail($request->tmanager_id);
            $manager->team_id = $team->id;
            $manager->team_leader_id = $team->tleader_id ;
            $manager->update();
        
        });

        return redirect(route('teams.index'))->with('message', 'Your Property has been publish successfully!');
    }


    public function destroy($id){
        $team = Team::findOrFail($id);
        $team->delete();

        return redirect(route('teams.index'))->with('message', 'Your Property has been publish successfully!');
    }
}



