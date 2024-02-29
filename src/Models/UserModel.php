<?php

namespace Models;

use Core\AbstractModel;

class UserModel extends AbstractModel
{
    function getUserByEmail(string $email, string $password)
    {
        $stmt = self::getPdo()->prepare("SELECT * from user WHERE email = :email LIMIT 1");
        $stmt->bindParam(":email", $email);
        if ($stmt->execute()) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return false;
    }

    function getUserById(int $userId)
    {
        $stmt = self::getPdo()->prepare("SELECT * from user WHERE id = :id LIMIT 1");
        $stmt->bindParam(":id", $userId);
        if ($stmt->execute()) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return false;
    }

    function getAllCustomers()
    {
        $stmt = self::getPdo()->prepare("SELECT * from user ");
        if ($stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return false;
    }

    function deleteCustomer(int $id)
    {
        $stmt = self::getPdo()->prepare("DELETE from user WHERE ID = :id");
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function findUserByVerificationCode($code) {
        $stmt = self::getPdo()->prepare("SELECT id FROM user WHERE verification_code = :code LIMIT 1");
        $stmt->bindParam(':code', $code, \PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    
        return $user ? $user['id'] : null;
    }
    
    
    function editCustomer($name, $password, $email, $currentEmail, $is_admin)
    {
        $stmt = self::getPdo()->prepare("UPDATE user SET name = :name, email = :email, password = :password, is_admin = :is_admin WHERE email = :currentEmail");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":currentEmail", $currentEmail);
        $stmt->bindParam(":is_admin", $is_admin);


        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    function userExists($name, $email) {
        $stmt = self::getPdo()->prepare("SELECT 1 FROM user WHERE name = :name OR email = :email");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    

// En UserModel.php
// En UserModel.php

public function createUser($name, $email, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = self::getPdo()->prepare("INSERT INTO user (name, email, password, is_admin) VALUES (:name, :email, :password, 0);");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashedPassword);

    echo "Antes de ejecutar la consulta SQL de inserción.<br>";

    if ($stmt->execute()) {
        echo "Consulta SQL de inserción ejecutada correctamente.<br>";
        return self::getPdo()->lastInsertId(); // Retorna el ID del usuario recién creado
    } else {
        echo "Error al ejecutar la consulta SQL de inserción.<br>";
        return false;
    }
}



function getUsersPaginated($limit, $offset) {
    $stmt = self::getPdo()->prepare("SELECT * FROM user LIMIT :limit OFFSET :offset");
    $stmt->bindParam(":limit", $limit, \PDO::PARAM_INT);
    $stmt->bindParam(":offset", $offset, \PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

function getTotalUsers() {
    $stmt = self::getPdo()->prepare("SELECT COUNT(*) FROM user");
    $stmt->execute();
    return $stmt->fetchColumn();
}
public function saveVerificationCode($userId, $code) {
    $stmt = self::getPdo()->prepare("UPDATE user SET verification_code = :code, code_generated_at = NOW() WHERE id = :userId");
    $stmt->bindParam(":code", $code, \PDO::PARAM_STR);
    $stmt->bindParam(":userId", $userId, \PDO::PARAM_INT);
    return $stmt->execute();
}

function verifyCode($userId, $code) {
    $stmt = self::getPdo()->prepare("SELECT 1 FROM user WHERE id = :userId AND verification_code = :code AND code_generated_at >= (NOW() - INTERVAL 1 HOUR)");
    $stmt->bindParam(":userId", $userId, \PDO::PARAM_INT);
    $stmt->bindParam(":code", $code, \PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchColumn() == 1;
}
function markUserAsVerified($userId) {
    $stmt = self::getPdo()->prepare("UPDATE user SET is_verified = 1 WHERE id = :userId");
    $stmt->bindParam(":userId", $userId, \PDO::PARAM_INT);
    return $stmt->execute();
}




}
