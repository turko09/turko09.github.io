<?php
namespace TeamAlpha\Web;

class AdminStats
{
    public $totaladmin;
    public $totalactive;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->totaladmin = (int) $data['totaladmin'] ?? 0;
            $this->totalactive = (int) $data['totalactive'] ?? 0;
        }
    }
}
