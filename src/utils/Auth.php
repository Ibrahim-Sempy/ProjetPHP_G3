<?php
class Auth {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function checkAdminAuth() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=admin_login');
            exit;
        }
    }
    
    public function checkVoterAuth() {
        if (!isset($_SESSION['voter_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
    }
    
    public function hasVoted($voterId, $electionId) {
        $sql = "SELECT COUNT(*) as count FROM votes 
                WHERE voter_id = :voter_id AND election_id = :election_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':voter_id', $voterId);
        $stmt->bindValue(':election_id', $electionId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
    }
}