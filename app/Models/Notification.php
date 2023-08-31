<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

class Notification extends Model
{
    use HasFactory, Prunable;

    public function prunable()
    {
        return Notification::where('created_at', '<=', now()->subWeek());
    }
}
