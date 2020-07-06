<?php
namespace TeamAlpha\Web;

class Vehicle
{
    public $id;
    public $driverid;
    public $plateno;
    public $type;
    public $make;
    public $model;
    public $color;
    public $photo;
    public $active;
    public $available;
    public $locationlat;
    public $locationlong;
    public $datecreated;
    public $datemodified;
    
    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->driverid = (int) $data['driverid'] ?? 0;
            $this->plateno = $data['plateno'] ?? null;
            $this->type = $data['type'] ?? null;
            $this->make = $data['make'] ?? null;
            $this->model = $data['model'] ?? null;
            $this->color = $data['color'] ?? null;
            $this->photo = $data['photo'] ?? null;
            $this->active = (int) $data['active'] ?? 0;
            $this->available = (int) $data['available'] ?? 0;
            $this->locationlat = (double) $data['locationlat'] ?? 0;
            $this->locationlong = (double) $data['locationlong'] ?? 0;
            $this->datecreated = $data['datecreated'] ?? null;
            $this->datemodified = $data['datemodified'] ?? null;
        }
    }

}
