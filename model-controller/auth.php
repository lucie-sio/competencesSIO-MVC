<?php 

/**
 * @return bool statut de connexion
 */
function isConnected(): bool {
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION['id_etud']);
}

/**
 * Redirige vers la page d'accueil si non connecté
 * @return void
 */
function forcedConnection(): void {
    if(!isConnected()) {
        header('Location: index.php?action=homepage');
        die();
    }
}

/**
 * Token de réinitialisation du mdp
 * @return string
 */
function generateToken(): string {
    $letters = 'azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN'; 
    $token = '';
    for ($i = 0; $i < 40; $i++){
        $token = $token . $letters[rand(0,strlen($letters) - 1)];
    }
    return $token;
}
