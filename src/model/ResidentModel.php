<?php

class ResidentModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createResident($userId, $firstName, $lastName, $gender, $ageGroup, $area)
    {
        $stmt = $this->db->prepare("INSERT INTO residents (firstName, lastName, gender, age_group, user_id, area_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii", $firstName, $lastName, $gender, $ageGroup, $userId, $area);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getResidentByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM residents WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

}
