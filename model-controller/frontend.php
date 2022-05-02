<?php

require('model-controller/db.php');
require('model-controller/auth.php');

function homepage() 
{
    $erreur = null;
   
    try {
        if(isConnected()){
            header('Location: index.php?action=profile');
            die();
        } else {
            if (!empty($_POST)) {               
                if (!empty($_POST['email']) && !empty($_POST['password'])) {      
                    $data = login($_POST['email'], $_POST['password']);    
                    header('Location: index.php?action='.$data);
                    exit();
                } else {
                    throw new Exception('Veuillez remplir tous les champs.');
                }             
            }   
        } 
    } catch(Exception $e){
        $erreur = $e->getMessage();
    } 
    require('view/homepageView.php');
}

function profile() 
{
    forcedConnection();
    $user = getUser($_SESSION['id_etud']);
    if (password_verify('sio', $user['MDP_ETUD'])) {
        header('Location: index.php?action=firstConnection');
        exit();
    } 

    require('view/profileView.php');
}

function resetPassword()
{
    $erreur = null;
    $valide = null;
    $email = null;

    try {
        if(isConnected()){
            header('Location: index.php?action=profile');
            die();
        } else {
            if (!empty($_GET)) {
                if (!empty($_GET['token'])) {
                    $data = getEmail($_GET['token']);
                    if (!empty($data)){
                        $email = $data['EMAIL_ETUD'];
                    }
                }
            }

            if ($email != null){
                if (!empty($_POST)) { 
                    if (!empty($_POST['password']) && !empty($_POST['passwordConfirm'])) { // deux champs remplis
                        if(strlen($_POST['password']) > 7) { // longueur suffisante
                            if ($_POST['password'] === $_POST['passwordConfirm']) { // mdps correspondent 
                                $data = sendPassword($email, $_POST['password']);
                        
                                $valide = "Mot de passe correctement changé.";
                                $email = "";
                                
                            } else {
                                throw new Exception('Les mots de passe ne correspondent pas.');
                            } 
                        } else {
                            throw new Exception('Longueur de mot de passe insuffisante, 8 caractères minimum.');
                        }      
                    } else {
                        throw new Exception('Veuillez remplir tous les champs.');
                    }
                }
            } else {
                if (!empty($_POST)){
                    if (!empty($_POST['email'])) {
                        $token = generateToken();
                        $data = sendToken($_POST['email'], $token);
            
                        if ($data === 1) {
                            $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . '?action=resetPassword&token=' . $token;
                            $to = $_POST['email'];
                            $subject = 'Compétences BTS SIO | Reinitialisation du mot de passe';
                            $message = "Vous avez demandé la réinitialisation de votre mot de passe. Pour cela, veuillez cliquer sur le lien suivant afin d'enregistrer un nouveau mot de passe.
                                ".$url."
                                \rSi vous n'êtes pas à l'origine de cette demande, ignorez cet email.
                            ";

                            if (@mail($to, $subject, $message)){
                                $valide = "Un email vient d'être envoyé sur votre adresse mail.";
                            } else {
                                throw new Exception("Une erreur est survenue dans l'envoi du mail, veuillez réessayer plus tard.");
                            }                          
                        } else {
                            throw new Exception("Aucun compte n'est associé à cette adresse mail.");
                        }    
                    } else {
                        throw new Exception('Veuillez saisir une adresse mail.');
                    }
                }
            }  
        }
    } catch (Exception $e) {
        $erreur = $e->getMessage();
    }
    require('view/resetPasswordView.php');
}

function firstConnection()
{
    $erreur = null;
    forcedConnection();
    $user = getUser($_SESSION['id_etud']);
    if (!password_verify('sio', $user['MDP_ETUD'])) {
        header('Location: index.php?action=profile');
        exit();
    }
    try {
        if (!empty($_POST)) { 
            if (!empty($_POST['password']) && !empty($_POST['passwordConfirm'])) { // deux champs remplis
                if(strlen($_POST['password']) > 7) { // longueur suffisante
                    if ($_POST['password'] === $_POST['passwordConfirm']) { // mdps correspondent 
                        sendPassword($user['EMAIL_ETUD'], $_POST['password']);
                
                        header('Location: index.php?action=profile');
                        exit();
                        
                    } else {
                        throw new Exception('Les mots de passe ne correspondent pas.');
                    } 
                } else {
                    throw new Exception('Longueur de mot de passe insuffisante, 8 caractères minimum.');
                }      
            } else {
                throw new Exception('Veuillez remplir tous les champs.');
            }
        }
    } catch (Exception $e) {
        $erreur = $e->getMessage();
    }
    require('view/firstConnectionView.php');   
}

function logout()
{
    session_start();
    unset($_SESSION['id_etud']);
    header('Location: index.php?action=homepage');
    die();
}

function error($msg)
{
    require('view/errorView.php');   
}
