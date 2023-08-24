<?php

namespace App\Repository\Admin;

use DB;
use Auth;
use App\Models\Admin\Beat;
use App\Models\Admin\Like;

use App\Models\Admin\Post;

use App\Traits\ApiResponser;

use Illuminate\Support\Collection;
use App\Contract\Admin\LikeInterface;


class LikeRepository implements LikeInterface
{
    use ApiResponser;
    public function likePost($status, $id)
    {
        try {
                $likePost = Like::where('likeable_id', $id)
                ->where('likeable_type', Post::class)
                ->where('created_by', \Auth::id())
                ->first();
            if($likePost){
                $sql = like::findOrFail($likePost->id);
                $sql->delete();
                return $this->successResponse('', 'dislike Post Successfully!');
            }else{
                $post = Post::find($id);
                $sql = new Like;
                $sql->created_by = \Auth::id();
                $post->likes()->save($sql);
                return $this->successResponse('', 'like Post Successfully!');
            }  
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }
    public function likeBeat(array $parms, $id)
    {
        try {
            $likeBeat = Like::where('likeable_id', $id)
                ->where('likeable_type', Beat::class)
                ->where('created_by', \Auth::id())
                ->first();
            if ($likeBeat) {
                $sql = like::findOrFail($likeBeat->id);
                $sql->delete();
                return $this->successResponse('', 'dislike Beat Successfully!');
            } else {
                $beat = Beat::find($id);
                $sql = new Like;
                $sql->created_by = \Auth::id();
                $beat->likes()->save($sql);
                return $this->successResponse('', 'like Beat Successfully!');
            }
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }
}
