<?php
namespace TeamAlpha\Web;

class DriverStats
{
    public $totaldriver;
    public $totalactive;
    public $totalblocked;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->totaldriver = (int) $data['totaldriver'] ?? 0;
            $this->totalactive = (int) $data['totalactive'] ?? 0;
            $this->totalblocked = (int) $data['totalblocked'] ?? 0;
        }
    }
}
