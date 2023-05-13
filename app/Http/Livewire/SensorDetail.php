<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\SensorField;

class SensorDetail extends Component
{
    public $sensor_id;
    public $fields, $field_name, $field_description, $field_value, $user_id;
    public $updateMode = false;
    public $inputs = [];
    public $i = 1;

    public function mount(Request $request){
        $this->sensor_id = $request->sensor_id;
    }
    
    public function add($i){
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i){
        unset($this->inputs[$i]);
    }

    private function resetInputFields(){
        $this->field_name = '';
        $this->field_description = '';
    }

    public function store(Request $request){
        $validatedData = $this->validate([
                'field_name.0' => 'required',
                'field_description.0' => 'required',
                'field_name.*' => 'required',
                'field_description.*' => 'required',
            ],
            [
                'field_name.0.required' => 'Field Name is required',
                'field_description.0.required' => 'Description is required',
                'field_name.*.required' => 'Field Name is required',
                'field_description.*.required' => 'Description is required',
            ]
        );
        
        foreach($this->field_name as $key => $value){
            SensorField::create(['sensor_id' => $this->sensor_id,'field_name' => $this->field_name[$key], 'description' => $this->field_description[$key]]);
        }

        $this->inputs = [];
        $this->resetInputFields();

        session()->flash('message', 'Field added successfully.');
    }

    public function render()
    {
        $data = SensorField::all();
        return view('livewire.sensor-detail', ['data' => $data]);
    }
}
