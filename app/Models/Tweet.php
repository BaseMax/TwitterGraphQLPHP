<?php

namespace App\Models;

class Tweet
{
    private string $id;
    private string $text;
    private User $author;

    public function __construct(string $id, string $text, User $author)
    {
        $this->setId($id)->setText($text)->setAuthor($author);
    }

    public static function createTweet(string $id, string $text, User $author): static
    {
        return new static($id, $text, $author);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;
        return $this;
    }
}
