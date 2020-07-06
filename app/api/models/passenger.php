<?php
namespace TeamAlpha\Web;

class Passenger
{
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $address;
    public $mobile;
    public $panicmobile;
    public $active;
    public $verified;
    public $blocked;
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
            $this->address = $data['address'] ?? null;
            $this->mobile = $data['mobile'] ?? null;
            $this->panicmobile = $data['panicmobile'] ?? null;
            $this->active = (int) $data['active'] ?? 0;
            $this->verified = (int) $data['verified'] ?? 0;
            $this->blocked = (int) $data['blocked'] ?? 0;
            $this->photo = $data['photo'] ?? null;
            $this->datecreated = $data['datecreated'] ?? null;
            $this->datemodified = $data['datemodified'] ?? null;
            $this->playerid = $data['playerid'] ?? null;
        }
    }

}
