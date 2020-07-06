<?php
namespace TeamAlpha\Web;

class PassengerStats
{
    public $total;
    public $totalactive;
    public $totalblocked;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->total = (int) $data['total'] ?? 0;
            $this->totalactive = (int) $data['totalactive'] ?? 0;
            $this->totalblocked = (int) $data['totalblocked'] ?? 0;
        }
    }
}
