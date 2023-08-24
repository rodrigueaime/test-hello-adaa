<?php

namespace App\Http\Resources\Admin;


use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\User as UserResource;
use App\Http\Resources\Admin\Like as LikeResource;


class Like extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'likeable_id' => $this->likeable_id,
            'status' => $this->status,
            'likeable_type' => $this->likeable_type,
            'created_by' =>  new UserResource($this->user),
            'updated_by' => new UserResource($this->user),
        ];
    }
}
