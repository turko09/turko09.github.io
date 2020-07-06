<?php
namespace TeamAlpha\Web;

class AdminListItem
{
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $mobile;
    public $active;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->firstname = $data['firstname'] ?? null;
            $this->lastname = $data['lastname'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->mobile = $data['mobile'] ?? null;
            $this->active = (int) $data['active'] ?? 0;
        }
    }
}
