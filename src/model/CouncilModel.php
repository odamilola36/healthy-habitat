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
}
