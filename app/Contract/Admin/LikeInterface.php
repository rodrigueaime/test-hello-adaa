<?php

namespace App\Contract\Admin;

interface LikeInterface
{
   

    public function likePost(array $parms, $post);

    public function likeBeat(array $parms, $beat);

   

}
