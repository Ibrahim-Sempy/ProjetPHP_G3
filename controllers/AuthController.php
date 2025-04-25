<?php
class AuthController extends Controller {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }
    
    public function showLogin() {
        $this->view('auth/login');
    }

    public function showRegister() {
        $this->view('auth/register');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            try {
                $stmt = $this->conn->prepare("SELECT id, email, mot_de_passe, role FROM utilisateurs WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['mot_de_passe'])) {
                    // Stockage des informations de session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role'];

                    // Redirection basée sur le rôle
                    switch($user['role']) {
                        case 'admin':
                            header('Location: ' . BASE_URL . '/dashboard/admin');
                            break;
                        case 'electeur':
                            header('Location: ' . BASE_URL . '/dashboard/electeur');
                            break;
                        case 'observateur':
                            header('Location: ' . BASE_URL . '/dashboard/observateur');
                            break;
                        default:
                            header('Location: ' . BASE_URL . '/dashboard');
                    }
                    exit();
                } else {
                    return $this->view('auth/login', ['error' => 'Email ou mot de passe incorrect']);
                }
            } catch(PDOException $e) {
                error_log($e->getMessage());
                return $this->view('auth/login', ['error' => 'Une erreur est survenue']);
            }
        }
        
        return $this->view('auth/login');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
            $date_naissance = filter_input(INPUT_POST, 'date_naissance', FILTER_SANITIZE_STRING);
            $sexe = filter_input(INPUT_POST, 'sexe', FILTER_SANITIZE_STRING);

            // Validation
            $errors = [];
            if (!$nom || strlen($nom) < 3) {
                $errors[] = "Le nom doit contenir au moins 3 caractères";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email invalide";
            }
            if (strlen($password) < 6) {
                $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
            }
            if ($password !== $password_confirm) {
                $errors[] = "Les mots de passe ne correspondent pas";
            }

            if (empty($errors)) {
                try {
                    // Maintenant $this->conn est défini
                    $stmt = $this->conn->prepare("SELECT id FROM utilisateurs WHERE email = ?");
                    $stmt->execute([$email]);
                    if ($stmt->fetch()) {
                        return $this->view('auth/register', ['error' => 'Cet email est déjà utilisé']);
                    }

                    // Insertion de l'utilisateur
                    $stmt = $this->conn->prepare("
                        INSERT INTO utilisateurs (nom, email, mot_de_passe, role, date_naissance, sexe)
                        VALUES (?, ?, ?, ?, ?, ?)
                    ");
                    
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt->execute([
                        $nom,
                        $email,
                        $hashedPassword,
                        $role,
                        $date_naissance,
                        $sexe
                    ]);

                    $this->redirect('/auth/login');
                } catch (PDOException $e) {
                    error_log($e->getMessage());
                    return $this->view('auth/register', ['error' => 'Une erreur est survenue']);
                }
            } else {
                return $this->view('auth/register', ['error' => implode('<br>', $errors)]);
            }
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/');
    }
}