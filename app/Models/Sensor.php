<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function sensorDetail(){
        return $this->hasMany(SensorField::class);
    }

    protected $fillable = [
        'sensor_id',
        'user_id',
        'sensor_name',
    ];
}
