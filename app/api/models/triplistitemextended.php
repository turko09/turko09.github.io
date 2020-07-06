<?php
namespace TeamAlpha\Web;

class TripListItemExtended
{
    public $id;
    public $vehicleid;
    public $passengerid;
    public $source;
    public $sourcelat;
    public $sourcelong;
    public $destination;
    public $destinationlat;
    public $destinationlong;
    public $stage;
    public $datestart;
    public $dateend;
    public $amount;
    public $datecreated;
    public $passengerfirstname;
    public $passengerlastname;
    public $plateno;
    public $type;
    public $make;
    public $model;
    public $color;
    public $driverfirstname;
    public $driverlastname;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->vehicleid = $data['vehicleid'] === null ? null : (int) $data['vehicleid'];
            $this->passengerid = (int) $data['passengerid'] ?? 0;
            $this->source = $data['source'] ?? null;
            $this->sourcelat = (double) $data['sourcelat'] ?? 0;
            $this->sourcelong = (double) $data['sourcelong'] ?? 0;
            $this->destination = $data['destination'] ?? null;
            $this->destinationlat = (double) $data['destinationlat'] ?? 0;
            $this->destinationlong = (double) $data['destinationlong'] ?? 0;
            $this->stage = $data['stage'] ?? null;
            $this->datestart = $data['datestart'] ?? null;
            $this->dateend = $data['dateend'] ?? null;
            $this->amount = $data['amount'] === null ? null : (double) $data['amount'];
            $this->datecreated = $data['datecreated'] ?? null;
            $this->passengerfirstname = $data['passengerfirstname'] ?? null;
            $this->passengerlastname = $data['passengerlastname'] ?? null;
            $this->plateno = $data['plateno'] ?? null;
            $this->type = $data['type'] ?? null;
            $this->make = $data['make'] ?? null;
            $this->model = $data['model'] ?? null;
            $this->color = $data['color'] ?? null;
            $this->driverfirstname = $data['driverfirstname'] ?? null;
            $this->driverlastname = $data['driverlastname'] ?? null;
        }
    }
}
