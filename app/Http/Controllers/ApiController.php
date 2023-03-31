<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;

class ApiController extends Controller
{
    public function getTest(){
        
        return response('getTest API Successfully Called',200)->header('Content-Type', 'text/plain');
    }

    public function postTest(){
        
        return response('postTest API Successfully Called',200)->header('Content-Type', 'text/plain');
    }

    public function update(Request $request){
        $sensor_id = $request->sensor_id;
        $isActivated = $request->isActivated;
        $sensor_data = $request->sensor_data;
        $currentSensor = Sensor::where('sensor_id',$sensor_id);

        //Check for sensor activation
        if($isActivated){
            //If Sensor is already activated
            
            return response()->json([
                'name' => 'Abigail',
                'state' => 'CA',
            ]);
        }else{
            //Check if sensor is activated
            if($currentSensor->is_activated){
                return response()->json([
                    'is_activated' => true,
                    'state' => 'CA',
                ]);
            }else{
                return "Sensor is not yet activated";
            }
        }


        return "Sensor Id: " . $sensor_id;
    }

    private function saveDataFromSensor(){
        
    }
}
