<?php
  declare(strict_types = 1);

  class User
  {
      public int $userId;
      public string $name;
      public string $username;
      public string $email;
      public bool $admin;


      public function __construct(int $userId, string $name, string $username, string $email, bool $admin)
      {
          $this->userId = $userId;
          $this->name = $name;
          $this->username = $username;
          $this->email = $email;
          $this->admin = $admin;
      }

      static function getUser(PDO $db, int $userId): User
      {
          $stmt = $db->prepare('SELECT UserId, Name, Username, Email, Admin 
        FROM USER 
        WHERE UserId = ?'
          );

          $stmt->execute(array($userId));
          $user = $stmt->fetch();


          return new User(
              $user['UserId'],
              $user['Name'],
              $user['Username'],
              $user['Email'],
              $user['Admin']
          );
      }

      static function getUserWithPassword(PDO $db, string $email, string $password): ?User
      {
          $stmt = $db->prepare('
        SELECT UserId, Name, Username, Email, Admin 
        FROM USER 
        WHERE lower(email) = ? AND password = ?
      ');

          $stmt->execute(array(strtolower($email), sha1($password)));

          if ($user = $stmt->fetch()) {
              return new User(
                  $user['UserId'],
                  $user['Name'],
                  $user['Username'],
                  $user['Email'],
                  $user['Admin']
              );
          } else return null;

      }

  }
?>