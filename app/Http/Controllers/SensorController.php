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

    public function indexChangeLocation(Request $request){

        $sensor_id = $request->sensor_id;
        $sensor_name = $request->sensor_name;
        $gps_longitude = $request->gps_longitude;
        $gps_latitude = $request->gps_latitude;
        // error_log($sensor_name);
        // error_log($sensor_id);
        return view("modify.change-location",['sensor_id' => $sensor_id, 'sensor_name' => $sensor_name, 'gps_longitude' => $gps_longitude, 'gps_latitude'=>$gps_latitude]);
    }

    public function saveNewLocation(Request $request){
        $request_sensor_id = $request->sensor_id;
        $sensor_name = $request->sensor_name;
        $new_longitude = $request->new_longitude;
        $new_latitude = $request->new_latitude;

        $old_longitude = $request->old_longitude;
        $old_latitude = $request->old_latitude;

        $return_long = $old_longitude;
        $return_lat = $old_latitude;
        $message="Nothing Changed";

        if($new_longitude == null || $new_latitude == null){
            $message="Nothing Changed";
        }else{
            $sensor = Sensor::where('id', $request_sensor_id)->first();
    
            $sensor->gps_longitude = $new_longitude;
            $sensor->gps_latitude = $new_latitude;
            
            $sensor->save();
    
            $return_long = $new_longitude;
            $return_lat = $new_latitude;
            $message="Station/sensor location changed successfully!";
        }

        return view("modify.change-location", ['message' => $message, 'sensor_id' => $request_sensor_id, 'gps_longitude' => $return_long, 'gps_latitude' => $return_lat, 'sensor_name' => $sensor_name]);
    }

    public function updateSensor(Request $request){
        $request_sensor_id = $request->sensor_id;
        $sensor = Sensor::where('id', $request_sensor_id)->first();

        $sensor->id = $request_sensor_id;
        $sensor->sensor_name = $request->sensor_name;
        $sensor->visibility = $request->visibility;
        $sensor->access_password = $request->access_password;
        $sensor->selisih_nol = $request->selisih_nol;

        $gps_latitude = $sensor->gps_latitude;
        $gps_longitude = $sensor->gps_longitude;

        $sensor->update();
        $success="Data saved successfully!";
        
        $request->flash();
        return view("modify.modify",['success' => $success, 'gps_latitude' => $gps_latitude, 'gps_longitude' => $gps_longitude]);
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
