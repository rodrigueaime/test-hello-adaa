<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'path',
        'type',
        'extension',
        'size',
    ];


    public static function getAllowedFiles()
    {
        return ['zip', 'rar', '7z'];
    }

    public static function getAllowedDocuments()
    {
        return ['pdf', 'doc', 'docx', 'pptx', 'ppt', 'xls', 'xlsx', 'txt'];
    }

    public static function getAllowedImages()
    {
        return ['png', 'jpg', 'jpeg', 'gif', '.ico', '.psd', '.tif', '.webp'];
    }

    public static function getAllowedVideos()
    {
        return ['mp4', 'avi', 'mkv', 'm4v', 'mpg', 'mpeg', 'mov', '3gp'];
    }

    function getExistAttribute()
    {
        return File::exists(storage_path('app/public/uploads/' . $this->filename));
    }
}
