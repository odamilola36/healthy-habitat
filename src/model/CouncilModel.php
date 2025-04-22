<?php

class CouncilModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createCouncil($userId, $name)
    {
        $stmt = $this->db->prepare("INSERT INTO local_council (user_id, name) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $name);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getCouncilByUserId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM local_council WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getCouncilById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM local_council WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
