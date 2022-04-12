<?php

namespace App\Repository\RepoExtend;

use App\Repository\AppBusinessProcessEloquent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AuthRepository extends AppBusinessProcessEloquent
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function ValidateFormLogin()
    {
        return array(
            'email' => 'required|email',
            'password' => 'required',
        );
    }

    public function login($req)
    {
        if (Auth::attempt(['email' => $req['email'], 'password' => $req['password']])) {
            $user = Auth::user();
            $response['response'] = $user->createToken('nApp')->accessToken;
            $response['code'] = Response::HTTP_OK;
        } else {
            $response['response'] = 'UNAUTHORIZED';
            $response['code'] = Response::HTTP_UNAUTHORIZED;
        }
        return $response;
    }

    public function ValidateFormRegister()
    {
        return array(
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        );
    }

    public function register($req)
    {
        try {
            DB::beginTransaction();
            $input = $req;
            $input['password'] = bcrypt($input['password']);
            $user = $this->model->create($input);
            DB::commit();
            $response['response'] = $user->createToken('nApp')->accessToken;
            $response['code'] = Response::HTTP_OK;
        } catch (\Exception $e) {
            DB::rollback();
            $response['response'] = $e->getMessage();
            $response['code'] = Response::HTTP_BAD_REQUEST;
        }
        return $response;
    }

    public function details()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if (request()->user()->can($permission->name)) {
                $permissions[] = $permission->name;
            }
        }
        $res['user'] = Auth::user();
        $res['permission'] = $permissions;
        $response['response'] = $res;
        $response['code'] = Response::HTTP_OK;
        return $response;
    }

    public function updateProfile($req)
    {
        $response['response'] = 'UNAUTHORIZED';
        $response['code'] = Response::HTTP_UNAUTHORIZED;
        if (Auth::check()) {
            $id = Auth::user()->id;
            User::find($id)->update([
                'name' => $req['name'],
                'email' => $req['email'],
            ]);
            $response['response'] = 'success';
            $response['code'] = Response::HTTP_OK;
        }
        return $response;
    }

    public function updatePassword($req)
    {
        $input = $req;
        $userid = Auth::guard('api')->user()->id;
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("code" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $arr = array("code" => 400, "response" => "Check your old password.", "data" => array());
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                    $arr = array("code" => 400, "response" => "Please enter a password which is not similar then current password.", "data" => array());
                } else {
                    User::where('id', Auth::user()->id)->update(['password' => Hash::make($input['new_password'])]);
                    $arr = array("code" => 200, "response" => "Password updated successfully.", "data" => array());
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("status" => 400, "response" => $msg, "data" => array());
            }
        }
        return $arr;
    }

    public function signout()
    {
        $response['response'] = 'UNAUTHORIZED';
        $response['code'] = Response::HTTP_UNAUTHORIZED;
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            $response['response'] = 'token has logout';
            $response['code'] = Response::HTTP_OK;
        }
        return $response;
    }
}
