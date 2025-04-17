<?php

require_once __DIR__ . '/../utils/Database.php';

class Voter {
    private $db;
    private $lastError;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function register($data) {
        $sql = "INSERT INTO voters (nin, first_name, last_name, birth_date, adresse, phone, email, password, voter_card_number) 
                VALUES (:nin, :first_name, :last_name, :birth_date, :adresse, :phone, :email, :password, :voter_card_number)";
        
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($data);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function verifyVoter($nin, $voter_card) {
        $sql = "SELECT * FROM voters WHERE nin = :nin AND voter_card_number = :voter_card";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['nin' => $nin, 'voter_card' => $voter_card]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function recordVote($voter_id, $candidate_id) {
        try {
            $this->db->beginTransaction();
            
            // Marquer l'électeur comme ayant voté
            $sql1 = "UPDATE voters SET voted = true WHERE id = :voter_id";
            $stmt1 = $this->db->prepare($sql1);
            $stmt1->execute(['voter_id' => $voter_id]);
            
            // Enregistrer le vote
            $sql2 = "INSERT INTO votes (voter_id, candidate_id) VALUES (:voter_id, :candidate_id)";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->execute([
                'voter_id' => $voter_id,
                'candidate_id' => $candidate_id
            ]);
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function create($data) {
        $sql = "INSERT INTO voters (
            nin, 
            first_name, 
            last_name, 
            email, 
            mot_de_passe, 
            phone,
            birth_date,
            adresse,
            voter_card_number
        ) VALUES (
            :nin, 
            :first_name, 
            :last_name, 
            :email, 
            :mot_de_passe, 
            :phone,
            :birth_date,
            :adresse,
            :voter_card_number
        )";
        
        try {
            $stmt = $this->db->prepare($sql);
            $success = $stmt->execute([
                'nin' => $data['nin'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'mot_de_passe' => password_hash($data['mot_de_passe'], PASSWORD_DEFAULT),
                'phone' => $data['phone'],
                'birth_date' => isset($data['birth_date']) ? $data['birth_date'] : null,
                'adresse' => isset($data['adresse']) ? $data['adresse'] : null,
                'voter_card_number' => isset($data['voter_card_number']) ? $data['voter_card_number'] : null
            ]);
            
            if (!$success) {
                $this->lastError = $stmt->errorInfo();
                error_log('SQL Error: ' . print_r($this->lastError, true));
            }
            return $success;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log('Database Error: ' . $this->lastError);
            return false;
        }
    }

    public function getLastError() {
        return $this->lastError;
    }

    /**
     * Find a voter by their NIN
     */
    public function findByNIN($nin) {
        $sql = "SELECT * FROM voters WHERE nin = :nin";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['nin' => $nin]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log('Database Error: ' . $this->lastError);
            return false;
        }
    }

    /**
     * Find a voter by their email
     */
    public function findByEmail($email) {
        $sql = "SELECT * FROM voters WHERE email = :email";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log('Database Error: ' . $this->lastError);
            return false;
        }
    }

    public function login($nin, $password) {
        $sql = "SELECT id, nin, first_name, last_name, password, is_admin FROM voters WHERE nin = :nin";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['nin' => $nin]);
        $voter = $stmt->fetch();

        if ($voter && password_verify($password, $voter['password'])) {
            $_SESSION['voter_id'] = $voter['id'];
            $_SESSION['is_admin'] = $voter['is_admin'];
            return true;
        }
        return false;
    }

    public function getTotalVoters() {
        try {
            $sql = "SELECT COUNT(*) as total FROM voters WHERE is_active = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$result['total'];
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            error_log('Database Error: ' . $this->lastError);
            return 0;
        }
    }
}