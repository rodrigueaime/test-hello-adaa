<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contract\Admin\LikeInterface;

class LikeController extends Controller
{
    private $LikeRepository;
    public function __construct(LikeInterface $LikeRepository)
    {
        $this->LikeRepository = $LikeRepository;
    }
    public function likePost(Request $request, $post)
    {
        $status = $request->status;
        return $this->LikeRepository->likePost($status, $post);
    }
    public function likeBeat(Request $request, $beat)
    {
        $parms = $request->all();
        return $this->LikeRepository->likeBeat($parms, $beat);
    }

   
  

}
