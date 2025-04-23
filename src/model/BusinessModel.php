<?php

class BusinessModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createBusiness($userId, $businessName, $regNumber)
    {
        echo "Creating business with userId: $userId, businessName: $businessName, regNumber: $regNumber\n";
        $stmt = $this->db->prepare("INSERT INTO businesses (user_id, business_name, registration_number) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $businessName, $regNumber);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getBusinessByUserId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM businesses WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getBusinessById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM businesses WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getBusinessAndUsersByIds($ids)
    {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));

        $stmt = $this->db->prepare("SELECT * FROM businesses JOIN users ON businesses.user_id = users.id WHERE businesses.id IN ($placeholders)");
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
