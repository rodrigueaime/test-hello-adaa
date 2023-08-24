<?php

namespace App\Repository\Admin;

use DB;
use Auth;
use App\Models\Admin\Post;

use Illuminate\Support\Str;
use App\Traits\ApiResponser;

use App\Contract\Admin\PostInterface;
use App\Http\Resources\Admin\Post as PostResource;

class PostRepository implements PostInterface
{
    use ApiResponser;

    public function all()
    {
        try {
            $post = new Post;

            if (isset($_GET['getAllData']) && $_GET['getAllData'] != '') {
                $post = $post->get();
                return $this->successResponse(PostResource::collection($post), 'Data Get Successfully!');
            }
            $post = $post->where('created_by', \Auth::id());
            if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) {
                $numOfResult = $_GET['limit'];
            } else {
                $numOfResult = 100;
            }
            if (isset($_GET['searchParameter']) && $_GET['searchParameter'] != '') {
                $post = $post->searchParameter($_GET['searchParameter']);
            }
            $sortBy = ['id', 'title', 'slug', 'content'];
            $sortType = ['ASC', 'DESC', 'asc', 'desc'];
            if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
                $post = $post->orderBy($_GET['sortBy'], $_GET['sortType']);
            }

            return $this->successResponse(PostResource::collection($post->paginate($numOfResult)), 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function show($post)
    {
        try {
            return $this->successResponse(new PostResource($post), 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function store(array $parms)
    {
        try {
            $sql = new post;
            $parms["slug"] = Str::slug($parms['title'], '-');
            $slug = Post::whereSlug($parms["slug"])->first();
            if($slug){
                return $this->errorResponse('ce slug'. $slug . 'déja excistant');
            }
            if (Auth::check())
                $parms['created_by'] = \Auth::id();
            $sql = $sql->create($parms);
        } catch (Exception $e) {
            return $this->errorResponse();
        }
        if ($sql) {
            return $this->successResponse(new PostResource($sql), 'post Save Successfully!');
        } else {
            return $this->errorResponse();
        }
    }

    public function update(array $parms, $post)
    {
        DB::beginTransaction();
        try {
            if (Auth::check())
                $parms['updated_by'] = \Auth::id();
            $sql = $post->update($parms);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse();
        }

        if ($sql) {
            DB::commit();
            return $this->successResponse(new PostResource($post), 'post Update Successfully!');
        } else {
            DB::rollback();
            return $this->errorResponse();
        }
    }
    public function destroy($post)
    {
        try {
            $sql = Post::findOrFail($post);
            $sql->delete();
        } catch (Exception $e) {
            return $this->errorResponse();
        }
        if ($sql) {
            return $this->successResponse('', 'post Delete Successfully!');
        } else {
            return $this->errorResponse();
        }
    }
}
