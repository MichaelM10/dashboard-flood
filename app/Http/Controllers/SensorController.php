<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Sensor;
use Input;

class SensorController extends Controller
{
    public function index(){
        return view('activation.activation');
    }

    public function activationProcess(Request $request){
        $request_sensor_id = $request->get('sensor_id');
        $request_activation_password = $request->get('activation_password');
        $sensor = Sensor::find($request_sensor_id);
        
        //Check if a sensor by the id/code issued by the user exists
        if(!empty($sensor)){
            // If sensor of the correct id/code exists
            // Check if it's already activated
            error_log('Sensor obj: '.$sensor);
            if(!$sensor->is_activated){
                error_log('Sensor Id: '.$request_sensor_id);
                if($request_activation_password == $sensor->activation_password){
                    Sensor::where('id',$request_sensor_id)
                    ->update([  'user_id' => Auth::user()->id,
                                'is_activated' => true               
                            ]);
                    return redirect('/sensor/activation')->with('success',"Sensor activated! Check your sensors at the Dashboard page.");
                }
                else{
                    return redirect()->back()->with('error',"Wrong activation password")->withInput();
                }
            }else{
                return redirect()->back()->with('error', "This SensorKu is already activated.")->withInput();
            }
        }else{
            return redirect()->back()->with('error', "SensorKu with that Id is not found, please check the packaging/casing for the correct Id")->withInput();
        }
    }

    public function indexDetail(Request $request){

        $sensor = json_decode($request->sensor);

        return view("modify.modify",['sensor' => $sensor]);
    }

    public function updateSensor(Request $request){
        $request_sensor_id = $request->sensor_id;
        $sensor = Sensor::where('id', $request_sensor_id)->first();

        $sensor->id = $request_sensor_id;
        $sensor->sensor_name = $request->sensor_name;
        $sensor->visibility = $request->visibility;
        $sensor->access_password = $request->access_password;
        $sensor->selisih_nol = $request->selisih_nol;
        $sensor->update();
        $success="Data saved successfully!";
        
        $request->flash();
        return view("modify.modify",['success' => $success]);
    }

    public function addBookmark(Request $request){

        if(Bookmark::where('user_id', Auth::user()->id)->where('sensor_id', $request->sensor_id)->exists()){
        
        }else{
            $newBookmark = new Bookmark;
            $newBookmark->user_id = Auth::user()->id;
            $newBookmark->sensor_id = $request->sensor_id;
            $newBookmark->save();
        }
        return redirect('/sensor');

    }

    public function removeBookmark(Request $request){
        Bookmark::where('user_id', Auth::user()->id)->where('sensor_id', $request->sensor_id)->delete();
        return redirect('/sensor');
    }
}
