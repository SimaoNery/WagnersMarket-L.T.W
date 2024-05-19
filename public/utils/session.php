<?php
class Session
{
    private array $messages;

    public function __construct()
    {
        session_start();
        $this->setToken();
        $this->messages = $_SESSION['messages'] ?? array();
        unset($_SESSION['messages']);
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['id']);
    }

    public function logout(): void
    {
        session_destroy();
    }

    public function getId(): ?int
    {
        return $_SESSION['id'] ?? null;
    }

    public function getName(): ?string
    {
        return $_SESSION['name'] ?? null;
    }

    public function setId(int $id): void
    {
        $_SESSION['id'] = $id;
    }

    public function setName(string $name): void
    {
        $_SESSION['name'] = $name;
    }

    public function addMessage(string $type, string $text): void
    {
        $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }
    public function clearMessages(): void
    {
        $_SESSION['messages'][] = array();
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function setToken(): void
    {
        if (!isset($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
        }
    }

    public function getToken()
    {
        return $_SESSION['csrf'];
    }
}

?>