<?php
class Validator {
    public static function validateNIN($nin) {
        // Format NIN Guinéen (à adapter selon le format réel)
        return preg_match('/^[A-Z0-9]{10}$/', $nin);
    }
    
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    public static function validatePassword($password) {
        // Au moins 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre
        return strlen($password) >= 8 
            && preg_match('/[A-Z]/', $password)
            && preg_match('/[a-z]/', $password)
            && preg_match('/[0-9]/', $password);
    }
    
    public static function validateDate($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
}