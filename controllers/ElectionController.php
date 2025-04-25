<?php

require_once '../models/Election.php';

class ElectionController extends Controller {
    private $electionModel;

    public function __construct() {
        $this->electionModel = new Election();
    }

    public function index() {
        $elections = $this->electionModel->getAllElections();
        
        if ($elections === false) {
            return $this->view('elections/liste', [
                'error' => 'Erreur lors de la récupération des élections'
            ]);
        }

        return $this->view('elections/liste', ['elections' => $elections]);
    }

    public function create() {
        return $this->view('elections/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING),
                'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
                'type' => filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING),
                'date_debut' => $_POST['date_debut'],
                'date_fin' => $_POST['date_fin']
            ];

            if ($this->electionModel->createElection($data)) {
                header('Location: ' . BASE_URL . '/elections');
                exit();
            }

            return $this->view('elections/create', [
                'error' => 'Erreur lors de la création de l\'élection',
                'data' => $data
            ]);
        }
    }
}