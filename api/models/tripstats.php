<?php
namespace TeamAlpha\Web;

class TripStats
{
    public $total;
    public $totalrequested;
    public $totalassigned;
    public $totalrejected;
    public $totalongoing;
    public $totalcompleted;
    public $totalcancelled;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->total = (int) $data['total'] ?? 0;
            $this->totalrequested = (int) $data['totalrequested'] ?? 0;
            $this->totalassigned = (int) $data['totalassigned'] ?? 0;
            $this->totalrejected = (int) $data['totalrejected'] ?? 0;
            $this->totalongoing = (int) $data['totalongoing'] ?? 0;
            $this->totalcompleted = (int) $data['totalcompleted'] ?? 0;
            $this->totalcancelled = (int) $data['totalcancelled'] ?? 0;
        }
    }
}
