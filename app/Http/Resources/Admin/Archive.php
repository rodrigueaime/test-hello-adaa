<?php

namespace App\Http\Resources\Admin;


use Illuminate\Http\Resources\Json\JsonResource;


class Archive extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'filename' => $this->filename,
            'path' => $this->path,
            'type' => $this->type,
            'extension' => $this->extension,
            'size' => $this->size,
        ];
    }
}
