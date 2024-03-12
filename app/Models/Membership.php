<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;
     protected $fillable = [
        'member_id','employee_id','amount','created_at'
    ];
    public function member(){
        return $this->belongsTo(User::class,'member_id');        
    }

    public function employee(){
        return $this->belongsTo(User::class,'employee_id');        
    }
}
