<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
class TrashController extends Controller
{

    public function registerUser(Request $request){
        $user=User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'user_type'=>$request->input('user_type'),
            'password'=>Hash::make($request->input('password')),

        ]);
        return response()->json([
            'status'=>'Success',
        'Data'=> $user
        ]);
      
    }


public function loginUser(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        if (!$token = auth()->attempt($validator->validated()))
        {
            return response() ->json(['error'=>'Unauthorized']);
        }
        return $this->responseWithToken($token);

    }
    protected function responseWithToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->factory()-> getTTL() * 60
        ]);

    }
    

public function deleteUser($id){

        $user=  User::find($id);
        $user ->delete();
           if($user){
                return response()->json([
                    'status'=>True,
                'message'=> "user is deleted"
                ]);
            
        }else
        {
            return response([
                'status'=>false,
                'message'=> "you have no access"
            ]);
            }
    }

 public function trash_all_user(){
        $users= User::withTrashed()->get();
        return response()->json(['Data'=>$users]);
    }

    public function trash_user(){
        $users= User::onlyTrashed()->get();
        return response()->json(['Data'=>$users]);
    }

    public function trash_restore($id){
        $users= User::withTrashed()->find($id);

        if(!is_null($users)){
            $users->restore();
            return response()->json(['Data'=>$users]);
        }
    }

    public function trash_permanent_delete($id){
        $users= User::withTrashed()->find($id);

        if(!is_null($users)){
            $users->forceDelete();
            return response()->json(['Data'=>$users]);
        
        }
    }







}
