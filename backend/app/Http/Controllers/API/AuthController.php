<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            $response['success'] = false;
            $response['message'] = 'Validation Error';
            $response['data'] = $validator->errors();
            return response()->json($response);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] =  $user->createToken('auth_token')->plainTextToken;
        $success['name'] =  $user->name;

        $response['success'] = true;
        $response['message'] = 'Successfully Logged In';
        $response['data'] = $success;

        return response()->json($response);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('auth_token')->plainTextToken;
            $success['name'] =  $user->name;

            $response['success'] = true;
            $response['message'] = 'Login successfully!';
            $response['data'] = $success;

            return response()->json($response);
        }
        else{
            $response['success'] = false;
            $response['message'] = 'Not Authorized!';
            // $response['data'] = ;

            return response()->json($response);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
        }

        $response['success'] = true;
        $response['message'] = 'Successfully logged out';
        return response()->json($response);
    }


    public function users(){
        $response['success'] = true;
        $response['message'] = 'Users list';
        $response['data'] = User::all();
        return response()->json($response);
    }
}
