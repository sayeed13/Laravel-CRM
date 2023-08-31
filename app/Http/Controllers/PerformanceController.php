<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\Lead;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;
use Symfony\Component\Console\Input\Input;

class PerformanceController extends Controller
{
    //

    public function totalLeadsReport()
    {
        // $sources = Lead::groupBy('source')
        // ->whereNotNull('source')
        // ->select('source', DB::raw('count(*) as count'))
        // ->orderByDesc('count')
        // ->limit(5)
        // ->get();

        $sources = Lead::groupBy(DB::raw('LOWER(source)'))
        ->whereNotNull('source')
        ->select(DB::raw('LOWER(source) as source'), DB::raw('count(*) as count'))
        ->orderByDesc('count')
        ->limit(4)
        ->get();

        // $countries = Lead::whereNotNull('country')
        // ->groupBy('country')
        // ->select('country', DB::raw('count(*) as count'))
        // ->orderByDesc('count')
        // ->limit(5)
        // ->get();

        $agentCounts = Lead::where('ftd', '=', '1')
        ->groupBy('lead_agent_id')
        ->select('lead_agent_id', DB::raw('count(*) as count'))
        ->orderByDesc('count')
        ->limit(5)
        ->get();
        

        // Step 3: Get the user names for the top 5 lead agents
        $topAgents = User::whereIn('id', $agentCounts->pluck('lead_agent_id')->toArray())
        ->select('id', 'name')
        ->get();

        $currentMonthStartDate = Carbon::now()->startOfMonth();
        $currentMonthEndDate = Carbon::now()->endOfMonth();

        $tmCount = Lead::where('ftd', '=', '1')
        ->whereBetween('created_at', [$currentMonthStartDate, $currentMonthEndDate])
        ->groupBy('lead_agent_id')
        ->select('lead_agent_id', DB::raw('count(*) as count'))
        ->orderByDesc('count')
        ->limit(5)
        ->get();

        $tmAgents = User::whereIn('id', $tmCount->pluck('lead_agent_id')->toArray())
        ->select('id', 'name')
        ->get();

        $teams = Team::all();

        //count of total leads/username/ftd/amount
        $totalLeads = Lead::count();
        $totalSignup = Lead::whereNotNull('username')->count();;
        $totalFtd = Lead::where('ftd', 2)->count();
        $totalAmount = Lead::sum('amount');


         return view('performance.total-leads', [
            'sources' => $sources,
            //'countries' => $countries,
            'agentCounts' => $agentCounts,
            'topAgents' => $topAgents,
            'tmCount' => $tmCount,
            'tmAgents' => $tmAgents,
            'teams' => $teams,
            'totalLeads' => $totalLeads,
            'totalSignup' => $totalSignup,
            'totalFtd' => $totalFtd,
            'totalAmount' => $totalAmount,
         ]);
    }

    //Agent Lead Performance for Team Leader
    public function agentLeadsReportForTL() {
        $teamId = auth()->user()->team_id;
        $agents = User::where('team_id', $teamId)
                    ->where('role', 'agent')
                    ->get();
        
        
        return view('performance.total-leads-for-tleader',[
            'agents' => $agents,
        ]);
    }

    public function getLeadAPI(Request $request)
    {
        $teamId = $request->input('team_id');
        $query = Lead::select([
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as value'),
            DB::raw('SUM(CASE WHEN ftd = 2 THEN 1 ELSE 0 END ) AS ftd_leads'),
            DB::raw('SUM(CASE WHEN username IS NOT NULL THEN 1 ELSE 0 END) as username_leads')
        ]);
        if (!empty($teamId)) {
            $query->where('team_id', $teamId);
        }
        $stats = $query
                ->groupBy('date')
                ->orderBy('date')
                ->get();

        foreach ($stats as $stat) {
            $conversionRatio = $stat->username_leads > 0 ? $stat->ftd_leads / $stat->username_leads : 0;
            $stat->conversion_ratio = round($conversionRatio * 100, 2) . '%';
        }

        return response()->json($stats);
    }

    // Agent's Lead Report For Team Leader

    public function getLeadForTlAPI(Request $request)
    {
        $agentId = $request->input('user_id');
        $query = Lead::select([
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as value'),
            DB::raw('SUM(CASE WHEN ftd = 2 THEN 1 ELSE 0 END ) AS ftd_leads'),
            DB::raw('SUM(CASE WHEN username IS NOT NULL THEN 1 ELSE 0 END) as username_leads')
        ]);
        if (!empty($agentId)) {
            $query->where('lead_agent_id', $agentId);
        }
        $stats = $query
                ->groupBy('date')
                ->orderBy('date')
                ->get();

        foreach ($stats as $stat) {
            $conversionRatio = $stat->username_leads > 0 ? $stat->ftd_leads / $stat->username_leads : 0;
            $stat->conversion_ratio = round($conversionRatio * 100, 2) . '%';
        }

        return response()->json($stats);
    }

    // public function getTeamApi(Request $request)
    // {

    //     $currentMonthStartDate = Carbon::now()->startOfMonth();
    //     $currentMonthEndDate = Carbon::now()->endOfMonth();
        

    //     $leads = DB::table('leads')
    //         ->select([
    //             'team_id',
    //             DB::raw('COUNT(*) as lead_count'),
    //             DB::raw('SUM(CASE WHEN ftd = 2 THEN 1 ELSE 0 END ) AS ftd_count'),
    //             DB::raw('SUM(CASE WHEN username IS NOT NULL THEN 1 ELSE 0 END) as signup_count')
    //         ])
    //         ->whereBetween('created_at', [$currentMonthStartDate, $currentMonthEndDate])
    //         ->groupBy('team_id')
    //         ->orderBy('team_id', 'ASC')
    //         ->get();

    //     $convertedLeads = $leads->map(function ($stat) {
    //         $team = Team::find($stat->team_id);
    //         $conversionRatio = $stat->signup_count > 0 ? $stat->ftd_count / $stat->signup_count : 0;
    //         return [
    //             'team_name' => $team ? $team->team_name : null,
    //             'lead_count' => $stat->lead_count,
    //             'ftd_count' => $stat->ftd_count,
    //             'signup_count' => $stat->signup_count,
    //             'conversion_ratio' => round($conversionRatio * 100, 2) . '%',
    //         ];
    //     });


    //     return response()->json($convertedLeads);

    // }

    public function getAgentApi(Request $request, $teamId, $agentId)
    {
        $stats = Lead::select([
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as leads'),
            DB::raw('SUM(CASE WHEN ftd = 2 THEN 1 ELSE 0 END) as ftd_leads'),
            DB::raw('SUM(CASE WHEN username IS NOT NULL THEN 1 ELSE 0 END) as username_leads')
        ])
        ->where('team_id', $teamId)
        ->where('lead_agent_id', $agentId)
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        $chartData = $stats->map(function ($stat) {
            $conversionRatio = $stat->username_leads > 0 ? $stat->ftd_leads / $stat->username_leads : 0;
            $conversionRatio = round($conversionRatio * 100, 2);
            return [
                'date' => $stat->date,
                'leads' => $stat->leads,
                'ftd_leads' => $stat->ftd_leads,
                'username_leads' => $stat->username_leads,
                'conversion_ratio' => $conversionRatio
            ];
        });

        return response()->json($chartData);
    }

    
}
