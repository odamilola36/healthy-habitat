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
    public function getCouncilByName($name)
    {
        $sql = "SELECT * FROM local_council where name = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
