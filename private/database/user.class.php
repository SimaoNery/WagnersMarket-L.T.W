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

        $admin = $user['Admin'] == 1;

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

    static function changePassword(PDO $db, int $id, string $newPassword) : bool {
        $options = ['cost' => 12];
        $stmt = $db->prepare('UPDATE USER SET Password = ? WHERE UserId = ?');

        $stmt->execute(array(password_hash($newPassword, PASSWORD_DEFAULT, $options), $id));

        return $stmt->rowCount() == 1;
    }

    static function changeName(PDO $db, int $id, string $name) : bool {
        $stmt = $db->prepare('UPDATE USER SET Name = ? WHERE UserId = ?');

        $stmt->execute(array($name, $id));

        return $stmt->rowCount() == 1;
    }


    static function changeEmail(PDO $db, int $id, string $email) : bool {
        $stmt = $db->prepare('UPDATE USER SET Email = ? WHERE UserId = ?');

        $stmt->execute(array($email, $id));

        return $stmt->rowCount() == 1;
    }

    static function changeProfilePic(PDO $db, int $id, string $profilePic) {
        $stmt = $db->prepare('UPDATE USER SET ProfilePic = ? WHERE UserId = ?');

        $stmt->execute(array('../profile_pictures/' . $profilePic, $id));

        return $stmt->rowCount() == 1;
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

    static function getUserByAnything(PDO $db, string $anything, int $limit, int $offset): array
    {
        $searchString = "%" . $anything . "%";
        $stmt = $db->prepare('SELECT UserId, Name, Username, ProfilePic, Password, Email, Admin FROM USER WHERE UserId LIKE ? OR NAME LIKE ? OR Username LIKE ? OR SUBSTR(Email, 1, INSTR(Email, "@") - 1) LIKE ? LIMIT ? OFFSET ?');

        $stmt->execute(array($searchString, $searchString, $searchString, $searchString, $limit, $offset));

        $users = [];

        while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $admin = $user['Admin'] == 1 ? true : false;
            $users[] = new User(
                $user['UserId'],
                $user['Name'],
                $user['Username'],
                $user['ProfilePic'],
                $user['Email'],
                $admin
            );
        }

        return $users;
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

    static function getUserWithIdAndPassword(PDO $db, int $id, string $password): ?User
    {
        $stmt = $db->prepare('
            SELECT * 
            FROM USER 
            WHERE UserId = ?
          ');

        $stmt->execute(array($id));

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

    static function addUser(PDO $db, string $name, string $username, string $email, string $password): bool
    {
        $options = ['cost' => 12];
        $stmt = $db->prepare('INSERT INTO USER (Name, Username, ProfilePic, Password, Email) VALUES (?, ?, ?, ?, ?)');

        $stmt->execute(array($name, $username, '../profile_pictures/profile_pic1.png', password_hash($password, PASSWORD_DEFAULT, $options), strtolower($email)));

        return $stmt->rowCount() == 1;
    }

    static function getImgPath(PDO $db, int $id): string
    {
        $stmt = $db->prepare('SELECT ProfilePic FROM USER WHERE UserId = ?');
        $stmt->execute(array($id));

        return $stmt->fetchColumn();
    }

    static function deleteUser(PDO $db, int $userId): bool
    {
        $stmt = $db->prepare('DELETE FROM USER WHERE UserId = ?');
        return $stmt->execute(array($userId));
    }

    static function changeAdminStatus(PDO $db, int $userId, bool $admin): bool
    {
        $stmt = $db->prepare('UPDATE USER SET Admin = ? WHERE UserId = ?;');
        return $stmt->execute(array($admin, $userId));
    }

    static function isAdmin(PDO $db, int $userId): bool
    {
        $stmt = $db->prepare('SELECT Admin FROM USER WHERE UserId = ?');
        $stmt->execute(array($userId));

        $admin = $stmt->fetchColumn();
        if($admin != 1) {
            return false;
        }

        return true;
    }

}

?>

