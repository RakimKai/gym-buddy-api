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
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use HttpResponses;

    public function __construct()
    {
    }
    public function get(){
        return $this->success(['user'=>Auth::user()],'User successfully fetched',200);
    }
    public function update(EditUserRequest $request){
        $userInDb = User::where('id',Auth::id())->first();
        if($request->new_password){
            if (!Hash::check($request->current_password, $userInDb->password)){
                return $this->error(null,'Current password is invalid',400);
            }
            $userInDb->password = Hash::make($request->new_password);
        }

       if($request->image){
        $fileName = $request->file('image')->getClientOriginalName();
        $path = url('/storage/images/' . $fileName);
        $request->file('image')->storeAs('images',$fileName,'public'); 
        $userInDb->image = $path;
        }

        $userInDb->update($request->except(['image']));
        return $this->success(['user'=>$userInDb],'User successfully modified',200);
    }

    public function logout(Request $request){ 
        $request->user()->currentAccessToken()->delete(); 
        return $this->success([
        'message'=>'You have been successfully logged out'
        ]);
    }
}
