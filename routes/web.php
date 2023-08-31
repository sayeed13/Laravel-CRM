<?php


use Pusher\Pusher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeamLeaderController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SupportTeamController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//$role = Auth::user()?->role;

Route::get('/login', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function() {
    Route::resource('/agents', AgentController::class);
    Route::resource('/managers', ManagerController::class);
    Route::resource('/leads', LeadController::class);

    Route::get('/admin', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/manager', [AdminDashboardController::class, 'dashboard'])->name('manager.dashboard');
    Route::get('/team-leader', [AdminDashboardController::class, 'dashboard'])->name('teamleader.dashboard');
    Route::get('/agent', [AdminDashboardController::class, 'dashboard'])->name('agent.dashboard');

    Route::post('/leads/{id}/notes', [LeadController::class, 'storeNote'])->name('leads.notes.store');
    Route::post('/leads/{id}/reminder', [LeadController::class, 'storeReminder'])->name('leads.reminder.store');

    
    Route::get('/teams/{team}/agents', [LeadController::class, 'getAgentsByTeam']);
    Route::get('get-agents/{team}', [LeadController::class, 'getAgents'])->name('leads.getAgents');
    Route::get('/notices/create', [NoticeController::class, 'noticeCreate'])->name('notice.create');
    Route::post('/notices/create/store', [NoticeController::class, 'noticeStore'])->name('notice.store');

    Route::post('/atttendance/time-entry', [AttendanceController::class, 'timeEntry'])->name('timeEntry.store');
    Route::post('/atttendance/time-out', [AttendanceController::class, 'timeOut'])->name('timeOut.store');
    Route::post('/atttendance/break-entry', [AttendanceController::class, 'breakEntry'])->name('breakEntry.store');
    Route::post('/atttendance/break-out', [AttendanceController::class, 'breakOut'])->name('breakOut.store');

    
    Route::get('notifications/delete', [NotificationController::class, 'delete'])->name('notifications.delete');

    


//Common Routes for Admin/Manager/Support Team
Route::group(['middleware' => ['role:admin|manager|s_team_leader']], function(){
    Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('/agents', [AgentController::class, 'index'])->name('agents.index');
    Route::get('/leads-export', [LeadController::class, 'export'])->name('leads.export');
    Route::get('/lead-report-count', [LeadController::class, 'GenerateTotalReport'])->name('leads.report.count');
});

//Common Routes for Team Leader/Agent/Admin
Route::group(['middleware' => ['role:team_leader|agent|admin']], function(){
    Route::get('/attendance', [AttendanceController::class, 'attendDashboard'])->name('attend.dashboard');
    Route::get('/leaves', [LeaveController::class, 'check'])->name('leave.check');
    Route::post('/leave/req', [LeaveController::class, 'apply'])->name('leave.request');
});


//Support Team Route List
Route::group(['middleware' => ['role:admin|s_team_leader']], function(){
    //Leads Import And Distribution Routes
    Route::get('/leads-import', [LeadController::class, 'leadImportPage'])->name('leads.import.page');
    Route::get('/leads-transfer', [LeadController::class, 'leadsTransferPage'])->name('leads.transfer.page');
    Route::post('/leads-transfer-action', [LeadController::class, 'transferLeads'])->name('lead.transfer');
    Route::post('/leads-distribute', [LeadController::class, 'leadImportAndDistribute'])->name('leads.import.distribute');
});


// Manager's Route List
Route::group(['middleware' => ['role:manager|admin']], function () {
    //Rsourrce Controller
    Route::resource('/team-leaders', TeamLeaderController::class);
    Route::resource('/teams', TeamController::class);
    Route::resource('/support-teams', SupportTeamController::class);

    //Chart API Routes
    Route::get('/lead-api', [PerformanceController::class, 'getLeadApi']);
    Route::get('/team-api', [PerformanceController::class, 'getTeamApi']);
    Route::get('/agent-api/{teamId}/{agentId}', [PerformanceController::class, 'getAgentApi']);

    //Sidebar Menu Routes
    Route::get('/performance-leads', [PerformanceController::class, 'totalLeadsReport'])->name('performance.total-leads');
    Route::get('/month-att-report', [AdminDashboardController::class, 'monthAttendanceReport'])->name('attendance.month.report');
    Route::get('/attendance-report', [AttendanceController::class, 'todayAttendanceReportForManager'])->name('attendance.report');
    Route::get('/attendance-report/absent', [AttendanceController::class, 'todayAbsenseReportForManager'])->name('attendance.report.absent');
    Route::get('/attendance-report/break', [AttendanceController::class, 'todayBreakReportForManager'])->name('attendance.report.break');
    Route::get('/leave/edit', [AdminDashboardController::class, 'leaveEdit'])->name('leave.edit');
    Route::put('/leave/update/{id}', [AdminDashboardController::class, 'leaveUpdate'])->name('leave.update');
    Route::get('/notices-admin', [NoticeController::class, 'adminIndex'])->name('notice.admin.index');
    Route::delete('/notices-admin/{id}', [NoticeController::class, 'noticeDestry'])->name('notice.destroy');
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
});


//Team Leader's Route List
Route::group(['middleware' => ['role:team_leader|admin']], function(){
    Route::get('/leads-export-tleader', [LeadController::class, 'exportDataTL'])->name('leads.export.tleader');
    Route::get('/lead-for-tl-api', [PerformanceController::class, 'getLeadForTlAPI']);
    Route::get('/performance-leads-tleader', [PerformanceController::class, 'agentLeadsReportForTL'])->name('performance.total-leads-for-tl');
    Route::get('/attendance-report-tleader', [AttendanceController::class, 'todayAttendanceReportForTeamLeader'])->name('attendance.report.tleader');
    Route::get('/attendance-report/absent-tleader', [AttendanceController::class, 'todayAbsenseReportForTeamLeader'])->name('attendance.report.absent.tleader');
    Route::get('/attendance-report/break-tleader', [AttendanceController::class, 'todayBreakReportForTeamLeader'])->name('attendance.report.break.tleader');
    Route::get('/leads-tleader', [LeadController::class, 'LeadsForTeamLeader'])->name('leads.tleader');
    Route::get('/agents-tleader', [AgentController::class, 'agentsOfTeamLeader'])->name('agents.tleader');
    Route::delete('/agents-tleader/{id}', [AgentController::class, 'deleteAgentTLeader'])->name('agents.destroy.tleader');
    Route::get('/notices-tleader', [NoticeController::class, 'tleaderIndex'])->name('notice.tleader.index');
    Route::get('/leave-tleader/edit', [AdminDashboardController::class, 'leaveEditForTeamLeader'])->name('leave.edit.tleader');
});

//Agent's Route List
Route::group(['middleware' => ['role:agent|admin']], function() {
    Route::get('/leads-agent', [LeadController::class, 'LeadsForAgent'])->name('leads.agent');
    Route::get('/notices', [NoticeController::class, 'agentIndex'])->name('notice.agent.index');
});


//Leads
Route::get('/leads-tleader-data', [APIController::class, 'getTeamLeads'])->name('api.leads-tleader.index');
Route::get('/leads-agent-data', [APIController::class, 'getAgentLeads'])->name('api.leads-agent.index');
Route::get('/leads-data', [APIController::class, 'getLeads'])->name('api.leads.index');
Route::post('/leads/removeall', [LeadController::class, 'removeall'])->name('leads.removeall');

//Attendance Report
Route::get('/attend-data-for-manager', [APIController::class, 'getAttendanceForManager'])->name('api.attendReport.manager');
Route::get('/attend-data-for-teamleader', [APIController::class, 'getAttendanceForTeamLeader'])->name('api.attendReport.teamleader');
Route::get('/break-data-for-manager', [APIController::class, 'getBreakForManager'])->name('api.breakReport.manager');
Route::get('/break-data-for-teamleader', [APIController::class, 'getBreakForTeamLeader'])->name('api.breakReport.teamleader');
Route::get('/absent-data-for-manager', [APIController::class, 'getAbsentForManager'])->name('api.absentReport.manager');
Route::get('/absent-data-for-teamleader', [APIController::class, 'getAbsentForTeamLeader'])->name('api.absentReport.teamleader');

//Agent List
Route::get('/agent-data', [APIController::class, 'getAgentList'])->name('api.agentList.manager');
Route::get('/agent-data-tleader', [APIController::class, 'getAgentListForTeamLeader'])->name('api.agentList.teamleader');





});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
