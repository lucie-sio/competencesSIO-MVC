<?php 

require('model-controller/frontend.php');

try {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) 
        {
            case 'homepage':
                homepage();
                break;
            case 'error':
                error('Ceci est le test d\'un message d\'erreur.');
                break;
            case 'profile':
                profile();
                break;
            case 'logout':
                logout();
                break;
            case 'resetPassword':
                resetPassword();
                break;
            case 'firstConnection':
                firstConnection();
                break;
            default:
                homepage();
        }
    } else {
        homepage();
    }
} catch(Exception $e) {
   error($e->getMessage());
}

