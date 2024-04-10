<?php
  declare(strict_types = 1);

  class User {
    public int $userId;
    public string $name;
    public string $username;
    public string $password;
    public string $email;
    public bool $admin;


    public function __construct(int $userId, string $name, string $username, string $password, string $email, bool $admin)
    {
      $this->userId = $userId;
      $this->name = $name;
      $this->username = $username;
      $this->password = $password;
      $this->email = $email;
      $this->admin = $admin;
    }

    static function getUser(PDO $db, int $userId) : User {
        $stmt = $db->prepare('SELECT UserId, Name, Username, Password, Email, Admin 
        FROM USER 
        WHERE UserId = ?'
        );


        $stmt->execute(array($userId));
        $user = $stmt->fetch();
        
        

        return new User(
            $user['UserId'],
            $user['Name'],
            $user['Username'],
            $user['Password'],
            $user['Email'],
            $user['Admin']
        );
    }
  }

?>