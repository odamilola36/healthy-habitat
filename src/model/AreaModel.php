<?php

class AreaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createArea($councilId, $name)
    {
        $stmt = $this->db->prepare("INSERT INTO areas (council_id, name) VALUES (?, ?)");
        $stmt->bind_param("is", $councilId, $name);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getAllAreas()
    {
        $sql = "SELECT * FROM areas";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
