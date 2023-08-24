<?php

namespace App\Repository\Admin;

use DB;
use App\Models\User;
use App\Models\Admin\Role;
use App\Traits\ApiResponser;
use Illuminate\Support\Collection;
use App\Models\Admin\UserWarehouse;
use App\Contract\Admin\UserInterface;
use App\Http\Resources\Admin\User as UserResource;

class UserRepository implements UserInterface
{
    use ApiResponser;
    /**
     * @return Collection
     */
    public function all()
    {
        try {
            if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) {
                $numOfResult = $_GET['limit'];
            } else {
                $numOfResult = 100;
            }
            $user = new User;
            $sortBy = ['id','first_name','last_name','email'];
            $sortType = ['ASC', 'DESC', 'asc', 'desc'];
            if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
                $user = $user->orderBy($_GET['sortBy'], $_GET['sortType']);
            }

            if (isset($_GET['searchParameter']) && $_GET['searchParameter'] != '') {
                $user = $user->searchParameter($_GET['searchParameter']);
            }
            
            return $this->successResponse(UserResource::collection($user->paginate($numOfResult)) , 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function show($user)
    {
        try {
            return $this->successResponse(new UserResource($user) , 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function store(array $parms)
    {
        $parms['password'] = bcrypt($parms['password']);
        try {
            DB::beginTransaction();
            $sql = new User;
          
            $sql = $sql->create($parms);
         
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse();
        }
        if ($sql) {
            return $this->successResponse(new UserResource($sql), 'User Save Successfully!');
        } else {
            return $this->errorResponse();
        }
    }



    public function destroy($user)
    {
        try {
            $sql = User::where('id',$user)->delete();
        } catch (Exception $e) {
            return $this->errorResponse();
        }
        if ($sql) {
            return $this->successResponse('', 'User Delete Successfully!');
        } else {
            return $this->errorResponse();
        }
    }

}
