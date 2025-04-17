<?php
require_once __DIR__ . '/../../models/Voter.php';
require_once __DIR__ . '/../../models/Candidate.php';
require_once __DIR__ . '/../../models/Vote.php';
require_once __DIR__ . '/../../utils/Database.php';

class AdminController {
    private $voterModel;
    private $candidateModel;
    private $voteModel;

    public function __construct() {
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $_SESSION['error'] = "Accès non autorisé";
            header('Location: index.php');
            exit;
        }
        
        $this->voterModel = new Voter();
        $this->candidateModel = new Candidate();
        $this->voteModel = new Vote();
    }

    public function dashboard() {
        try {
            $totalVoters = $this->voterModel->getTotalVoters();
            $totalVotes = $this->voteModel->getTotalVotes();
            $candidates = $this->candidateModel->getAll();
            
            require_once __DIR__ . '/../views/admin/dashboard.php';
        } catch (Exception $e) {
            error_log('Error in admin dashboard: ' . $e->getMessage());
            $_SESSION['error'] = "Une erreur est survenue lors du chargement du tableau de bord.";
            header('Location: index.php');
            exit;
        }
    }

    public function manageElections() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'start':
                        $this->electionModel->updateStatus($_POST['election_id'], 'active');
                        break;
                    case 'end':
                        $this->electionModel->updateStatus($_POST['election_id'], 'closed');
                        break;
                }
            }
        }
        
        $elections = $this->electionModel->getAllElections();
        require_once '../views/admin/elections.php';
    }

    public function managePhotos() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['photo']) && isset($_POST['candidate_id'])) {
                $photoUrl = $this->handlePhotoUpload($_FILES['photo']);
                if ($photoUrl) {
                    $this->candidateModel->updatePhoto($_POST['candidate_id'], $photoUrl);
                    $_SESSION['success'] = "Photo mise à jour avec succès";
                }
            }
        }

        $candidates = $this->candidateModel->getAll();
        require_once __DIR__ . '/../views/admin/photos.php';
    }

    private function handlePhotoUpload($file) {
        $uploadDir = __DIR__ . '/../../public/uploads/candidates/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file['type'], $allowedTypes)) {
            $_SESSION['error'] = "Type de fichier non autorisé";
            return false;
        }

        $filename = uniqid() . '_' . basename($file['name']);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return 'uploads/candidates/' . $filename;
        }

        $_SESSION['error'] = "Erreur lors de l'upload";
        return false;
    }
}