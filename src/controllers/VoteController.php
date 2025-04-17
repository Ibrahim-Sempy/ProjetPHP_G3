<?php

require_once __DIR__ . '/../../models/Vote.php';
require_once __DIR__ . '/../../models/Candidate.php';
require_once __DIR__ . '/../../models/Voter.php';

class VoteController {
    private $voteModel;
    private $candidateModel;
    private $voterModel;

    public function __construct() {
        $this->voteModel = new Vote();
        $this->candidateModel = new Candidate();
        $this->voterModel = new Voter();
    }

    public function index() {
        if (!isset($_SESSION['voter_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $candidates = $this->candidateModel->getAll();
        require_once __DIR__ . '/../views/vote/index.php';
    }

    public function cast() {
        if (!isset($_POST['nin']) || !isset($_POST['mot_de_passe']) || !isset($_POST['candidate_id'])) {
            $_SESSION['error'] = "Toutes les informations sont requises";
            header('Location: index.php?page=vote');
            exit;
        }

        // Vérifier les credentials
        $voter = $this->voterModel->findByNIN($_POST['nin']);
        
        if (!$voter || !password_verify($_POST['mot_de_passe'], $voter['mot_de_passe'])) {
            $_SESSION['error'] = "NIN ou mot de passe incorrect";
            header('Location: index.php?page=vote');
            exit;
        }

        // Vérifier si l'électeur a déjà voté
        if ($voter['voted']) {
            $_SESSION['error'] = "Vous avez déjà voté";
            header('Location: index.php?page=vote');
            exit;
        }

        // Enregistrer le vote
        $result = $this->voteModel->recordVote($voter['id'], $_POST['candidate_id']);

        if ($result['success']) {
            $_SESSION['success'] = "Votre vote a été enregistré avec succès";
            header('Location: index.php?page=vote-confirmation');
        } else {
            $_SESSION['error'] = $result['message'];
            header('Location: index.php?page=vote');
        }
        exit;
    }

    public function showResults() {
        if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
            header('Location: index.php?page=login');
            exit;
        }

        $results = $this->voteModel->getVoteResults();
        $totalVotes = array_sum(array_column($results, 'vote_count'));
        require_once dirname(__DIR__) . '/views/vote/results.php';
    }
}