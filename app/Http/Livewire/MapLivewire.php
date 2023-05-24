<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Sensor;
use App\Models\SensorField;

class MapLivewire extends Component
{
    public $visibility, $selectionRadio;
    public $geoJson;
    public $sensors, $sensorField;
    public $changedWaterLevel;
    protected $listeners = ['refresh'=>'$refresh'];


    public function mount(){
        $this->sensors = Sensor::orderBy('created_at','desc')->get();
        $this->sensorField = SensorField::orderBy('sensor_id','desc')->get();
    }



    private function loadSensors(){
        $sensors = Sensor::orderBy('created_at','desc')->get();
        
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
                    'waterLevel' => $waterLevelField->field_value
                ]
            ];
        }

        $geoLocation = [
            'type' => 'FeatureCollection',
            'features' => $arrSensors
        ];
        
        $geoJson = collect($geoLocation)->toJson();
        $this->geoJson = $geoJson;
    }
    
    public function filter(){
        
    }

    public function updateSensor(Request $request){
        
        $sensor_id = $request->sensor_id;
        //TODO: $SENSOR_API_KEY

        $currentSensor = Sensor::where('id',$sensor_id)->first();
        
        if($currentSensor->type == 'F'){
            $water_level = $request->waterLevel;
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
        return "Sensor Id: " . $sensor_id;
    }

    public function refresh(){
        $this->render();
    }
    
    public function render()
    {
        $this->loadSensors();
        return view('livewire.map-livewire');
    }
}
