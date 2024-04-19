<?php
  declare(strict_types = 1);

  class User {
    public int $userId;
    public string $name;
    public string $username;
    public string $profilePic;
    public string $password;
    public string $email;
    public bool $admin;


    public function __construct(int $userId, string $name, string $username, string $profilePic, string $password, string $email, bool $admin)
    {
      $this->userId = $userId;
      $this->name = $name;
      $this->username = $username;
      $this->profilePic = $profilePic;
      $this->password = $password;
      $this->email = $email;
      $this->admin = $admin;
    }

    static function getUser(PDO $db, int $id) : User {
        $stmt = $db->prepare('SELECT UserId, Name, Username, ProfilePic, Password, Email, Admin FROM USER WHERE UserId = ?');

        $stmt->execute(array($id));
        $user = $stmt->fetch();

        $admin = $user['Admin'] == 1 ? true : false;

        return new User(
            $user['UserId'],
            $user['Name'],
            $user['Username'],
            $user['ProfilePic'],
            $user['Password'],
            $user['Email'],
            $admin
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
        $admin = $user['Admin'] == 1 ? true : false;
        return new User(
            $user['UserId'],
            $user['Name'],
            $user['Username'],
            $user['ProfilePic'],
            $user['Password'],
            $user['Email'],
            $admin
        );
    } else return null;

}

}

?>

