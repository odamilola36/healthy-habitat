<?php

class AreaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createArea($councilId, $name, $county, $country)
    {
        $stmt = $this->db->prepare("INSERT INTO areas (council_id, name, county, country) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $councilId, $name, $county, $country);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function getAllAreas()
    {
        $sql = "SELECT * FROM areas";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAreasByCouncilId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM areas WHERE council_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAreaByNameCounty($name, $county)
    {
        $stmt = $this->db->prepare("SELECT * FROM areas WHERE name = ? AND county = ?");
        $stmt->bind_param("ss", $name, $county);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
}
