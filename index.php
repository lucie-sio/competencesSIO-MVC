<?php 

require('controller/frontend.php');

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
            case 'project':
                project();
                break;
            case 'skills':
                skills();
                break;
            case 'summary':
                summary();
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

