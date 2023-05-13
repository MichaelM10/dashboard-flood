<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorField extends Model
{
    use HasFactory;
    
    public function sensor(){
        return $this->belongsTo(Sensor::class);
    }

    protected $fillable = ['sensor_id','field_name', 'description'];
}
