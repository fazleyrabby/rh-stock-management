<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse|Response
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $customTokenString = Str::random(64);
        $user->tokens()->create([
            'name' => 'auth_token',
            'token' => $customTokenString,
        ]);
        $response['token'] =  $customTokenString;
        $response['name'] =  $user->name;

        return $this->sendResponse($response, 'Successfully Logged In');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse|Response
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['name'] =  $user->name;

            $customTokenString = Str::random(64);
            $user->tokens()->create([
                'name' => 'auth_token',
                'token' => $customTokenString,
            ]);

            $success['token'] =  $customTokenString;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError("Not Authorized!");
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse('Logged Out','Successfully logged out');
    }


    public function users(){
        $response = User::all()->toArray();
        return $this->sendResponse('Successfully fetched users!',$response);
    }
}
