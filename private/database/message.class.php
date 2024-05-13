<?php
declare(strict_types=1);

class Message
{
    public int $messageId;
    public int $authorId;
    public int $receiverId;
    public string $content;
    public string $timestamp;


    public function __construct(int $messageId, int $authorId, int $receiverId, string $content, string $timestamp)
    {
        $this->messageId = $messageId;
        $this->authorId = $authorId;
        $this->receiverId = $receiverId;
        $this->content = $content;
        $this->timestamp = $timestamp;
    }

    public static function getLastMessages(PDO $db, int $userId, int $limit, int $offset) : array
    {
        $stmt = $db->prepare('
                SELECT * FROM(SELECT * FROM (SELECT * FROM MESSAGE WHERE AuthorId = ? OR ReceiverId = ? ORDER BY TIMESTAMP DESC)
                GROUP BY MIN(AuthorId, ReceiverId),MAX(AuthorId,ReceiverId) LIMIT ? OFFSET ?) ORDER BY TIMESTAMP DESC
            ');
        $stmt->execute(array($userId, $userId, $limit, $offset));

        $messages = array();

        while ($message = $stmt->fetch()) {
            $messages[] = new Message(
                $message['MessageId'],
                $message['AuthorId'],
                $message['ReceiverId'],
                $message['Content'],
                $message['Timestamp']
            );
        }
        return $messages;
    }

    public static function getConversation(PDO $db, int $userId, int $contact, int $limit, int $offset) : array
    {
        $stmt = $db->prepare('
                SELECT MessageId, AuthorId, ReceiverId, Content, Timestamp
                FROM MESSAGE 
                WHERE (AuthorId = ? AND ReceiverId = ?)
                OR (ReceiverId = ? AND AuthorId = ?)
                ORDER BY Timestamp DESC
                LIMIT ? OFFSET ?
            ');

        $stmt->execute(array($userId,$contact, $userId, $contact, $limit, $offset));

        $messages = array();

        while ($message = $stmt->fetch()) {
            $messages[] = new Message(
                $message['MessageId'],
                $message['AuthorId'],
                $message['ReceiverId'],
                $message['Content'],
                $message['Timestamp']
            );
        }
        return $messages;
    }

    static function addMessage(PDO $db, int $userId, int $otherUserId, string $message)
    {
        $stmt = $db->prepare('INSERT INTO MESSAGE (AuthorId, ReceiverId, Content) VALUES (?,?,?)');
        $stmt->execute(array($userId, $otherUserId, $message));

        if ($stmt->rowCount() == 1) {
            // Get the timestamp of the added message
            $lastInsertId = $db->lastInsertId();
            $timestampStmt = $db->prepare('SELECT Timestamp FROM MESSAGE WHERE MessageId = ?');
            $timestampStmt->execute(array($lastInsertId));
            $timestamp = $timestampStmt->fetchColumn();
            return $timestamp;
        } else {
            return false; // Message not added
        }
    }

}

?>