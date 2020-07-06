<?php
namespace TeamAlpha\Web;

class Trip
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
    public $rating;
    public $datecreated;
    public $datemodified;

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
            $this->rating = $data['rating'] === null ? null : (int) $data['rating'];
            $this->datecreated = $data['datecreated'] ?? null;
            $this->datemodified = $data['datemodified'] ?? null;
        }
    }
}
