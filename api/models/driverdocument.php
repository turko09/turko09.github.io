<?php
namespace TeamAlpha\Web;

class DriverDocument
{
    public $id;
    public $driverid;
    public $description;
    public $type;
    public $document;
    public $datecreated;
    public $datemodified;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->driverid = (int) $data['driverid'] ?? 0;
            $this->description = $data['description'] ?? null;
            $this->type = $data['type'] ?? null;
            $this->document = $data['document'] ?? null;
            $this->datecreated = $data['datecreated'] ?? null;
            $this->datemodified = $data['datemodified'] ?? null;
        }
    }
}
