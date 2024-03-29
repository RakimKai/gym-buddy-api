<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'created_at'=>$this->created_at,
            'user' => [
                'id'=>(string)$this->user_id,
                'name' => $this->user->name
            ]
        ];
    }
}
