<?php
namespace TeamAlpha\Web;

class FareList
{
    public $id;
    public $vehicle_type;
    public $base_fare;
    public $per_km;
    public $per_minute;
    public $surge_rush_threshold;
    public $surge_rush_multiplier;
    public $surge_time_multiplier;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->vehicle_type = $data['vehicle_type'] ?? null;
            $this->base_fare = (double) $data['base_fare'] ?? null;
            $this->per_km = (double) $data['per_km'] ?? null;
            $this->per_minute = (double) $data['per_minute'] ?? null;
            $this->surge_rush_threshold = (int) $data['surge_rush_threshold'] ?? null;
            $this->surge_rush_multiplier = (double) $data['surge_rush_multiplier'] ?? null;
            $this->surge_time_multiplier = (double) $data['surge_time_multiplier'] ?? null;
        }
    }
}
