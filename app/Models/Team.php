<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Lead;

class Team extends Model
{
    use HasFactory;

    // Relationship with User model (One-to-One - hasOne - team leader)
    // public function teamLeader()
    // {
    //     //return $this->hasOne(User::class, 'team_leader_id');
    //     return $this->hasOne(User::class, 'id')->whereHas('roles', function ($query) {
    //         $query->where('name', 'team_leader');
    //     });
    // }

    public function teamLeader()
    {
        return $this->belongsTo(User::class, 'tleader_id');
    }

    public function manager(){
        return $this->belongsTo(User::class, 'tmanager_id');
    }

    // Relationship with User model (One-to-One - hasOne - agent)
    // public function agent()
    // {
    //     return $this->hasMany(User::class, 'agent_id');
    // }
    public function agents()
    {
        return $this->hasMany(User::class, 'team_id')->where('role', 'agent');
    }

    // Relationship with User model (One-to-One - hasOne - manager)
    // public function manager()
    // {
    //     return $this->hasOne(User::class, 'manager_id');
    // }

    // Relationship with Lead model (One-to-Many - hasMany)
    public function leads()
    {
        return $this->hasMany(Lead::class, 'team_id');
    }

    
}
