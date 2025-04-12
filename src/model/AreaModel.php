<?php

class Area {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createArea($councilId, $name) {
        $stmt = $this->db->prepare("INSERT INTO areas (council_id, name) VALUES (?, ?)");
        $stmt->bind_param("is", $councilId, $name);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
