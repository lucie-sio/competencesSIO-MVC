<?php

require('model/db.php');
require('model/auth.php');

function homepage() 
{
    $erreur = null;
   
    try 
    {
        if(isConnected()) {
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
    } catch(Exception $e) {
        $erreur = $e->getMessage();
    } 
    require('view/homepageView.php');
}

function profile() 
{
    $erreur = null;
    $valide = null;
    try 
    {
        forcedConnection();
        $user = getUser($_SESSION['id_etud']);
        $projects = getProjects($_SESSION['id_etud']);
        if (password_verify('sio', $user['MDP_ETUD'])) {
            header('Location: index.php?action=firstConnection');
            exit();
        } 

        if (!empty($_POST)) {
            if($_POST["type"] == "form1") { // CHANGEMENT/AJOUT DU PORTFOLIO)
                if (isset($_POST['supprimer'])) {
                    addPortfolio($user['IDENTIFIANT_ETUD'], 'NULL');
                    $user['PORTFOLIO_ETUD'] = NULL;
                    $valide = "<b>Portfolio</b> : Adresse du portfolio supprimée."; 

                } else if (!empty($_POST['portfolio'])) {
                    addPortfolio($user['IDENTIFIANT_ETUD'], $_POST['portfolio']);
                    $user['PORTFOLIO_ETUD'] = $_POST['portfolio'];
                    $valide = "<b>Portfolio</b> : Adresse du portfolio mise à jour.";  

                } else {
                    throw new Exception('<b>Portfolio</b> : Veuillez renseigner l\' URL de votre portfolio.');
                }

            } else if($_POST["type"] == "form2") { // CHANGEMENT DU MDP
                if (!empty($_POST['newMdp']) && !empty($_POST['confMdp'])) { // deux champs remplis
                    if(strlen($_POST['newMdp']) > 7) { // longueur suffisante
                        if ($_POST['newMdp'] === $_POST['confMdp']) { // mdps correspondent 
                            sendPassword($user['EMAIL_ETUD'], $_POST['newMdp']);
                            $valide = "Mot de passe correctement changé.";    

                        } else {
                            throw new Exception('<b>Changement de mot de passe</b> : Les mots de passe ne correspondent pas.');
                        } 
                    } else {
                        throw new Exception('<b>Changement de mot de passe</b> : Longueur de mot de passe insuffisante, 8 caractères minimum.');
                    }      
                } else {
                    throw new Exception('<b>Changement de mot de passe</b> : Veuillez remplir tous les champs.');
                }

            } else if($_POST["type"] == "form3") { // AJOUT D'UN PROJET
                if (!empty($_POST['nameProject']) && !empty($_POST['descriptionProject'])) {
                    if (strlen($_POST['nameProject']) < 100  && strlen($_POST['descriptionProject']) < 3000) {
                        $idProject = addProject($user['IDENTIFIANT_ETUD'], htmlentities($_POST['nameProject']), htmlentities($_POST['descriptionProject']));
                        header('Location: index.php?action=project&id='.$idProject);
                        exit();

                    } else {
                        throw new Exception('<b>Ajout du projet</b> : Veuillez respecter la longueur des champs.');
                    }
                } else {
                    throw new Exception('<b>Ajout du projet</b> : Veuillez remplir tous les champs.');
                }
            }
        }
    } catch(Exception $e) {
        $erreur = $e->getMessage();
    }
    require('view/profileView.php');
}

function project()
{
    $erreur = null;
    $valide = null;
    $bloc = '';
    $ensemble = '';

    if (isset($_GET['id'])){
        try 
        {
            forcedConnection();
            $project = getProject($_GET['id']);
            if ($project['IDENTIFIANT_ETUD'] !== $_SESSION['id_etud']){
                error('Vous n\'êtes pas autorisés à consulter le projet d\'ID #'.$_GET['id'].'. Veuillez accéder à vos projets depuis votre page de profil.');
                exit();
            }

            $projectIndicateurs = getProjectSkill('ITEM_INDICATEUR', 'INDICATEUR', $_GET['id']);
            $projectSavoirs = getProjectSkill('SAVOIR', 'MOBILISER', $_GET['id']);
            
            $indicateurs = getSkills('ITEM_INDICATEUR');
            $savoirs = getSkills('SAVOIR');           

            if (isset($_POST['indicateur'])){ // Ajout indicateur au projet
                addProjectSkill('INDICATEUR', $_POST['indicateur'], $_GET['id']);
                header('Location: index.php?action=project&id='.$_GET['id']);
                exit();
                
            } elseif (isset($_POST['savoir'])){ // Ajout savoir au projet
                addProjectSkill('MOBILISER', $_POST['savoir'], $_GET['id']);
                header('Location: index.php?action=project&id='.$_GET['id']);
                exit();
            } elseif (isset($_POST['supprimer'])){ // Suppression d'un indicateur ou savoir
                if($_POST['type'] == 'indicateur') {
                    deleteProjectSKill('INDICATEUR', $_POST['supprimer'], $_GET['id']);
                    header('Location: index.php?action=project&id='.$_GET['id']);
                    exit();
                } elseif ($_POST['type'] == 'savoir'){
                    deleteProjectSKill('MOBILISER', $_POST['supprimer'], $_GET['id']);
                    header('Location: index.php?action=project&id='.$_GET['id']);
                    exit();
                }
            } elseif (isset($_POST['modifier'])){ // Modification du projet
                if($_POST['nameProject'] != ''){
                    addProjectTitle(htmlentities($_POST['nameProject']), $_GET['id']);
                    $project['LIBEL_PROJET'] = htmlentities($_POST['nameProject']);
                }
                if($_POST['descriptionProject'] != $project['DESCRIPTION_PROJET']){
                    addProjectDescription(htmlentities($_POST['descriptionProject']), $_GET['id']);
                    $project['DESCRIPTION_PROJET'] = htmlentities($_POST['descriptionProject']);
                }
            } elseif (isset($_POST['suppProjet'])){ // Suppression du projet
                deleteProject($_GET['id']);
                header('Location: index.php?action=profile');
                die();
            }

        } catch(Exception $e) {
            if (isset($e->errorInfo[1])) {
                if($e->errorInfo[1] == 1062) {
                    $erreur = 'Cet item a déjà été ajouté à votre projet.';
                }
            } else {
                $erreur = $e->getMessage();
            }
        }
    } else {
        homepage();
        exit();
    }
    require('view/projectView.php');
    
}

function skills()
{
    $erreur = '';
    $bloc = '';
    $ensemble = '';
    try 
    {
        forcedConnection();
        $competences = getSkills('ITEM_COMPETENCE');
        $indicateurs = getSkills('ITEM_INDICATEUR');
        $savoirs = getSkills('SAVOIR'); 

    } catch (Exception $e) {
        $erreur = $e->getMessage();
    }
    
    require('view/skillsView.php');
}

function summary()
{
    $erreur = '';
    try
    {
        forcedConnection();
    } catch (Exception $e) {
        $erreur = $e->getMessage();
    }
    
    require('view/summaryView.php');
}

function resetPassword()
{
    $erreur = null;
    $valide = null;
    $email = null;

    try 
    {
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
                                sendPassword($email, $_POST['password']);
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

    try 
    {
        forcedConnection();
        $user = getUser($_SESSION['id_etud']);
        if (!password_verify('sio', $user['MDP_ETUD'])) {
            header('Location: index.php?action=profile');
            exit();
        }
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
    unset($_SESSION['option']);
    header('Location: index.php?action=homepage');
    die();
}

function error($msg)
{
    require('view/errorView.php');   
}