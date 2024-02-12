<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Console\Input\Input;
use App\Traits\HttpResponses;

class UserController extends Controller
{
    use HttpResponses;

    public function __construct()
    {
    }
    public function get(){
        return User::where('id',Auth::id())->first();
    }
    public function update(EditUserRequest $request){
        $userInDb = User::where('id',Auth::id())->first();
        $userInDb->update($request->all());
        return $this->success(['user'=>$userInDb],'User successfully modified',200);
    }

    public function logout(Request $request){ 
        $request->user()->currentAccessToken()->delete(); 
        return $this->success([
        'message'=>'You have been successfully logged out'
        ]);
    }
}
