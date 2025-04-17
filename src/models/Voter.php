<?php
class Voter {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function register($data) {
        $sql = "INSERT INTO voters (nin, first_name, last_name, birth_date, address, 
                phone, email, password, voter_card_number) 
                VALUES (:nin, :first_name, :last_name, :birth_date, :address, 
                :phone, :email, :password, :voter_card_number)";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nin', $data['nin']);
        $stmt->bindValue(':first_name', $data['first_name']);
        $stmt->bindValue(':last_name', $data['last_name']);
        $stmt->bindValue(':birth_date', $data['birth_date']);
        $stmt->bindValue(':address', $data['address']);
        $stmt->bindValue(':phone', $data['phone']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':password', Security::hashPassword($data['password']));
        $stmt->bindValue(':voter_card_number', $data['voter_card_number']);
        
        return $stmt->execute();
    }

    public function login($email, $password) {
        $sql = "SELECT * FROM voters WHERE email = :email AND is_active = true";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        
        $voter = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($voter && Security::verifyPassword($password, $voter['password'])) {
            return $voter;
        }
        return false;
    }

    public function verifyVoter($nin, $voter_card) {
        $sql = "SELECT * FROM voters WHERE nin = :nin AND voter_card = :voter_card AND is_active = 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':nin' => $nin,
                ':voter_card' => $voter_card
            ]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error verifying voter: ' . $e->getMessage());
            return false;
        }
    }

    public function recordVote($voter_id, $candidate_id) {
        try {
            $this->db->beginTransaction();

            // Vérifier si l'électeur n'a pas déjà voté
            $checkSql = "SELECT voted FROM voters WHERE id = :voter_id AND voted = 0";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([':voter_id' => $voter_id]);
            
            if (!$checkStmt->fetch()) {
                $this->db->rollBack();
                return false;
            }

            // Enregistrer le vote
            $voteSql = "INSERT INTO votes (voter_id, candidate_id) VALUES (:voter_id, :candidate_id)";
            $voteStmt = $this->db->prepare($voteSql);
            $voteStmt->execute([
                ':voter_id' => $voter_id,
                ':candidate_id' => $candidate_id
            ]);

            // Marquer l'électeur comme ayant voté
            $updateSql = "UPDATE voters SET voted = 1, vote_timestamp = CURRENT_TIMESTAMP WHERE id = :voter_id";
            $updateStmt = $this->db->prepare($updateSql);
            $updateStmt->execute([':voter_id' => $voter_id]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log('Error recording vote: ' . $e->getMessage());
            return false;
        }
    }

    public function hasVoted($voter_id) {
        $sql = "SELECT voted FROM voters WHERE id = :voter_id AND is_active = 1";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':voter_id' => $voter_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? (bool)$result['voted'] : false;
        } catch (PDOException $e) {
            error_log('Error checking voter status in ' . __FILE__ . ' line ' . __LINE__ . ': ' . $e->getMessage());
            return false;
        }
    }

    public function getVoteResults() {
        $sql = "SELECT 
                c.id,
                c.first_name,
                c.last_name,
                c.party_name,
                COUNT(v.id) as vote_count,
                (COUNT(v.id) * 100.0 / (SELECT COUNT(*) FROM votes)) as percentage
                FROM " . DB_PREFIX . "candidates c
                LEFT JOIN " . DB_PREFIX . "votes v ON c.id = v.candidate_id
                LEFT JOIN " . DB_PREFIX . "voters vt ON v.voter_id = vt.id
                WHERE c.is_active = 1
                AND (vt.id IS NULL OR vt.is_active = 1)
                GROUP BY c.id, c.first_name, c.last_name, c.party_name
                ORDER BY vote_count DESC, c.last_name ASC, c.first_name ASC";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error getting vote results in ' . __FILE__ . ' line ' . __LINE__ . ': ' . $e->getMessage());
            return [
                'error' => true,
                'message' => 'Une erreur est survenue lors de la récupération des résultats.',
                'details' => $e->getMessage()
            ];
        }
    }

    public function getTotalVoters() {
        try {
            $sql = "SELECT COUNT(*) as total FROM voters WHERE is_active = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch()['total'];
        } catch (PDOException $e) {
            error_log('Error getting total voters count: ' . $e->getMessage());
            return 0;
        }
    }
}