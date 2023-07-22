<?php

namespace App;

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
}
