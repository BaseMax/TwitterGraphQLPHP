<?php

namespace App\Models;

class User
{
    private string $id;
    private string $username;
    private string $name;

    public function __construct(string $id, string $username, string $name)
    {
        $this->setId($id)->setName($name)->setUsername($username);
    }

    public static function createUser(string $id, string $username, string $name): static
    {
        return new static($id, $username, $name);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }
}
