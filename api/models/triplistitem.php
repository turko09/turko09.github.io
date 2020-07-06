<?php
namespace TeamAlpha\Web;

class TripListItem
{
    public $id;
    public $vehicleid;
    public $passengerid;
    public $sourcelat;
    public $sourcelong;
    public $destinationlat;
    public $destinationlong;
    public $stage;
    public $amount;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->vehicleid = $data['vehicleid'] === null ? null : (int) $data['vehicleid'];
            $this->passengerid = (int) $data['passengerid'] ?? 0;
            $this->sourcelat = (double) $data['sourcelat'] ?? 0;
            $this->sourcelong = (double) $data['sourcelong'] ?? 0;
            $this->destinationlat = (double) $data['destinationlat'] ?? 0;
            $this->destinationlong = (double) $data['destinationlong'] ?? 0;
            $this->stage = $data['stage'] ?? null;
            $this->amount = $data['amount'] === null ? null : (double) $data['amount'];
        }
    }
}
