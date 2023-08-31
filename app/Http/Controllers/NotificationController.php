<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    //

    public function delete(){
        Auth::user()->notifications->each(function ($notification) {
            $notification->delete();
        });
        return redirect()->back();
    }
}
