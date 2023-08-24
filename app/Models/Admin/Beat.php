<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beat extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'premium_file_id',
        'free_file_id',
        'created_by',
        'updated_by',
    ];


    function premium_file()
    {
        return $this->belongsTo(Archive::class, 'premium_file_id', 'id');
    }
    function free_file()
    {
        return $this->belongsTo(Archive::class, 'free_file_id', 'id');
    }
    function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
