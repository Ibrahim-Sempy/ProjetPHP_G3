<?php
require_once __DIR__ . '/../utils/Database.php';

class Candidate {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        try {
            $sql = "SELECT * FROM candidates WHERE is_active = 1 ORDER BY last_name, first_name";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting candidates: ' . $e->getMessage());
            return [];
        }
    }

    public function create($data) {
        $sql = "INSERT INTO candidates (first_name, last_name, party_name, biography, photo_url, is_active) 
                VALUES (:first_name, :last_name, :party_name, :biography, :photo_url, :is_active)";
        
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    public function getById($id) {
        $sql = "SELECT * FROM candidates WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
        $sql = "UPDATE candidates SET 
                first_name = :first_name,
                last_name = :last_name,
                party_name = :party_name,
                biography = :biography,
                is_active = :is_active";
        
        if (isset($data['photo_url'])) {
            $sql .= ", photo_url = :photo_url";
        }
        
        $sql .= " WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($sql);
            $data['id'] = $id;
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM candidates WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            error_log('Database Error: ' . $e->getMessage());
            return false;
        }
    }
}