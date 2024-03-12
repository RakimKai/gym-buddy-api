<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Support\Facades\DB;

class CounterController extends Controller
{
    public function enterGym()
    {
        return DB::transaction(function () {
        $count = Counter::lockForUpdate()->count(); 
        Counter::create(); 
        return $count + 1;
        });
    }   

    public function exitGym()
    {
        return DB::transaction(function () {
        $count = max(Counter::lockForUpdate()->count() - 1, 0); 
        Counter::latest()->first()->delete(); 
        return $count;
        });
    }
}
