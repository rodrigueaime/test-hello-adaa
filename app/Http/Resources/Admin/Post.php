<?php

namespace App\Http\Resources\Admin;


use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\User as UserResource;
use App\Http\Resources\Admin\Like as LikeResource;


class Post extends JsonResource
{
    public function toArray($request)
    {
        return [
            'post_id' => $this->id,
            'post_slug' => $this->slug,
            'post_title' => $this->title,
            'post_content' => $this->content,
            'created_by' =>  new UserResource($this->user),
            // 'like' => new LikeResource($this->likes),
            'like2' => $this->likes
        ];
    }
}
