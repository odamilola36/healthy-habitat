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

    public function createResidentInterest($userId, $interestId)
    {
        $resident = $this->getResidentByUserId($userId);
        $cat_id = $this->getCategoryById($interestId);
        if ($cat_id && $resident) {
            $stmt = $this->db->prepare("INSERT INTO residents_interest (resident_id, prod_cat_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $resident['id'], $cat_id['id']);
            $stmt->execute();
            return $stmt->affected_rows > 0;
        }
        return false;
    }

    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM product_category where id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

}
