<?php

namespace App\Http\Resources\Reviews;

use Illuminate\Http\Resources\Json\JsonResource;

class GetReviewsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "review" => $this->review,
            "employee" => $this->employee->name,
            "created_by" => $this->user->name,
            "assignments" => GetReviewAssignmentsResource::collection($this->assignments),
            "feedback"=> FeedbackResource::collection($this->feedback)
        ];
    }
}
