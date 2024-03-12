<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>(string)$this->id,
            'amount' => $this->amount,
            'created_at'=>$this->created_at,
            'member' => [
                'id'=>(string)$this->member_id,
                'name' => $this->member->name,
            ],
            'employee' => [
                'id'=>(string)$this->employee_id,
                'name' => $this->employee->name,
            ]
        ];
    }
}
