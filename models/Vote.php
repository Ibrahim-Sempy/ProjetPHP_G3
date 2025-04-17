<?php

class Vote {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function recordVote($voter_id, $candidate_id) {
        // Vérifier si l'électeur a déjà voté
        $sql = "SELECT id FROM votes WHERE voter_id = :voter_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['voter_id' => $voter_id]);
        
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Vous avez déjà voté.'];
        }

        // Enregistrer le vote
        try {
            $sql = "INSERT INTO votes (voter_id, candidate_id) VALUES (:voter_id, :candidate_id)";
            $stmt = $this->db->prepare($sql);
            $success = $stmt->execute([
                'voter_id' => $voter_id,
                'candidate_id' => $candidate_id
            ]);

            if ($success) {
                // Mettre à jour le statut de l'électeur
                $sql = "UPDATE voters SET voted = 1, vote_timestamp = NOW() WHERE id = :voter_id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute(['voter_id' => $voter_id]);

                return ['success' => true, 'message' => 'Vote enregistré avec succès.'];
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return ['success' => false, 'message' => 'Une erreur est survenue lors du vote.'];
        }
    }

    public function getResults() {
        $sql = "SELECT 
                c.id,
                c.first_name,
                c.last_name,
                c.party_name,
                COUNT(v.id) as vote_count,
                (COUNT(v.id) * 100.0 / (SELECT COUNT(*) FROM votes)) as percentage
                FROM candidates c
                LEFT JOIN votes v ON c.id = v.candidate_id
                GROUP BY c.id
                ORDER BY vote_count DESC";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getTotalVotes() {
        try {
            $sql = "SELECT COUNT(*) as total FROM votes";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            error_log('Error getting total votes: ' . $e->getMessage());
            return 0;
        }
    }
}