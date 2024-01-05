<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Guest;
use App\Models\Gift;
use Illuminate\Support\Facades\Validator;

class GiftController extends Controller
{
    public function index($id){
        if($id!=null){
            $gifts=Gift::where("event_id","=",$id)->get();
            return response()->json(["success"=>true,"gifts"=>$gifts]);
        }else{
            return response()->json(["success"=>false,"message"=>"ID no recibido"]);
        }
    }
    public function store(Request $request){
        if($request->event_id!=null){
            $validator=Validator::make($request->all(),["name"=>"required",
            "event_id"=>"required",
            "user_id"=>"required"]);
            if($validator->fails()){
                return response()->json(["success"=>false,"message"=>"Campos vacios"]);
            }else{
                $archivo="";
                if($request->file('photo')){
                    $carpeta="public/images/".$request->user_id;
                    
                   if (!is_dir($carpeta)) {
                       mkdir($carpeta, 0777, true);
                   }
                   $archivo = time().'.'.$request->photo->extension();
                   $request->photo->storeAs($carpeta, $archivo);
                }
                $gift=Gift::create(["name"=>$request->name,"photo"=>$archivo,
                "event_id"=>$request->event_id,"user_id"=>$request->user_id]);
                
                return response()->json(["success"=>true,"message"=>"Regalo agregado"]);
            }

        }else{
            return response()->json([
                "success"=>false,
                "message"=>"Id de evento no enviado"
            ]);
        }
    }
    public function update(Request $request){
        $validator=Validator::make($request->all(),["name"=>"required",
        "gift_id"=>"required",
        "user_id"=>"required"]);
        if($validator->fails()){
            return response()->json(["success"=>false,"message"=>"Campos vacios"]);
        }else{
            $archivo="";
            if($request->file('photo')){
                $carpeta="public/images/".$request->user_id;    
                if (!is_dir($carpeta)) {
                    mkdir($carpeta, 0777, true);
                }
                $archivo = time().'.'.$request->photo->extension();
                $request->photo->storeAs($carpeta, $archivo);
            }
            $gifts=Gift::find($request->gift_id)->update([
                "name"=>$request->name,
                "photo"=>$archivo,
                "user_id"=>$request->user_id
            ]);
            if($gifts){
                return response()->json(["success"=>true,
                "message"=>"Regalo actualizado"]);
            }else{
                return response()->json(["success"=>false,
                "message"=>"Regalo no actualizado"]);
            }
        }
        
    }
    public function destroy($id){
        if($id!=null){
            $gift=Gift::find($id)->delete();
            if($gift){
                return response()->json(["success"=>true,"message"=>"Regalo eliminado"]);
            }else{
                return response()->json(["success"=>true,"message"=>"Regalo no existente"]);
            }
        }else{

        }
        
    }
    
    
    
}

