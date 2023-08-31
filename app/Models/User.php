<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Lead;
use App\Models\Team;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    // public function team()
    // {
    //     return $this->belongsTo(Team::class, 'team_id', 'tleader_id');
    // }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function managerOfTeams()
    {
        return $this->hasMany(Team::class, 'tmanager_id');
    }

    public function leaderOfTeams()
    {
        return $this->hasMany(Team::class, 'tleader_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function notice()
    {
        return $this->hasMany(Notice::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }
    
    public function leads()
    {
        return $this->hasMany(Lead::class, 'lead_agent_id');
    }


    // public function teamLeaderOf()
    // {
    //     return $this->hasMany(Team::class, 'tleader_id')->whereHas('teamLeader', function ($query) {
    //         $query->whereHas('roles', function ($query) {
    //             $query->where('name', 'team_leader');
    //         });
    //     });
    // }

    //Relationship with Lead model (One-to-Many - hasMany)
    

    // Relationship with User model (One-to-Many - hasMany - team leader)
    // public function teamLeader()
    // {
    //     return $this->belongsTo(User::class, 'team_leader_id');
    // }

    // Relationship with User model (One-to-Many - hasMany - manager)
    // public function managerOf()
    // {
    //     return $this->hasMany(Team::class, 'tmanager_id')->whereHas('manager', function ($query) {
    //         $query->whereHas('roles', function ($query) {
    //             $query->where('name', 'manager');
    //         });
    //     });
    // }

    // Relationship with User model (One-to-Many - hasMany - agent)
    // public function agentOf()
    // {
    //     return $this->hasMany(User::class, 'agent_id');
    // }

    // Relationship with User model (One-to-Many - hasMany - support team leader)
    // public function supportTeamLeaderOf()
    // {
    //     return $this->hasMany(User::class, 'support_team_leader_id');
    // }

    // Relationship with User model (One-to-Many - hasMany - support agent)
    // public function supportAgentOf()
    // {
    //     return $this->hasMany(User::class, 'support_agent_id');
    // }
}
