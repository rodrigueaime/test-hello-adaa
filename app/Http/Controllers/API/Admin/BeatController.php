<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Admin\Beat;
use Illuminate\Http\Request;

use App\Services\Admin\BeatService;
use App\Http\Requests\BeatRequest;
use App\Http\Controllers\Controller;
use App\Contract\Admin\BeatInterface;

class BeatController extends Controller
{


    private $BeatRepository;

    public function __construct(BeatInterface $BeatRepository)
    {
        $this->BeatRepository = $BeatRepository;
    }

    public function index()
    {
        return $this->BeatRepository->all();
    }

    public function show(Beat $beat)
    {
        return $this->BeatRepository->show($beat);
    }

    public function store(BeatRequest $request)
    {
        $parms = $request->all();
        $storeFile = new BeatService;
        $parms = $storeFile->StorePremiumOrFree($request, $parms);
        return $this->BeatRepository->store($parms);
    }

    public function update(BeatRequest $request, Beat $beat)
    {
        $parms = $request->all();
        return $this->BeatRepository->update($parms, $beat);
    }

    public function destroy($id)
    {
        return $this->BeatRepository->destroy($id);
    }
}
