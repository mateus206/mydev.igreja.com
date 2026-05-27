<?php

require_once __DIR__ . "/../config/Databasesingle.php";

class EmailVerificationDAO
{
    private $conn;

    public function __construct()
    {
        $this->conn = DatabaseSingle::connect();
    }

    /** Cria token (5 min) e retorna token para enviar no email */
    public function createForUser(int $userId, int $ttlSeconds = 300): string
    {
        $token = bin2hex(random_bytes(32));
        $tokenHash = hash('sha256', $token);

        $sql = "
            INSERT INTO email_verifications
            (user_id, token_hash, expires_at, created_at)
            VALUES
            (?, ?, DATE_ADD(NOW(), INTERVAL ? SECOND), NOW())
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId, $tokenHash, $ttlSeconds]);

        return $token;
    }

    /** Se token válido devolve user_id */
    public function validate(string $token): ?int
    {
        $tokenHash = hash('sha256', $token);

        $sql = "
            SELECT user_id
            FROM email_verifications
            WHERE token_hash = ?
            AND expires_at > NOW()
            ORDER BY id DESC
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tokenHash]);

        $userId = $stmt->fetchColumn();

        return $userId ? (int)$userId : null;
    }

    /** Remove token depois de usado */
    public function markUsed(string $token): void
    {
        $tokenHash = hash('sha256', $token);

        $stmt = $this->conn->prepare(
            "DELETE FROM email_verifications WHERE token_hash = ?"
        );

        $stmt->execute([$tokenHash]);
    }
}