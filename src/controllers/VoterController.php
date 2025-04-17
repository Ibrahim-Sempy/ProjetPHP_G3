<?php
require_once __DIR__ . '/../../models/Voter.php';
require_once __DIR__ . '/../../models/Candidate.php';
require_once __DIR__ . '/../../utils/Auth.php';
require_once __DIR__ . '/../../utils/Validator.php';

class VoterController {
    private $voterModel;
    private $candidateModel;
    private $auth;

    public function __construct() {
        $this->voterModel = new Voter();
        $this->candidateModel = new Candidate();
        $this->auth = new Auth();
    }

    public function register() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification que tous les champs requis sont présents
            $requiredFields = ['nin', 'first_name', 'last_name', 'email', 'password', 'phone'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $errors[] = "Le champ " . str_replace('_', ' ', $field) . " est requis";
                }
            }

            // Validation si tous les champs sont présents
            if (empty($errors)) {
                if (!Validator::validateNIN($_POST['nin'])) {
                    $errors[] = "NIN invalide (format attendu : 2 lettres majuscules suivies de 8 chiffres)";
                }
                if (!Validator::validateEmail($_POST['email'])) {
                    $errors[] = "Adresse email invalide";
                }
                if (!Validator::validatePassword($_POST['password'])) {
                    $errors[] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre";
                }
                if (!Validator::validatePhone($_POST['phone'])) {
                    $errors[] = "Numéro de téléphone invalide (format attendu : +224 suivi de 9 chiffres)";
                }
                
                // Vérifier si le NIN existe déjà
                if ($this->voterModel->findByNIN($_POST['nin'])) {
                    $errors[] = "Ce NIN est déjà enregistré";
                }

                // Vérifier si l'email existe déjà
                if ($this->voterModel->findByEmail($_POST['email'])) {
                    $errors[] = "Cette adresse email est déjà utilisée";
                }
                
                if (empty($errors)) {
                    $result = $this->voterModel->create([
                        'nin' => Security::cleanInput($_POST['nin']),
                        'first_name' => Security::cleanInput($_POST['first_name']),
                        'last_name' => Security::cleanInput($_POST['last_name']),
                        'email' => Security::cleanInput($_POST['email']),
                        'mot_de_passe' => $_POST['mot_de_passe'],
                        'phone' => Security::cleanInput($_POST['phone'])
                    ]);

                    if ($result) {
                        $_SESSION['success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
                        header('Location: index.php?page=login');
                        exit;
                    } else {
                        $errors[] = "Erreur lors de l'inscription: " . $this->voterModel->getLastError();
                    }
                }
            }
        }
        
        // Afficher le formulaire avec les erreurs s'il y en a
        require_once __DIR__ . '/../views/auth/register.php';
    }

    public function login() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nin = $_POST['nin'] ?? '';
            $mot_de_passe = $_POST['mot_de_passe'] ?? '';
            
            if (empty($nin) || empty($mot_de_passe)) {
                $errors[] = "Tous les champs sont requis";
            } else {
                $voter = $this->voterModel->findByNIN($nin);
                
                if ($voter && password_verify($mot_de_passe, $voter['mot_de_passe'])) {
                    $_SESSION['voter_id'] = $voter['id'];
                    $_SESSION['is_admin'] = $voter['is_admin'] ?? false;
                    
                    header('Location: index.php');
                    exit;
                } else {
                    $errors[] = "NIN ou mot de passe incorrect";
                }
            }
        }
        
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function vote() {
        if (isset($_SESSION['voter_id'])) {
            header('Location: index.php?page=vote-confirmation');
            exit;
        }

        $candidates = $this->candidateModel->getAllActive();
        require_once dirname(__DIR__) . '/views/vote/form.php';
    }

    public function submitVote() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=candidates');
            exit;
        }

        $nin = $_POST['nin'] ?? '';
        $voter_card = $_POST['voter_card'] ?? '';
        $candidate_id = $_POST['candidate_id'] ?? '';

        if (empty($nin) || empty($voter_card) || empty($candidate_id)) {
            $_SESSION['error'] = "Tous les champs sont obligatoires";
            header('Location: index.php?page=candidates');
            exit;
        }

        // Vérifier l'électeur
        $voter = $this->voterModel->verifyVoter($nin, $voter_card);
        
        if (!$voter) {
            $_SESSION['error'] = "Les numéros d'identification fournis sont incorrects";
            header('Location: index.php?page=candidates');
            exit;
        }

        if ($voter['voted']) {
            $_SESSION['error'] = "Vous avez déjà voté";
            header('Location: index.php?page=candidates');
            exit;
        }

        // Enregistrer le vote
        if ($this->voterModel->recordVote($voter['id'], $candidate_id)) {
            $_SESSION['success'] = "Votre vote a été enregistré avec succès !";
            header('Location: index.php?page=vote-confirmation');
        } else {
            $_SESSION['error'] = "Une erreur est survenue lors de l'enregistrement du vote";
            header('Location: index.php?page=candidates');
        }
        exit;
    }

    public function logout() {
        // Détruire toutes les variables de session
        $_SESSION = array();

        // Détruire la session
        session_destroy();

        // Rediriger vers la page d'accueil
        header('Location: index.php');
        exit;
    }

    public function isAdmin() {
        return isset($_SESSION['voter_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1;
    }

    private function checkAdminAccess() {
        if (!$this->isAdmin()) {
            $_SESSION['error'] = "Accès non autorisé";
            header('Location: index.php');
            exit;
        }
    }
}