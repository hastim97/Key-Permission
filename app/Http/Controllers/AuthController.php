<?php

namespace App\Http\Controllers;

use App\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{

    protected function register(Request $request)
    {
        $this->validation($request);
        $user = $this->create($request->all());
        return $this->registered($request, $user);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_no' => $data['phone_no'],
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $user->generateToken();

        return response()->json(['message'=>'success','data' => $user->toArray()], 201);
    }

    public function login(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|string|email|max:255|',
            'password' => 'required|string|',
        ]);

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            $user = User::where('email',$request->email)->first();
            $user->generateToken();
            return $user->user_data();
        }
        else
            return response()->json(['message' => 'failed'], 200);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }
        $this->guard()->logout();
        $request->session()->invalidate();
        return response()->json(['data' => 'USER LOGGED OUT.'], 200);

    }

    protected function validation(Request $request)
    {
        return $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone_no' => 'required|string|max:10',
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function getRole(Request $request){
        $api_token = $request->get('api_token');
        $role = User::where('api_token','=',$api_token)->value('role');
        return response()->json($role);
    }

}
