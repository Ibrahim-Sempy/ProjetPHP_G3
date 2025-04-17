<?php
class Candidate {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll() {
        $sql = "SELECT * FROM candidates ORDER BY last_name, first_name";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting all candidates: ' . $e->getMessage());
            return [];
        }
    }

    public function getAllActive() {
        $sql = "SELECT * FROM candidates WHERE is_active = true ORDER BY last_name, first_name";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting active candidates: ' . $e->getMessage());
            return [];
        }
    }

    public function create($data) {
        $sql = "INSERT INTO candidates (first_name, last_name, party_name, biography, photo_url, is_active) 
                VALUES (:first_name, :last_name, :party_name, :biography, :photo_url, :is_active)";
        
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':first_name' => $data['first_name'],
                ':last_name' => $data['last_name'],
                ':party_name' => $data['party_name'],
                ':biography' => $data['biography'],
                ':photo_url' => $data['photo_url'],
                ':is_active' => $data['is_active']
            ]);
        } catch (PDOException $e) {
            error_log('Error creating candidate: ' . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
        $sql = "UPDATE candidates 
                SET first_name = :first_name,
                    last_name = :last_name,
                    party_name = :party_name,
                    biography = :biography,
                    photo_url = COALESCE(:photo_url, photo_url)
                WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($sql);
            $params = [
                ':id' => $id,
                ':first_name' => $data['first_name'],
                ':last_name' => $data['last_name'],
                ':party_name' => $data['party_name'],
                ':biography' => $data['biography'],
                ':photo_url' => $data['photo_url']
            ];
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log('Error updating candidate: ' . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM candidates WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log('Error deleting candidate: ' . $e->getMessage());
            return false;
        }
    }

    public function getById($id) {
        $sql = "SELECT * FROM candidates WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting candidate by ID: ' . $e->getMessage());
            return false;
        }
    }

    public function toggleStatus($id) {
        $sql = "UPDATE candidates SET is_active = NOT is_active WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log('Error toggling candidate status: ' . $e->getMessage());
            return false;
        }
    }
}