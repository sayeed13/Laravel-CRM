<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Team;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        // other fillable attributes
        'phone',
        'lead_agent_id',
        'team_id'
    ];

    // Relationship with User model (One-to-One - belongsTo - agent)
    public function agent()
    {
        return $this->belongsTo(User::class, 'lead_agent_id');
    }

    // Relationship with Team model (One-to-One - belongsTo)
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    // Define a mutator to convert the source to lowercase before saving to the database
    public function setSourceAttribute($value)
    {
        $this->attributes['source'] = strtoupper($value);
    }

    // Define an accessor to return the source in lowercase when retrieved from the database
    public function getSourceAttribute($value)
    {
        return ucfirst($value);
    }
}
