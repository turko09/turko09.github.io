<?php
namespace TeamAlpha\Web;

class FareStats
{
    public $totalmatrices;
    public $avgbasefare;
    public $lowestbasefare;
    public $hightestbasefare;
    public $avgfareperkm;
    public $lowestfareperkm;
    public $hightestfareperkm;
    public $avgfareperminute;
    public $lowestfareperminute;
    public $hightestfareperminute;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->totalmatrices = (int) $data['totalmatrices'] ?? 0;
            $this->avgbasefare = (int) $data['avgbasefare'] ?? 0;
            $this->lowestbasefare = (int) $data['lowestbasefare'] ?? 0;
            $this->hightestbasefare = (int) $data['hightestbasefare'] ?? 0;
            $this->avgfareperkm = (int) $data['avgfareperkm'] ?? 0;
            $this->lowestfareperkm = (int) $data['lowestfareperkm'] ?? 0;
            $this->hightestfareperkm = (int) $data['hightestfareperkm'] ?? 0;
            $this->avgfareperminute = (int) $data['avgfareperminute'] ?? 0;
            $this->lowestfareperminute = (int) $data['lowestfareperminute'] ?? 0;
            $this->hightestfareperminute = (int) $data['hightestfareperminute'] ?? 0;
        }
    }
}
