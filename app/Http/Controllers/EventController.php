<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $events=Event::where("user_id","=",$id)->get();
        return response()->json(['event' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),["event"=>"required",
        "timedate"=>"required",
        "user_id"=>"required"]);
        if($validator->fails()){
            return response()->json(["success"=>false,"message"=>"Campos vacios"]);
        }else{
            $timedate=Carbon::create($request->timedate)->format("Y-m-d H:i");
            
            $event = Event::create([
                "event"=>$request->event,
            "timedate"=>$timedate,
            "code"=>"",
            "user_id"=>$request->user_id,
            "published"=>false
            ]);
            $code=$event->id."-".$request->user_id."-".rand(1,10);
            Event::find($event->id)->update(["code"=>$code]);
            return response()->json(["success"=>true,"message"=>"Evento agregado / Event added",
            "code"=>$code]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    
    
    public function published(Request $request)
    {
        if($request->id!=null){
            $event=Event::find($request->id)->update(["published"=>true]);
            if($event){
                return response()->json(["success"=>true,"message"=>"Evento publicado"]);
            }else{
                return response()->json(["success"=>false,"message"=>"Evento no existente"]);
            }
            
        }else{
            return response()->json(["success"=>false,"message"=>"Evento no existente"]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator=Validator::make($request->all(),["event"=>"required",
        "description"=>"required","timedate"=>"required",
        "code"=>"required","time_in"=>"required","time_out"=>"required",
        "hours"=>"required","user_id"=>"required"]);
        if($validator->fails()){
            return response()->json(["success"=>false,"message"=>"Campos vacios"]);
        }else{
            $event=Event::where("user_id","=",$request->user_id)->update(["event"=>$request->event,
            "description"=>$request->description,"timedate"=>$request->timedate,
            "code"=>$request->code,"time_in"=>$request->time_in,"time_out"=>$request->time_out,
            "hours"=>$request->hours]);
            if($event){
                return response()->json(["success"=>true,"message"=>"Datos actualizados"]);
            }else{
                return response()->json(["success"=>true,"message"=>"Datos no actualizados"]);
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event=Event::find($id);
        if($event!=null){
            $event->delete();
        }
        if($event){
            return response()->json(["success"=>true,"message"=>"Evento eliminado"]);
        }else{
            return response()->json(["success"=>true,"message"=>"Evento no se encontro"]);
        }

    }
    public function show($id){
        if($id!=null){
            $events=Event::join("attendeed","events.id","=","attendeed.event_id")
            ->where("attendeed.gift_id","=",$id)->get();
            if(count($events)>0){
                return response()->json(["success"=>true,"events"=>$events]);
            }else{
                return response()->json(["success"=>true,"message"=>"No hay eventos"]);
            }
            
        }else{
            return response()->json(["success"=>true,"message"=>"No hay id"]);
        }
        
    }
}
