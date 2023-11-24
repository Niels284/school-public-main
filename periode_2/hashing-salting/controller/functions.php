<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', 1);

function is_valid_username($username)
{
    global $usernameError;
    if (preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        return htmlspecialchars($username);
    } else {
        $usernameError = [
            'error' => "Gebruikersnaam mag alleen letters en cijfers bevatten!"
        ];
    }
}

function is_valid_password($password)
{
    global $passwordError;
    // Minstens 8 tekens lang, met minstens één hoofdletter, één kleine letter en één cijfer
    if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
        return htmlspecialchars($password);
    } else {
        $passwordError = [
            'error' => "Wachtwoord moet minstens 8 tekens lang zijn, met minstens één hoofdletter, één kleine letter en één cijfer!"
        ];
    }
}
