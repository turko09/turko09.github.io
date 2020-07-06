<?php
namespace TeamAlpha\Web;

class DriverDocumentListItem
{
    public $id;
    public $driverid;
    public $description;
    public $type;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->driverid = (int) $data['driverid'] ?? 0;
            $this->description = $data['description'] ?? null;
            $this->type = $data['type'] ?? null;
        }
    }
}
