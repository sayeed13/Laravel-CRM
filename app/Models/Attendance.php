<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\BreakEntry;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

date_default_timezone_set('Asia/Dubai');

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'time_in',
        'time_out',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function breaks()
    {
        return $this->hasMany(BreakEntry::class, 'attend_id');
    }

    

    public function calculateWorkingHours()
    {
        $timeIn = $this->time_in;
        $timeOut = $this->time_out ? $this->time_out : now();
    
        $timeIn = Carbon::parse($timeIn);
        $timeOut = Carbon::parse($timeOut);
    
        $workingMins = $timeOut->diffInMinutes($timeIn);
    
        // Subtract break hours
        $workingMins -= $this->calculateBreakHours($this->breaks());
        $totalWorkingHours = floor($workingMins / 60) . ' hrs ' . ($workingMins % 60) . ' mins';

            if ($workingMins >= 12 * 60) {
                return '12 hours exceed';
            }
    
        return $totalWorkingHours;
    }

    

    public function check11Hours(){
        $timeIn = $this->time_in;
        $timeOut = $this->time_out ? $this->time_out : now();
    
        $timeIn = Carbon::parse($timeIn);
        $timeOut = Carbon::parse($timeOut);
    
        $workingMins = $timeOut->diffInMinutes($timeIn);
    
        // Subtract break hours
        $workingMins -= $this->calculateBreakHours($this->breaks());
    
        return $workingMins;
    }

    
    
    public function calculateBreakHours()
    {
        $breakHours = 0;
    
        foreach ($this->breaks as $breakEntry) {
            $breakIn = $breakEntry->break_in;
            $breakOut = $breakEntry->break_out ? $breakEntry->break_out : now();
    
            $breakIn = Carbon::parse($breakIn);
            $breakOut = Carbon::parse($breakOut);
    
            $breakHours += $breakOut->diffInMinutes($breakIn);
        }
    
        return $breakHours;
    }
    
    public function totalBreakHours()
    {
        $breakHours = $this->calculateBreakHours();
        $totalBreakHours = floor($breakHours / 60) . ' hrs ' . ($breakHours % 60) . ' mins';
    
        return $totalBreakHours;
    }

}
