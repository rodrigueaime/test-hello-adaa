<?php

namespace App\Repository\Admin;

use Auth;
use App\Models\User;
use App\Traits\ApiResponser;

use App\Models\User as UserModel;
use App\Models\Admin\PermissionRole;
use App\Contract\Admin\AuthInterface;
use App\Models\Admin\ReabonnementAnal;
use App\Jobs\VerificationEtatAbonnementJob;
use App\Http\Resources\Admin\User as UserResource;

class AuthRepository implements AuthInterface
{
    use ApiResponser;

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

    public function login(array $parms)
    {
        $is_active = User::select('users.*')->where('status','active')->where('email',$parms['email'])->count();
        if($is_active === 0){
                return $this->errorResponse('User access not allowed due to  inactive status.', 422);
        }
        if(auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'user']);
        $admin = User::select('users.*')->find(auth()->guard('user')->user()->id);
     
            $success =  $admin;
            $success['token'] =  $admin->createToken('MyApp',['user'])->accessToken;
            $cookie = $this->getCookieDetails($success['token']);
           
         
            return response()->json([
                'status' => 'Success',
                'token' => $success['token'],
                'user' => $admin,
                'nomComplet' => $admin->nomComplet(),
               
            ], 200)
            ->cookie(
                $cookie['name'], 
                $cookie['value'],
                $cookie['minutes'],
                $cookie['path'], 
                $cookie['domain'], 
                $cookie['secure'],
                $cookie['httponly']
            );
            
        }else{ 
            return $this->errorResponse('The selected password is invalid.', 422);
        }
    }
    public function getCookieDetails($token)
    {
        return [
            'name' => '_token',
            'value' => $token,
            'minutes' => 1440,
            'path' => null,
            'domain' => null,
            // 'secure' => true, // for production
            'secure' => null, // for localhost
            'httponly' => true,
            'type' => 'user',
        ];
    }

    public function logout(array $parms)
    {
        $token = auth()->user()->token();
        $token->revoke();
        $cookie = \Cookie::forget('_token');
            return response()->json([
                'status' => 'Success',
            ])->withCookie($cookie);
        
    }

    public function show()
    {
        try {
            $user = UserModel::where('id', Auth::id())->first();
            return $this->successResponse(new UserResource($user), 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

   

}
