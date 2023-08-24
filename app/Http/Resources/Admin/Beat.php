<?php

namespace App\Http\Resources\Admin;


use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\Archive as ArchiveResource;
use App\Http\Resources\Admin\User as UserResource;


class Beat extends JsonResource
{
    public function toArray($request)
    {
        return [
            'beat_id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'premium_file_id' =>  new ArchiveResource($this->premium_file),
            'free_file_id' =>  new ArchiveResource($this->free_file),
            'created_by' =>  new UserResource($this->user),
        ];
    }
}
