<?php

class Validator {
    /**
     * Valide un Numéro d'Identification National (NIN)
     * Format attendu : 2 lettres suivies de 8 chiffres
     */
    public static function validateNIN($nin) {
        return preg_match('/^[A-Z]{2}\d{8}$/', $nin);
    }

    /**
     * Valide une adresse email
     */
    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validateLength($str, $min, $max) {
        $length = strlen($str);
        return $length >= $min && $length <= $max;
    }

    public static function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)));
    }

    /**
     * Valide un mot de passe
     * Au moins 8 caractères
     * Au moins 1 lettre majuscule
     * Au moins 1 chiffre
     */
    public static function validatePassword($password) {
        return strlen($password) >= 8 && 
               preg_match('/[A-Z]/', $password) && 
               preg_match('/[0-9]/', $password);
    }

    /**
     * Valide un numéro de carte d'électeur
     * Format attendu : EL suivi de 10 chiffres
     */
    public static function validateVoterCard($card) {
        return preg_match('/^EL\d{10}$/', $card);
    }

    /**
     * Vérifie si la date est valide et si la personne a plus de 18 ans
     */
    public static function validateBirthDate($birthDate) {
        $date = DateTime::createFromFormat('Y-m-d', $birthDate);
        if (!$date || $date->format('Y-m-d') !== $birthDate) {
            return false;
        }
        $age = (new DateTime())->diff($date)->y;
        return $age >= 18;
    }

    /**
     * Valide un numéro de téléphone guinéen
     * Format : +224 suivi de 9 chiffres
     */
    public static function validatePhone($phone) {
        return preg_match('/^\+224[0-9]{9}$/', $phone);
    }
}