<?php
class Controller {
    protected function view($name, $data = []) {
        extract($data);
        $viewPath = __DIR__ . "/../views/{$name}.php";
        if (!file_exists($viewPath)) {
            throw new Exception("View {$name} not found");
        }
        require_once $viewPath;
    }

    protected function redirect($url) {
        header("Location: " . BASE_URL . $url);
        exit();
    }
}