<?php
require_once "db.php";

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new db();
        session_start();
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user['password']) ) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    public function register($username, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hash);
        $stmt->execute();
        return true;

        mkdir("../uploads/" . $this->db->conn->lastInsertId());

    }

    public function getUserDates()
    {
        $sql = "SELECT * FROM users ORDER BY reg_date";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
    public function getsharechart()
    {
        $sql = "SELECT * FROM shared_files ORDER BY time";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
    public function getAllUsers()
    {
        $sql = 'SELECT * FROM users';
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}
