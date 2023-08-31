<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function index(){

        $managers = User::where('role', 'manager')->with('managerOfTeams')->latest()->get();

        return view('manager.manager-list', [
            'managers' => $managers
        ]);
    }

    public function create(){

        $teams = Team::all();

        return view('manager.manager-create', [
            'teams' => $teams,
        ]);

    }

    public function edit($id){

        $manager = User::findOrFail($id);
        return view('manager.manager-edit', [
            'manager' => $manager,
        ]); 
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
            'agent_code' => 'unique:users',
        ]);

        DB::transaction(function () use ($request) {
            $manager = new User();
            $manager->name = $request->name;
            $manager->email = $request->email;
            $manager->password = $request->password;
            $manager->phone = $request->phone;
            $manager->agent_code = $request->agent_code;
            $manager->role = 'manager';
            $manager->save();
            $manager->assignRole('manager');

            
        });

        return redirect(route('managers.index'));
    }

    public function update(Request $request, $id){

        DB::transaction(function () use ($request, $id) {
            $manager = User::findorFail($id);
            $manager->name = $request->name;
            $manager->email = $request->email;
            $manager->phone = $request->phone;
            $manager->agent_code = $request->agent_code;
            $manager->update();

            
        });

        return redirect(route('managers.index'));
    }


    public function destroy($id){
        $manager = User::findOrFail($id);
        $manager->delete();

        return redirect(route('managers.index'));
    }
}
