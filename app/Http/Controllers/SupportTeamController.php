<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportTeamController extends Controller
{
    public function index(){
        $supportTeam = User::where('role', 'support_team_leader')
                        ->latest()
                        ->get();

        return view('support_team.support-list', [
            'supportTeam' => $supportTeam
        ]);
    }

    public function create(){
        return view('support_team.support-create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        DB::transaction(function () use ($request) {
            $support_team = new User();
            $support_team->name = $request->name;
            $support_team->email = $request->email;
            $support_team->password = $request->password;
            $support_team->role = 'support_team_leader';
            $support_team->save();
            $support_team->assignRole('s_team_leader');
        });

        return back();
    }

    public function destroy($id){
        $support_team = User::findOrFail($id);
        $support_team->delete();

        return back();
    }
}
