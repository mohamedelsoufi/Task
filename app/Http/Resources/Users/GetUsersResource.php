<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class GetUsersResource extends JsonResource
{
    function toArray($request)
    {
        return [
            "id" => $this->id,
            "image" => $this->image,
            "name" => $this->name,
            "email" => $this->email,
            "is_admin" => $this->is_admin,
        ];
    }
}
