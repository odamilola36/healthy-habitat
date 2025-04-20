<?php

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findUserByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createUser($email, $password, $role, $telephone, $city, $postcode, $address)
    {
        $stmt = $this->db->prepare("INSERT INTO users (email, password, role, telephone, city, address, postcode) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $email, $password, $role, $telephone, $city, $postcode, $address);
        $stmt->execute();
        return $stmt->insert_id;
    }
}