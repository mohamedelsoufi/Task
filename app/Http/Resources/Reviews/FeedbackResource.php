<?php

namespace App\Http\Resources\Reviews;

use App\Http\Resources\Users\GetUsersResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "reviewer_id" => $this->user_id,
            "reviewer" => new GetUsersResource($this->user),
            "feedback" => $this->feedback,
        ];
    }
}
