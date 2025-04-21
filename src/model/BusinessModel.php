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
}
