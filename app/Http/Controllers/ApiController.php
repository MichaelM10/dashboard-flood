<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\SensorField;
use App\Http\Livewire\MapLivewire;

class ApiController extends Controller
{
    public function getTest(){
        
        return response('getTest API Successfully Called',200)->header('Content-Type', 'text/plain');
    }

    public function postTest(){
        
        return response('postTest API Successfully Called',200)->header('Content-Type', 'text/plain');
    }

    public function updateSensor(Request $request){
        
        $sensor_id = $request->sensor_id;
        //TODO: $SENSOR_API_KEY

        $currentSensor = Sensor::where('id',$sensor_id)->first();
        

        if($currentSensor->type == 'F'){
            $water_level = $request->waterLevel - $currentSensor->selisih_nol;
            if($water_level < 0) $water_level = 0;
            if($water_level <= 10){
                $currentSensor->status = "BAHAYA";
            }else if($water_level < 20){
                $currentSensor->status = "WASPADA";
            }else{
                $currentSensor->status = "AMAN";
            }
            
            $waterLevelField = SensorField::where([['sensor_id',$sensor_id], ['field_name', "Water Level"]])->first();
            $waterLevelField->field_value = $water_level;
            
            $waterLevelField->save();
            $currentSensor->save();
        }

        //Check for sensor activation from database
        // if($isActivated){
        //     //If Sensor is already activated
            
        //     return response()->json([
        //         'name' => 'Abigail',
        //         'state' => 'CA',
        //     ]);
        // }else{
        //     //Check if sensor is activated
        //     if($currentSensor->is_activated){
        //         return response()->json([
        //             'is_activated' => true,
        //             'state' => 'CA',
        //         ]);
        //     }else{
        //         return "Sensor is not yet activated";
        //     }
        // }

        return "Sensor Id: " . $sensor_id;
    }

    public function getGeoJsonSensorData(){
        $sensors = Sensor::orderBy('created_at','desc')->get();
        
        $arrSensors = [];
        foreach($sensors as $sensor){
            $waterLevelField = SensorField::where([['sensor_id',$sensor->id], ['field_name', "Water Level"]])->first();
            $waterLevel;
            if($waterLevelField->field_value == null){
                $waterLevel = "-----";
            }else $waterLevel = $waterLevelField->field_value;

            $arrSensors[] = [
                'type' => 'Feature',
                'geometry' => [
                    'coordinates' => [$sensor->gps_longitude, $sensor->gps_latitude],
                    'type' => 'Point'
                ],
                'properties' => [
                    'sensorId' => $sensor->id,
                    'sensorName' => $sensor->sensor_name,
                    'status' => $sensor->status,
                    'sensorDescription' => "Alat Pembaca Ketinggian Air pada Sungai Ciliwung, Jembatan Jalan Tomang Raya",
                    'waterLevel' => $waterLevel,
                    'html' => "<div style=\"overflow-y, auto; max-height:400px, width:100%\"><table class=\"table table-sm mt-2\"><tbody><tr><td>Station Name</td><td>" . $sensor->sensor_name . "</td></tr><tr><td>Status</td><td>" . $sensor->status . "</td></tr><tr><td>Water Level</td><td>" . $waterLevel . " cm</td></tr><tr><td>Description</td><td>" . $sensor->description . "</td></tr></tbody></table></div>"
                ]
            ];
        }

        $geoLocation = [
            'type' => 'FeatureCollection',
            'features' => $arrSensors
        ];
        
        $geoJson = collect($geoLocation)->toJson();
        return $geoJson;
    }

    public function getOneGeoJsonSensorData(Request $request, $id){
        $sensors = Sensor::orderBy('created_at','desc')->where('id', $id)->get();
        
        $arrSensors = [];
        foreach($sensors as $sensor){
            $waterLevelField = SensorField::where([['sensor_id',$sensor->id], ['field_name', "Water Level"]])->first();

            $arrSensors[] = [
                'type' => 'Feature',
                'geometry' => [
                    'coordinates' => [$sensor->gps_longitude, $sensor->gps_latitude],
                    'type' => 'Point'
                ],
                'properties' => [
                    'sensorId' => $sensor->id,
                    'sensorName' => $sensor->sensor_name,
                    'status' => $sensor->status,
                    'sensorDescription' => $sensor->description,
                    'waterLevel' => $waterLevelField->field_value,
                    'html' => "<div style=\"overflow-y, auto; max-height:400px, width:100%\"><table class=\"table table-sm mt-2\"><tbody><tr><td>Station Name</td><td>" . $sensor->sensor_name . "</td></tr><tr><td>Status</td><td>" . $sensor->status . "</td></tr><tr><td>Water Level</td><td>" . $waterLevelField->field_value . " cm</td></tr><tr><td>Description</td><td>" . $sensor->description . "</td></tr></tbody></table></div>"
                ]
            ];
        }

        $geoLocation = [
            'type' => 'FeatureCollection',
            'features' => $arrSensors
        ];
        
        $geoJson = collect($geoLocation)->toJson();
        return $geoJson;
    }

    private function saveDataFromSensor(){
        
    }

}