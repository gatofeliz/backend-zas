<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request){
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $user=Auth::attempt($request->only(['email', 'password']));
            if(!$user){
                return response()->json([
                    'status' => false,
                    'message' => 'Usuario y/o contraseña incorrectos'
                ]);
            }else{
                $user=User::where("email","=",$request->email)->first();
                return response()->json([
                    'status' => true,
                    'message' => 'Bienvenid@',
                    'data'=>$user,
                    'token'=>$user->createToken("API TOKEN")->plainTextToken
                ]);
            }

            

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    
    }
    public function register(Request $request){
        
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'lastname' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            $user=User::where("email","=",$request->email)->first();
            if($user==null){
                $user=User::create(["name"=>$request->name,
                "lastname"=>$request->lastname,
                "email"=>$request->email,"password"=>Hash::make($request->password)]);
                if($user){
                    return response()->json([
                        'status' => true,
                        'message' => 'Registro exitoso',
                        'token' => $user->createToken("API TOKEN")->plainTextToken,
                        'data'=>$user

                    ]);  
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Campos incorrectos',
                    ]);    
                }
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Usuario no disponibile',
                ]);    
            }
    }
}
