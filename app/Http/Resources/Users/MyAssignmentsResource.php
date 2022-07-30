<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class MyAssignmentsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'employee_name' => $this->employee->name,
            'employee_email' => $this->employee->email,
            'review_id' => $this->pivot->review_id,
            'review' => $this->review,
            'created_by' => $this->user->name,
        ];
    }
}
