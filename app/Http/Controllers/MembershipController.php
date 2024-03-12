<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMembershipRequest;
use App\Http\Resources\MembershipResource;
use App\Models\Membership;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{ 
    use HttpResponses;
    
    public function store(CreateMembershipRequest $request) {
        $request->validated($request->all());
        $membership = Membership::create([
            'member_id'=>Auth::user()->id,
            'employee_id'=>$request->employee_id,
            'amount'=>$request->amount,
        ]);
        return $this->success(['membership'=>new MembershipResource(($membership))],'Membership successfully created',200);
    }

    public function storeAsEmployee(CreateMembershipRequest $request) {
        $request->validated($request->all());
        $membership = Membership::create([
            'employee_id'=>Auth::user()->id,
            'member_id'=>$request->member_id,
            'amount'=>$request->amount,
        ]);
        return $this->success(['membership'=>new MembershipResource(($membership))],'Membership successfully created',200);
    }

    public function show(Membership $membership)
    {
        return $this->success(['membership'=>new MembershipResource(($membership))],'Membership successfully fetched',200);
    }

    public function getAll()
    {
        $memberships = Membership::orderBy('created_at', 'desc')->get();
        $membershipsResource = MembershipResource::collection($memberships);
        return $this->success(['memberships'=>(($membershipsResource))],'Memberships successfully fetched',200);
    }

    public function getAllByMember()
    {
        $memberships = Membership::where('member_id', Auth::user()->id)->get();
        $membershipsResource = MembershipResource::collection($memberships);
        return $this->success(['memberships' => $membershipsResource], 'Memberships successfully fetched', 200);
    }

    public function update(Request $request, Membership $membership)
    {
        $membership->update($request->all());
        return $this->success(['membership'=>new MembershipResource(($membership))],'Membership successfully modified',200);
    }

    public function destroy(Membership $membership)
    {
        $membership->delete();
        return $this->success(null,'Membership successfully deleted',200);
    }

    public function search(Request $request)
    {
    $name = strtolower($request->name);
    $memberships = Membership::join('users', 'memberships.member_id', '=', 'users.id')
    ->whereRaw('LOWER(users.name) LIKE ?', ['%'.$name.'%'])
    ->get();

    if ($memberships->isEmpty()) {
        return $this->error(null, 'Not found', 404);
    }
    $membershipsResource = MembershipResource::collection($memberships);

    return $this->success(['memberships' => $membershipsResource], 'Memberships successfully fetched', 200);
    }
   
}
