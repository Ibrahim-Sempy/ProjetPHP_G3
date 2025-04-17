<?php
session_start();
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/utils/Auth.php';
require_once ROOT_PATH . '/src/controllers/VoterController.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Chargement des configurations
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/utils/Database.php';
require_once '../utils/Security.php';

// Définition de la page par défaut
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

error_log('Page requested: ' . $page);

// Routing simple
switch($page) {
    case 'home':
        require_once '../src/views/home.php';
        break;
    case 'login':
        require_once '../src/controllers/VoterController.php';
        $controller = new VoterController();
        $controller->login();
        break;
    case 'register':
        require_once '../src/controllers/VoterController.php';
        $controller = new VoterController();
        $controller->register();
        break;
    case 'candidate/manage':
        require_once '../src/controllers/CandidateController.php';
        $controller = new CandidateController();
        $controller->manage();
        break;
    case 'candidate/edit':
        require_once '../src/controllers/CandidateController.php';
        $controller = new CandidateController();
        $controller->edit();
        break;
    case 'candidate/update':
        require_once '../src/controllers/CandidateController.php';
        $controller = new CandidateController();
        $controller->update();
        break;
    case 'candidates':
        require_once '../src/controllers/CandidateController.php';
        $controller = new CandidateController();
        $controller->index();
        break;
    case 'candidates/create':
        require_once '../src/controllers/CandidateController.php';
        $controller = new CandidateController();
        $controller->create();
        break;
    case 'candidates/edit':
        require_once '../src/controllers/CandidateController.php';
        $controller = new CandidateController();
        $controller->edit($_GET['id']);
        break;
    case 'candidates/delete':
        require_once '../src/controllers/CandidateController.php';
        $controller = new CandidateController();
        $controller->delete($_GET['id']);
        break;
    case 'vote':
        require_once '../src/controllers/VoteController.php';
        $controller = new VoteController();
        $controller->index();
        break;
    case 'vote/cast':
        require_once '../src/controllers/VoteController.php';
        $controller = new VoteController();
        $controller->cast();
        break;
    case 'vote/submit':
        require_once '../src/controllers/VoterController.php';
        $controller = new VoterController();
        $controller->submitVote();
        break;
    case 'vote-confirmation':
        require_once '../src/views/vote/confirmation.php';
        break;
    case 'vote-results':
        require_once '../src/controllers/VoteController.php';
        $controller = new VoteController();
        $controller->showResults();
        break;
    case 'logout':
        require_once '../src/controllers/VoterController.php';
        $controller = new VoterController();
        $controller->logout();
        break;
    case 'admin':
        require_once '../src/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->dashboard();
        break;
    case 'admin/photos':
        require_once '../src/controllers/AdminController.php';
        $controller = new AdminController();
        $controller->managePhotos();
        break;
    default:
        require_once '../src/views/404.php';
        break;
}