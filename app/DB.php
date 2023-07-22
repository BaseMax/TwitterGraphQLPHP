<?php

namespace App;

use App\Models\Tweet;
use App\Models\User;
use PDO;

class DB
{

    public static function getUserByUsername(string $username, PDO $db): array|null
    {
        $stmt = $db->prepare(
            "SELECT * FROM users WHERE username = ?"
        );
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?? null;
    }

    public static function getTweetById(string $id, PDO $db): array|null
    {
        $stmt = $db->prepare(
            "SELECT * FROM tweets WHERE id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getUserById(string $id, PDO $db): array|null
    {
        $stmt = $db->prepare(
            "SELECT * FROM users WHERE id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getTimeLine(string $id, PDO $db): array|null
    {
        $stmt = $db->prepare(
            "SELECT * FROM tweets WHERE author = ?"
        );
        $stmt->execute([$id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createUser(array $data, PDO $db): User|null
    {
        $id = uniqid();
        $stmt = $db->prepare(
            "INSERT INTO users (id, name, username) VALUES (?, ?, ?)"
        );
        $stmt->execute([
            $id,
            $data["name"],
            $data["username"]
        ]);

        $user = self::getUserById($id, $db);

        return User::createUser($id, $user["username"], $user["name"]);
    }

    public static function createTweet(array $data, PDO $db): Tweet|null
    {
        $id = uniqid();
        $stmt = $db->prepare(
            "INSERT INTO tweets (id, text, author) VALUES (?, ?, ?)"
        );
        $stmt->execute([
            $id,
            $data["text"],
            $data["userId"]
        ]);

        $tweet = self::getTweetById($id, $db);
        $user = self::getUserById($tweet["author"], $db);
        return Tweet::createTweet($id, $tweet["text"], User::createUser($user["id"], $user["username"], $user["name"]));
    }

    public static function deleteTweet(string $id, PDO $db): bool
    {
        $stmt = $db->prepare(
            "DELETE FROM tweets WHERE id = ?"
        );
        $stmt->execute([$id]);
        return true;
    }
}
