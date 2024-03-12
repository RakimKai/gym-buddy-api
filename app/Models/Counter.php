<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_id','value'
    ];
    public function member(){
        return $this->belongsTo(User::class,'member_id');        
    }
}
