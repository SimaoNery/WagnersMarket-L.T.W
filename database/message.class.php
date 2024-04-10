<?php
  declare(strict_types = 1);

  class Condition {
    public int $messageId;
    public int $authorId;
    public int $receiverId;
    public string $content;
    public DateTime $timestamp;


    public function __construct(int $messageId, int $authorId, int $receiverId, string $content, DateTime $timestamp)
    {
        $this->messageId = $messageId;
        $this->authorId = $authorId;
        $this->receiverId = $receiverId;
        $this->content = $content;
        $this->timestamp = $timestamp;
    }
  }
?>