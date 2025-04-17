<?php
class Election {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function create($data) {
        $sql = "INSERT INTO elections (title, description, start_date, end_date) 
                VALUES (:title, :description, :start_date, :end_date)";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':title', $data['title']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':start_date', $data['start_date']);
        $stmt->bindValue(':end_date', $data['end_date']);
        
        return $stmt->execute();
    }

    public function vote($voterId, $candidateId, $electionId, $pollingStationId) {
        $sql = "INSERT INTO votes (voter_id, candidate_id, election_id, polling_station_id) 
                VALUES (:voter_id, :candidate_id, :election_id, :polling_station_id)";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':voter_id', $voterId);
        $stmt->bindValue(':candidate_id', $candidateId);
        $stmt->bindValue(':election_id', $electionId);
        $stmt->bindValue(':polling_station_id', $pollingStationId);
        
        return $stmt->execute();
    }

    public function getResults($electionId) {
        $sql = "SELECT c.first_name, c.last_name, c.party_name, COUNT(v.id) as vote_count 
                FROM candidates c 
                LEFT JOIN votes v ON c.id = v.candidate_id 
                WHERE v.election_id = :election_id 
                GROUP BY c.id 
                ORDER BY vote_count DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':election_id', $electionId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveElections() {
        $sql = "SELECT * FROM elections WHERE status = 'active'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentVotes() {
        $sql = "SELECT v.voted_at, ps.name as polling_station_name, 
                e.title as election_title, COUNT(*) as vote_count
                FROM votes v
                JOIN polling_stations ps ON v.polling_station_id = ps.id
                JOIN elections e ON v.election_id = e.id
                WHERE DATE(v.voted_at) = CURDATE()
                GROUP BY v.polling_station_id, v.election_id
                ORDER BY v.voted_at DESC
                LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus($electionId, $status) {
        $sql = "UPDATE elections SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $electionId);
        return $stmt->execute();
    }
}