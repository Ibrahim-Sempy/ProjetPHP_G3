<?php
require_once '../models/Election.php';

class ElectionController {
    private $electionModel;

    public function __construct() {
        $this->electionModel = new Election();
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => Security::cleanInput($_POST['title']),
                'description' => Security::cleanInput($_POST['description']),
                'start_date' => Security::cleanInput($_POST['start_date']),
                'end_date' => Security::cleanInput($_POST['end_date'])
            ];

            if ($this->electionModel->create($data)) {
                $_SESSION['success'] = "Élection créée avec succès";
                header('Location: index.php?page=elections');
                exit;
            }
        }
        require_once '../views/elections/create.php';
    }

    public function vote() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['voter_id'])) {
            $voterId = $_SESSION['voter_id'];
            $candidateId = Security::cleanInput($_POST['candidate_id']);
            $electionId = Security::cleanInput($_POST['election_id']);
            $pollingStationId = Security::cleanInput($_POST['polling_station_id']);

            if ($this->electionModel->vote($voterId, $candidateId, $electionId, $pollingStationId)) {
                $_SESSION['success'] = "Vote enregistré avec succès";
                header('Location: index.php?page=elections');
                exit;
            }
        }
        $_SESSION['error'] = "Erreur lors du vote";
        header('Location: index.php?page=elections');
    }

    public function results($electionId) {
        $results = $this->electionModel->getResults($electionId);
        require_once '../views/elections/results.php';
    }
}