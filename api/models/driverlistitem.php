<?php
namespace TeamAlpha\Web;

class DriverListItem
{
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $mobile;
    public $active;
    public $verified;
    public $blocked;
    public $rating;

    public function __construct(array $data)
    {
        if ($data !== null) {
            $this->id = (int) $data['id'] ?? 0;
            $this->firstname = $data['firstname'] ?? null;
            $this->lastname = $data['lastname'] ?? null;
            $this->email = $data['email'] ?? null;
            $this->mobile = $data['mobile'] ?? null;
            $this->active = (int) $data['active'] ?? 0;
            $this->verified = (int) $data['verified'] ?? 0;
            $this->blocked = (int) $data['blocked'] ?? 0;
            $this->rating = $data['rating'] === null ? null : (double) $data['rating'];
        }
    }
}
