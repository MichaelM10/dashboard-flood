<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use App\Models\Sensor;
use App\Models\SensorField;

class WaterLevel implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    public $sensor;
    public $sensorField;
    public $waterLevel;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, Sensor $sensor, SensorField $sensorField, $waterLevel)
    {
        $this->sensor = $sensor;
        $this->sensorField = $sensorField;
        $this->waterLevel = $waterLevel;
    }

    public function broadcastWith(Type $var = null){
        return [
            'user' => $this->user->id,
            'sensor' => $this->sensor->id,
            'sensor_field' => $this->sensorField->id,
            'waterLevel' => $this->waterLevel

        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return new Channel('waterLevel');
    }
}
