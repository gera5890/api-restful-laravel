<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'body' => $this->body,
            'user_id' => UserResource::make($this->whenLoaded('user')),
            'post_id' => PostResource::make($this->whenLoaded('posts'))
        ];
    }
}
