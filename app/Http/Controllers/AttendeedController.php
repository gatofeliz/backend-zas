<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use App\Models\Attendeed;

class AttendeedController extends Controller
{
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),["code"=>"required",
        "attendeed_id"=>"required",
        "gift_id"=>"required"]);
        if($validator->fails()){
            return response()->json(["success"=>false,"message"=>"Campos vacios"]);
        }else{
            $invitation=Event::where("code","=",$request->code)->first();
            
            if($invitation!=null){
                $event = Attendeed::create([
                    "confirmated"=>true,
                    "event_id"=>$invitation->id,"gift_id"=>$request->gift_id,
                    "attendeed_id"=>$request->attendeed_id
                ]);
                if($event){
                    return response()->json(["success"=>true,"message"=>"Invitacion aceptada"]);
                }
            }else{
                return response()->json(["success"=>true,"message"=>"Codigo invalido"]);
            }
            
            
        }
    }
    public function confirmated(Request $request){
        $validator=Validator::make($request->all(),["code"=>"required",
        "invitado_id"=>"required"]);
        if($validator->fails()){
            return response()->json(["success"=>false,"message"=>"Campos vacios"]);
        }else{
            $attendeed=Attendeed::create([
                "name"=>$request->name,
                "confirmated"=>$request->confirmated,
                "event_id"=>$request->event_id,
                "gift_id"=>""
            ]);
        }

    }
}
