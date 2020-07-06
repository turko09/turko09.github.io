<?php
namespace TeamAlpha\Web;

class admin
{
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $mobile;
    public $active;
    public $photo;
    public $datecreated;
    public $datemodified;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->firstname = $data['firstname'] ?? null;
            $this->lastname = $data['lastname'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->mobile = $data['mobile'] ?? null;
            $this->active = (int) $data['active'] ?? 0;
            $this->photo = $data['photo'] ?? null;
            $this->datecreated = $data['datecreated'] ?? null;
            $this->datemodified = $data['datemodified'] ?? null;
        }
    }

}
