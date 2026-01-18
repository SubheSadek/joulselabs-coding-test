<?php

namespace SellNow\Domain;

class User
{
    public function __construct(
        private int $id,
        private string $email,
        private string $passwordHash,
        private string $username,
        private string $fullname
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['email'],
            $data['password'],
            $data['username'],
            $data['full_name']
        );
    }

    public function id(): int
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function fullname(): string
    {
        return $this->fullname;
    }

    public function passwordHash(): string
    {
        return $this->passwordHash;
    }
}
