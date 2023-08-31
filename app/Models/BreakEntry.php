<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;

class BreakEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'attend_id',
        'break_in',
        'break_out',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attend_id');
    }
}
