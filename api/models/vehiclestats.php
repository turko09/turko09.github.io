<?php
namespace TeamAlpha\Web;

class VehicleStats
{
    public $total;
    public $totalonduty;
    public $totalavailable;
    public $totalontrip;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->total = (int) $data['total'] ?? 0;
            $this->totalonduty = (int) $data['totalonduty'] ?? 0;
            $this->totalavailable = (int) $data['totalavailable'] ?? 0;
            $this->totalontrip = (int) $data['totalontrip'] ?? 0;
        }
    }
}
