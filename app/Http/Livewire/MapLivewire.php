<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Bookmark;
use App\Models\Sensor;

class MapLivewire extends Component
{
    public $visibility, $selectionRadio;
    public $geoJson;    

    private function loadSensors(){
        $sensors = Sensor::orderBy('created_at','desc')->get();
        
        $arrSensors = [];
        foreach($sensors as $sensor){
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
                    'sensorDescription' => $sensor->description
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

    public function render()
    {
        $this->loadSensors();
        return view('livewire.map-livewire');
    }
}
