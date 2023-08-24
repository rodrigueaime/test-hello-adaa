<?php

namespace App\Repository\Admin;

use DB;
use Auth;
use App\Models\Admin\Beat;
use Illuminate\Support\Str;

use App\Traits\ApiResponser;

use Illuminate\Support\Collection;
use App\Contract\Admin\BeatInterface;

use App\Http\Resources\Admin\Beat as BeatResource;

class BeatRepository implements BeatInterface
{
    use ApiResponser;

    public function all()
    {
        try {
            $beat = new Beat;
            if (isset($_GET['getAllData']) && $_GET['getAllData'] != '') {
                $beat = $beat->get();
                return $this->successResponse(BeatResource::collection($beat), 'Data Get Successfully!');
            }
            $beat = $beat->where('created_by', \Auth::id());
            if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) {
                $numOfResult = $_GET['limit'];
            } else {
                $numOfResult = 100;
            }
            if (isset($_GET['searchParameter']) && $_GET['searchParameter'] != '') {
                $beat = $beat->searchParameter($_GET['searchParameter']);
            }
            $sortBy = ['id', 'title', 'slug'];
            $sortType = ['ASC', 'DESC', 'asc', 'desc'];
            if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
                $beat = $beat->orderBy($_GET['sortBy'], $_GET['sortType']);
            }

            return $this->successResponse(BeatResource::collection($beat->paginate($numOfResult)), 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function show($beat)
    {
        try {
            return $this->successResponse(new BeatResource($beat), 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function store(array $parms)
    {
        try {
            $sql = new Beat;
            $parms["slug"] = Str::slug($parms['title'], '-');
            if (Auth::check())
                $parms['created_by'] = \Auth::id();
            $sql = $sql->create($parms);
        } catch (Exception $e) {
            return $this->errorResponse();
        }

        if ($sql) {
            return $this->successResponse(new BeatResource($sql), 'beat Save Successfully!');
        } else {
            return $this->errorResponse();
        }
    }

    public function update(array $parms, $beat)
    {
        DB::beginTransaction();
        try {
            if (Auth::check())
                $parms['updated_by'] = \Auth::id();
            $sql = $recepteur->update($parms);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse();
        }

        if ($sql) {
            DB::commit();
            return $this->successResponse(new BeatResource($beat), 'beat Update Successfully!');
        } else {
            DB::rollback();
            return $this->errorResponse();
        }
    }

    public function destroy($beat)
    {
        try {
            $sql = Beat::findOrFail($beat);
            $sql->delete();
        } catch (Exception $e) {
            return $this->errorResponse();
        }

        if ($sql) {
            return $this->successResponse('', 'beat Delete Successfully!');
        } else {
            return $this->errorResponse();
        }
    }
}
