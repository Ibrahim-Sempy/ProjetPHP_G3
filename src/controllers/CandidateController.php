<?php
require_once __DIR__ . '/../../models/Candidate.php';
require_once __DIR__ . '/../../utils/Auth.php';

class CandidateController {
    private $candidateModel;
    private $auth;

    public function __construct() {
        $this->candidateModel = new Candidate();
        $this->auth = new Auth();
        // Vérifier les droits d'admin
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            $_SESSION['error'] = "Accès non autorisé";
            header('Location: index.php');
            exit;
        }
    }

    public function index() {
        $candidates = $this->candidateModel->getAll();
        require_once __DIR__ . '/../views/candidates/index.php';
    }

    private function handlePhotoUpload($file) {
        $uploadDir = __DIR__ . '/../../public/uploads/candidates/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file['type'], $allowedTypes)) {
            $_SESSION['error'] = "Format de fichier non autorisé";
            return false;
        }

        $filename = uniqid() . '_' . basename($file['name']);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return '/uploads/candidates/' . $filename;
        }

        return false;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Gestion de l'upload de la photo
            $photoUrl = '';
            if (isset($_FILES['photo'])) {
                $photoUrl = $this->handlePhotoUpload($_FILES['photo']);
            }

            $data = [
                'first_name' => Security::cleanInput($_POST['first_name']),
                'last_name' => Security::cleanInput($_POST['last_name']),
                'party_name' => Security::cleanInput($_POST['party_name']),
                'biography' => Security::cleanInput($_POST['biography']),
                'photo_url' => $photoUrl
            ];

            if ($this->candidateModel->register($data)) {
                $_SESSION['success'] = "Candidat enregistré avec succès";
                header('Location: index.php?page=candidates');
                exit;
            }
        }
        require_once '../views/candidates/register.php';
    }

    public function store() {
        if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
            header('Location: index.php?page=candidates');
            exit;
        }

        $errors = [];
        $photo_url = null;

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = dirname(dirname(__DIR__)) . '/public/uploads/candidates/';
            
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png'];

            if (!in_array($file_extension, $allowed_extensions)) {
                $errors[] = "Format de fichier non autorisé. Utilisez JPG, JPEG ou PNG.";
            } else {
                $new_filename = uniqid() . '.' . $file_extension;
                $destination = $upload_dir . $new_filename;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                    // Store relative path in database
                    $photo_url = '/uploads/candidates/' . $new_filename;
                } else {
                    $errors[] = "Erreur lors de l'upload de la photo.";
                }
            }
        }

        if (empty($errors)) {
            $data = [
                'first_name' => htmlspecialchars(trim($_POST['first_name'])),
                'last_name' => htmlspecialchars(trim($_POST['last_name'])),
                'party_name' => htmlspecialchars(trim($_POST['party_name'])),
                'biography' => isset($_POST['biography']) ? htmlspecialchars(trim($_POST['biography'])) : null,
                'photo_url' => $photo_url,
                'is_active' => 1
            ];

            if ($this->candidateModel->create($data)) {
                $_SESSION['success'] = "Le candidat a été ajouté avec succès";
                header('Location: index.php?page=candidate/manage');
                exit;
            }
        }

        $_SESSION['errors'] = $errors;
        header('Location: index.php?page=candidate/create');
        exit;
    }

    public function manage() {
        if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
            header('Location: index.php?page=candidates');
            exit;
        }

        $candidates = $this->candidateModel->getAll();
        
        // Format photo URLs just like in index method
        foreach ($candidates as &$candidate) {
            if (!empty($candidate['photo_url'])) {
                $candidate['photo_url'] = '/projetPHP/election-guinee/public' . $candidate['photo_url'];
            }
        }
        
        require_once dirname(__DIR__) . '/views/candidate/manage.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'party_name' => $_POST['party_name'],
                'biography' => $_POST['biography'],
                'is_active' => 1
            ];

            // Gestion de l'upload de photo
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $photoUrl = $this->handlePhotoUpload($_FILES['photo']);
                if ($photoUrl) {
                    $data['photo_url'] = $photoUrl;
                }
            }

            if ($this->candidateModel->create($data)) {
                $_SESSION['success'] = "Candidat ajouté avec succès";
                header('Location: index.php?page=admin/candidates');
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de l'ajout du candidat";
            }
        }

        require_once __DIR__ . '/../views/candidates/create.php';
    }

    public function edit($id) {
        $candidate = $this->candidateModel->getById($id);
        
        if (!$candidate) {
            $_SESSION['error'] = "Candidat non trouvé";
            header('Location: index.php?page=admin/candidates');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'party_name' => $_POST['party_name'],
                'biography' => $_POST['biography'],
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $photoUrl = $this->handlePhotoUpload($_FILES['photo']);
                if ($photoUrl) {
                    $data['photo_url'] = $photoUrl;
                }
            }

            if ($this->candidateModel->update($id, $data)) {
                $_SESSION['success'] = "Candidat modifié avec succès";
                header('Location: index.php?page=admin/candidates');
                exit;
            } else {
                $_SESSION['error'] = "Erreur lors de la modification";
            }
        }

        require_once __DIR__ . '/../views/candidates/edit.php';
    }

    public function update() {
        if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
            header('Location: index.php?page=candidates');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?page=candidate/manage');
            exit;
        }

        $errors = [];
        $photo_url = null;

        // Handle photo upload if new photo is provided
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = dirname(dirname(__DIR__)) . '/public/uploads/candidates/';
            
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png'];

            if (!in_array($file_extension, $allowed_extensions)) {
                $errors[] = "Format de fichier non autorisé. Utilisez JPG, JPEG ou PNG.";
            } else {
                $new_filename = uniqid() . '.' . $file_extension;
                $destination = $upload_dir . $new_filename;

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                    $photo_url = '/uploads/candidates/' . $new_filename;
                } else {
                    $errors[] = "Erreur lors de l'upload de la photo.";
                }
            }
        }

        if (empty($errors)) {
            $data = [
                'first_name' => htmlspecialchars(trim($_POST['first_name'])),
                'last_name' => htmlspecialchars(trim($_POST['last_name'])),
                'party_name' => htmlspecialchars(trim($_POST['party_name'])),
                'biography' => isset($_POST['biography']) ? htmlspecialchars(trim($_POST['biography'])) : null,
                'photo_url' => $photo_url
            ];

            if ($this->candidateModel->update($id, $data)) {
                $_SESSION['success'] = "Le candidat a été modifié avec succès";
                header('Location: index.php?page=candidate/manage');
                exit;
            }
        }

        $_SESSION['errors'] = $errors;
        header('Location: index.php?page=candidate/edit&id=' . $id);
        exit;
    }

    public function delete($id) {
        if ($this->candidateModel->delete($id)) {
            $_SESSION['success'] = "Candidat supprimé avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression";
        }
        header('Location: index.php?page=admin/candidates');
        exit;
    }
}