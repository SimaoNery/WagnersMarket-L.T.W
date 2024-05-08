<?php
declare(strict_types=1);

class User
{
    public int $userId;
    public string $name;
    public string $username;
    public string $profilePic;
    public string $email;
    public bool $admin;


    public function __construct(int $userId, string $name, string $username, string $profilePic, string $email, bool $admin)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->username = $username;
        $this->profilePic = $profilePic;
        $this->email = $email;
        $this->admin = $admin;
    }

    static function getUser(PDO $db, int $id): User
    {
        $stmt = $db->prepare('SELECT * FROM USER WHERE UserId = ?');

        $stmt->execute(array($id));
        $user = $stmt->fetch();

        $admin = $user['Admin'] == 1 ? true : false;

        return new User(
            $user['UserId'],
            $user['Name'],
            $user['Username'],
            $user['ProfilePic'],
            $user['Email'],
            $admin
        );
    }

    static function getUserByUsername(PDO $db, string $username): ?User
    {
        $stmt = $db->prepare('SELECT * FROM USER WHERE Username = ?');

        $stmt->execute(array($username));

        if ($user = $stmt->fetch()) {
            $admin = $user['Admin'] == 1 ? true : false;

            return new User(
                $user['UserId'],
                $user['Name'],
                $user['Username'],
                $user['ProfilePic'],
                $user['Email'],
                $admin
            );
        }
        return null;
    }

    static function getUserByEmail(PDO $db, string $email): ?User
    {
        $stmt = $db->prepare('SELECT UserId, Name, Username, ProfilePic, Password, Email, Admin FROM USER WHERE Email = ?');

        $stmt->execute(array($email));

        if ($user = $stmt->fetch()) {
            $admin = $user['Admin'] == 1 ? true : false;

            return new User(
                $user['UserId'],
                $user['Name'],
                $user['Username'],
                $user['ProfilePic'],
                $user['Email'],
                $admin
            );
        }
        return null;
    }

    static function getMaxId(PDO $db): int
    {
        $stmt = $db->prepare('SELECT MAX(UserId) FROM USER');
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }


    static function getUserWithPassword(PDO $db, string $email, string $password): ?User
    {
        $stmt = $db->prepare('
            SELECT * 
            FROM USER 
            WHERE email = ?
          ');

        $stmt->execute(array(strtolower($email)));

        $user = $stmt->fetch();

        if ($user != null) {
            if (password_verify($password, $user['Password'])) {
                $admin = $user['Admin'] == 1 ? true : false;

                return new User(
                    $user['UserId'],
                    $user['Name'],
                    $user['Username'],
                    $user['ProfilePic'],
                    $user['Email'],
                    $admin
                );
            }
        }
        return null;
    }

    static function addUser(PDO $db, int $id, string $name, string $username, string $email, string $password): bool
    {
        $options = ['cost' => 12];
        $stmt = $db->prepare('INSERT INTO USER (UserId, Name, Username, ProfilePic, Password, Email) VALUES (?, ?, ?, ?, ?, ?)');

        $stmt->execute(array($id, $name, $username, '../../public/profile_pictures/profile_pic1.png', password_hash($password, PASSWORD_DEFAULT, $options), strtolower($email)));

        return $stmt->rowCount() == 1;
    }

    static function getImgPath(PDO $db, int $id): string
    {
        $stmt = $db->prepare('SELECT ProfilePic FROM USER WHERE UserId = ?');
        $stmt->execute(array($id));

        return $stmt->fetchColumn();
    }

}

?>

