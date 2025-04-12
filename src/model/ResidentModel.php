<?php

class Resident {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createResident($userId, $areaId) {
        $stmt = $this->db->prepare("INSERT INTO residents (user_id, area_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $areaId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
