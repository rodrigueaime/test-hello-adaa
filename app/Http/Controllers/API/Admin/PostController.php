<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Admin\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Contract\Admin\PostInterface;

class PostController extends Controller
{
    private $PostRepository;

    public function __construct(PostInterface $PostRepository)
    {
        $this->PostRepository = $PostRepository;
    }

    public function index()
    {
        return $this->PostRepository->all();
    }

    public function show(PostRequest $Recepteur)
    {
        return $this->PostRepository->show($Recepteur);
    }

    public function store(PostRequest $request)
    {
        $parms = $request->all();
        return $this->PostRepository->store($parms);
    }

    public function update(PostRequest $request, Post $Recepteur)
    {
        $parms = $request->all();
        return $this->PostRepository->update($parms, $Recepteur);
    }

    public function destroy($id)
    {
        return $this->PostRepository->destroy($id);
    }
}
