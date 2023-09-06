<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Note;
use App\Models\Team;
use App\Models\User;
use App\Exports\LeadsExport;
use App\Imports\LeadsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeadsExportForTeamLeader;
use Illuminate\Support\Facades\Validator;
use App\Notifications\LeadAssignedNotification;

class LeadController extends Controller
{
    // Lead Count
    public function GenerateTotalReport(Request $request)
    {
        
        $startDate = $request->input('from_datetime');
        $endDate = $request->input('to_datetime');

        $totalLeads = Lead::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalSignup = Lead::whereBetween('created_at', [$startDate, $endDate])->whereNotNull('username')->count();;
        $totalFtd = Lead::whereBetween('created_at', [$startDate, $endDate])->where('ftd', 2)->count();
        $totalAmount = Lead::whereBetween('created_at', [$startDate, $endDate])->sum('amount');

        return view('lead.lead-report-count', [
            'totalLeads' => $totalLeads,
            'totalSignup' => $totalSignup,
            'totalFtd' => $totalFtd,
            'totalAmount' => $totalAmount,
        ]);
    }

    // All Lead Export
    public function export()
    {

        if (auth()->user()->role === 'admin' or auth()->user()->role === 'manager' or auth()->user()->role === 'support_team_leader') {
            return Excel::download(new LeadsExport(), 'leads.xlsx');
        } else {
            return 'you are not authorized!';
        }
    }

    // Lead Export For Team Leader
    public function exportDataTL()
    {
        if (auth()->user()->role === 'team_leader' or auth()->user()->role === 'admin') {
            return Excel::download(new LeadsExportForTeamLeader(), 'leads.xlsx');
        } else {
            return 'you are not authorized!';
        }
    }


    public function index()
    {
        $teams = Team::select('id', 'team_name')->get();
        return view('lead.lead-list', [
            'teams' => $teams,
        ]);
    }

    public function LeadsForTeamLeader()
    {
        // checking follow up leads for Team Leader panel
        $user = Auth::user();
        $userRole = 'team_leader';
        if ($user && $user->hasRole($userRole)) {
            $team_id = $user->team_id;
        }
        $hasFollowUpLeads = Lead::where('team_id', $team_id)
            ->where('status', 18)
            ->count();
        return view('lead.lead-list-tleader', compact('hasFollowUpLeads'));
    }

    public function LeadsForAgent()
    {

        // checking follow up leads for agent panel
        $user = Auth::user();
        $userRole = 'agent';
        if ($user && $user->hasRole($userRole)) {
            $user_id = $user->id;
        }
        $hasFollowUpLeads = Lead::where('lead_agent_id', $user_id)
            ->where('status', 18)
            ->count();

        return view('lead.lead-list-agent', compact('hasFollowUpLeads'));
    }

    public function show($id)
    {

        $lead = Lead::findOrFail($id);
        $teams = Team::select('id')->get();
        $notes = Note::with('user')->where('lead_id', $id)->orderBy('created_at', 'asc')->get();

        return view('lead.lead-profile', [
            'lead' => $lead,
            'teams' => $teams,
            'notes' => $notes
        ]);
    }

    public function storeNote(Request $request)
    {
        $request->validate([
            'lead_id' => 'required|exists:leads,id',
            'text' => 'required',
        ]);

        $note = new Note();
        $note->lead_id = $request->lead_id;
        $note->user_id = auth()->user()->id;
        $note->text = $request->text;
        $note->save();

        return back();
    }

    public function create()
    {
        $teams = Team::all();
        $agent = null; // Initialize the $agent variable if needed

        // Check if the authenticated user has the role 'agent'
        if (auth()->user()->role === 'agent') {
            $agent = auth()->user(); // Assign the authenticated user to $agent
        }
        return view('lead.lead-create', compact('teams', 'agent'));
    }

    public function getAgentsByTeam(Request $request, Team $team)
    {
        $agents = $team->agents()->get();

        return response()->json(['agents' => $agents]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^([0-9\+]*)$/|unique:leads|min:10|max:14',
        ]);

        if ($request->username) {
            $usernameCheck = Lead::where('username', $request->username)->first();
            if ($usernameCheck) {
                return back()->with('error', 'Username is already exist!');
            }
        }

        $lead = new Lead();
        $lead->phone = $request->phone;
        $lead->username = $request->username;
        $lead->ftd = $request->ftd;
        $lead->source = $request->source;
        $lead->country = $request->country;
        $lead->status = $request->status;
        if (auth()->user()->role === 'agent') {
            $agentid = auth()->user();
            $lead->team_id = $agentid->team_id;
        } else {
            $lead->team_id = $request->team_id;
        }
        $lead->lead_agent_id = $request->lead_agent_id; //lead assinged User
        $lead->save();

        $user = User::findOrFail($lead->lead_agent_id);
        $message = 'You have a new lead' . $lead->phone . ' assign!';
        $lead_id = $lead->id;
        $user->notify(new LeadAssignedNotification($message, $lead_id));


        return back()->with('success', 'Lead Added Successfully!');
    }

    public function update(Request $request, $id)
    {

        $lead = Lead::find($id);
        if (
            auth()->user()->role === 'admin'
            or auth()->user()->role === 'manager'
            or auth()->user()->role === 'team_leader'
            or auth()->user()->role === 'support_team_leader'
            or auth()->user()->id === $lead->lead_agent_id
        ) {

            $lead->username = $request->username;
            $lead->status = $request->status;
            $lead->amount = $request->amount;
            if (auth()->user()->role === 'agent') {
                $agentid = auth()->user();
                $lead->lead_agent_id = $agentid->id;
            } else {
                $lead->lead_agent_id = $request->lead_agent_id;
            }
            $lead->ftd = $request->ftd;
            $lead->update();
            return back()->with('success', 'Lead Updated Successfully!');
        } else {
            return back()->with('error', 'You are not authorized to update.');
        }
    }

    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return back()->with('success', 'Lead Deleted Successfully');
    }

    function removeall(Request $request)
    {
        $leads_id_array = $request->input('id');
        Lead::whereIn('id', $leads_id_array)->delete();

        return response()->json(['message' => 'Leads deleted successfully']);
    }


    public function leadImportPage()
    {
        $teams = Team::all();
        return view('lead.lead-import', [
            'teams' => $teams,
        ]);
    }

    // Lead Import fetch Agents
    public function getAgents(Team $team)
    {
        $agents = $team->agents;
        return response()->json($agents);
    }

    public function leadImportAndDistribute(Request $request)
    {
        if (
            auth()->user()->role === 'admin'
            or auth()->user()->role === 'manager'
            or auth()->user()->role === 'support_team_leader'
        ) {

            DB::transaction(function () use ($request) {
                $file = $request->file('file');
                $teamId = $request->input('team_id');
                $source = $request->input('source');
                $team = Team::findOrFail($teamId);

                // Import leads from the file
                $import = new LeadsImport;
                Excel::import($import, $file);

                $importedLeads = $import->getLeads();

                // Get selected agent IDs for lead distribution
                $selectedAgents = $request->input('selected_agents', []);

                // Get agents with time_in set in attendance table for today
                $agents = $team->agents()
                    ->whereIn('id', $selectedAgents)
                    ->withCount('leads')
                    ->whereHas('attendance', function ($query) {
                        $query->whereDate('time_in', now()->toDateString());
                    })
                    ->orderBy('leads_count')
                    ->get();

                //dd($agents->toArray());

                // Calculate the distribution
                $totalLeadsCount = count($importedLeads);
                $agentsCount = $agents->count();
                $leadsPerAgent = floor($totalLeadsCount / $agentsCount);
                $remainingLeads = $totalLeadsCount % $agentsCount;

                // Distribute the imported leads to the selected agents
                $agentIndex = 0;

                foreach ($importedLeads as $leadData) {
                    $lead = Lead::where('phone', $leadData->phone)->first();

                    if ($lead) {
                        $agent = $agents[$agentIndex];
                        $lead->lead_agent_id = $agent->id;
                        $lead->team_id = $agent->team_id;
                        $lead->source = $source;
                        $lead->save();

                        // Move to the next agent
                        $agentIndex = ($agentIndex + 1) % $agentsCount;
                    }
                }
            });
            return redirect()->back()->with('success', 'Leads Imported successfully!');
        } else {
            return redirect()->back()->with('error', 'You Are not Authorized!');
        }
    }

    public function leadsTransferPage()
    {
        $teams = Team::all();

        return view('lead.lead-transfer', [
            'teams' => $teams,
        ]);
    }

    public function transferLeads(Request $request)
    {
        $sourceAgentId = $request->input('source_agent_id');
        $targetAgentId = $request->input('target_agent_id');

        if (empty($sourceAgentId) || empty($targetAgentId)) {
            return redirect()->back()->with('error', 'Please select both source and target agents.');
        }

        if ($sourceAgentId === $targetAgentId) {
            return redirect()->back()->with('error', 'Source and target agents cannot be the same.');
        }

        // Using a database transaction to ensure data consistency
        DB::beginTransaction();

        try {
            // Transfer leads from the source agent to the target agent
            Lead::where('lead_agent_id', $sourceAgentId)->update(['lead_agent_id' => $targetAgentId]);

            // Commit the transaction if all queries are successful
            DB::commit();

            return redirect()->back()->with('success', 'Leads transferred successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if any query fails
            DB::rollback();

            // Handle the error or show an error message
            return redirect()->back()->with('error', 'Failed to transfer leads.');
        }
    }
}
