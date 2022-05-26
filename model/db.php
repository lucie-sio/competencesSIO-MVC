<?php


/**
 * @param  mixed $id
 * @return array Des infos de l'utlisateur
 */
function getUser(string $id)
{
    $pdo = callPDO();

    $query = $pdo->prepare('SELECT * FROM ETUDIANT WHERE IDENTIFIANT_ETUD = :id;');
    $query->execute([
        'id' => $id,
    ]);
    return $query->fetch();
}

/**
 * Démarre une session quand les identifiants sont correctes, puis envoi sur la 
 * page adéquate (profile ou première connexion)
 *
 * @param  mixed $email
 * @param  mixed $password
 * @return string de la page vers laquelle est redirigé l'utilisateur
 */
function login(string $email, string $password)
{
    $pdo = callPDO();

    $query = $pdo->prepare('SELECT IDENTIFIANT_ETUD, OPTION_BTS_ETUD, EMAIL_ETUD, MDP_ETUD FROM ETUDIANT WHERE EMAIL_ETUD = :email');
    $query->execute([
        'email' => $email,
    ]);
    $utilisateur = $query->fetch();

    if (empty($utilisateur)) { // Utilisateur n'existe pas
        throw new Exception('Identifiants incorrects.'); 

    } else {
        if (!password_verify($password, $utilisateur['MDP_ETUD'])) { // Mauvais mdp
            throw new Exception('Identifiants incorrects.'); 

        } else {
            session_start();
            $_SESSION['id_etud'] = $utilisateur['IDENTIFIANT_ETUD'];
            $_SESSION['option'] = $utilisateur['OPTION_BTS_ETUD'];
            if (password_verify('sio', $utilisateur['MDP_ETUD'])) { // Mdp de base
                return 'firstConnection';
            } else {
                return 'profile';
            }
        }
    }  
}

/**
 * Met à jour le mdp, efface le token utilisé pour changer de mdp
 * Utilisé pour réinitialiser le mdp, première connexion, ou changement de l'utilisateur (à venir)
 *
 * @param  mixed $email
 * @param  mixed $password
 * @return void
 */
function sendPassword(string $email, string $password)
{ 
    $newPassword = password_hash($password, PASSWORD_BCRYPT,['cost' => 12]);
    $pdo = callPDO();

    $query = $pdo->prepare('UPDATE ETUDIANT SET MDP_ETUD = :password WHERE ETUDIANT.EMAIL_ETUD = :email;');
    $query->execute([
        'password' => $newPassword,
        'email' => $email,
    ]);

    $query = $pdo->prepare('UPDATE ETUDIANT SET TOKEN = NULL WHERE ETUDIANT.EMAIL_ETUD = :email;');
    $query->execute([
        'email' => $email,
    ]);  
}

/**
 * Token qui sera ajouté à l'URL envoyé par mail, permet de réinitialiser le mdp
 *
 * @param  mixed $email
 * @param  mixed $token
 * @return int nombre de lignes affectés par la requête 
 */
function sendToken(string $email, string $token)
{
    $pdo = callPDO();

    $query = $pdo->prepare('UPDATE ETUDIANT SET TOKEN = :token WHERE ETUDIANT.EMAIL_ETUD = :email;');
    $query->execute([
        'token' => $token,
        'email' => $email,
    ]);
    return $query->rowCount();
}

/**
 * @param  mixed $token
 * @return array contenant l'email associé au token (sert à réinitialiser le mdp)
 */
function getEmail(string $token)
{
    $pdo = callPDO();

    $query = $pdo->query("SELECT EMAIL_ETUD FROM ETUDIANT WHERE TOKEN = '".$token."';");
    return $query->fetch();
}

/**
 * @param  mixed $id
 * @param  mixed $url (ou NULL pour supprimer le portfolio)
 * @return void
 */
function addPortfolio($id, $url)
{
    $pdo = callPDO();

    if($url = 'NULL'){
        $query = $pdo->query('UPDATE ETUDIANT SET PORTFOLIO_ETUD = NULL WHERE IDENTIFIANT_ETUD = '.$id.';');
    } else {
        $query = $pdo->prepare('UPDATE ETUDIANT SET PORTFOLIO_ETUD = :url WHERE IDENTIFIANT_ETUD = :id;');
        $query->execute([
            'url' => $url,
            'id' => $id
        ]);
    }
}

/**
 * @param  mixed $id
 * @return array Contenant les noms et id des projets associés à l'étudiant
 */
function getProjects($id)
{
    $pdo = callPDO();

    $query = $pdo->prepare('
        SELECT PROJET.ID_PROJET, PROJET.LIBEL_PROJET 
        FROM PROJET
        INNER JOIN REALISER ON PROJET.ID_PROJET = REALISER.ID_PROJET
        WHERE REALISER.IDENTIFIANT_ETUD = :id;
    ');
    $query->execute([
        'id' => $id
    ]);

    return $query->fetchAll();
}

/**
 * @param  mixed $id
 * @return array Contenant les infos du projet
 */
function getProject($id)
{
    $pdo = callPDO();

    $query = $pdo->prepare('
        SELECT  REALISER.IDENTIFIANT_ETUD, PROJET.LIBEL_PROJET, PROJET.DESCRIPTION_PROJET, PROJET.IMAGE_PROJET
        FROM PROJET 
        INNER JOIN REALISER ON PROJET.ID_PROJET = REALISER.ID_PROJET
        WHERE PROJET.ID_PROJET = :id;
    ');
    $query->execute([
        'id' => $id
    ]);
    $data = $query->fetch();

    if ($data == false){
        error('Il n\'existe pas de projet à l\'ID #'.$id.'. Veuillez accéder à vos projets depuis votre page de profil.');
        exit();
    } else {
        return $data;
    }
    
}

/**
 * @param  mixed $id
 * @param  string $title
 * @return void
 */
function addProjectTitle($title, $id)
{
    $pdo = callPDO();

    $query = $pdo->prepare('UPDATE PROJET SET LIBEL_PROJET = :title WHERE ID_PROJET = :id;');
    $query->execute([
        'title' => $title,
        'id' => $id
    ]);
}

/**
 * @param  mixed $id
 * @param  string $desc
 * @return void
 */
function addProjectDescription($desc, $id)
{
    $pdo = callPDO();

    $query = $pdo->prepare('UPDATE PROJET SET DESCRIPTION_PROJET = :desc WHERE ID_PROJET = :id;');
    $query->execute([
        'desc' => $desc,
        'id' => $id
    ]);
}

function deleteProject($id)
{
    $pdo = callPDO();

    $pdo->query('DELETE FROM PROJET WHERE ID_PROJET = '.$id.';');
}

/**
 * @param  mixed $id
 * @param  mixed $name
 * @param  mixed $description
 * @return int Retourne le numéro du projet  (auto-increment)
 */
function addProject($id, $name, $description)
{
    $pdo = callPDO();

    $query = $pdo->prepare('
        INSERT INTO PROJET VALUES (DEFAULT, :name, :description, NULL);
        INSERT INTO REALISER VALUES (LAST_INSERT_ID(), :id);
    ');
    $query->execute([
        'name' => $name,
        'description' => $description,
        'id' => $id,
    ]);

    return $pdo->lastInsertId();
}

/**
 * @param  mixed $table : table concernée indicateur ou savoir ou compétence
 * @param  mixed $link : table reliant la compétence au projet
 * @param  mixed $id du projet
 * @return array Contenant toutes les compétences OU savoirs OU indicateurs que l'utilisateur à mis en place
 */
function getProjectSkill($table, $link, $id)
{
    $pdo = callPDO();

    $query = $pdo->prepare('
        SELECT '.$table.'.N_ITEM, '.$table.'.LIBEL_ITEM 
        FROM '.$table.' 
        INNER JOIN '.$link.' ON '.$table.'.N_ITEM = '.$link.'.N_ITEM 
        WHERE '.$link.'.ID_PROJET = :id 
        ORDER BY '.$table.'.N_ITEM;
    ');
    $query->execute([
        'id' => $id
    ]);

    return $query->fetchAll();
}

/**
 * @param  mixed $table
 * @param  mixed $skill
 * @param  mixed $id
 * @return void
 */
function addProjectSkill($table, $skill, $id)
{
    $pdo = callPDO();

    $query = $pdo->prepare('INSERT INTO '.$table.' VALUES (:skill, :id);');
    $query->execute([
        'skill' => $skill,
        'id' => $id
    ]);

    if($query->rowCount() < 1){
        throw new Exception('Erreur lors de l\'ajout au projet, veuillez réessayer ultérieurement.');
    }
}

/**
 * @param  mixed $table
 * @param  mixed $skill
 * @param  mixed $id
 * @return void
 */
function deleteProjectSKill($table, $skill, $id)
{
    $pdo = callPDO();
    $query = $pdo->prepare(
        'DELETE FROM '.$table.' WHERE N_ITEM = :skill AND ID_PROJET = :id;'
    );
    $query->execute([
        'skill' => $skill,
        'id' => $id
    ]);

    if($query->rowCount() < 1){
        throw new Exception('L\'item n\'a pas pu être supprimé, veuillez réessayer ultérieurement.');
    }
}

/**
 * @param  mixed $table
 * @return array Liste de toutes les compétences OU savoirs OU indicateurs
 */
function getSkills($table)
{
    $pdo = callPDO();

    $query = $pdo->query('
        SELECT DISTINCT ENSEMBLE_DE_COMPETENCE.ID_NOM_BLOC, ENSEMBLE_DE_COMPETENCE.ID_ENSEMBLE_COMPETENCE, ENSEMBLE_DE_COMPETENCE.LIBEL_ENSEMBLE_COMPETENCE, '.$table.'.N_ITEM, '.$table.'.LIBEL_ITEM 
        FROM ENSEMBLE_DE_COMPETENCE 
        INNER JOIN '.$table.' 
        ON ENSEMBLE_DE_COMPETENCE.ID_ENSEMBLE_COMPETENCE LIKE CONCAT(\'%\', '.$table.'.ID_ENSEMBLE_COMPETENCE, \'%\');
    ');

    return $query->fetchAll();
}

/**
 * @return PDO
 */
function callPDO()
{
    $user = 'XXXX';
    $password = 'XXXX';
    $dsn = 'mysql:host=localhost;dbname=XXXX;charset=utf8mb4';

    try {
        return new PDO($dsn, $user, $password);
    } catch (PDOException $e){
        if(isset($_SESSION['id_etud'])){
            error('Erreur de connexion à la base de données, veuillez réessayer plus tard.');
            exit();
        } else {
            throw new Exception('Erreur de connexion à la base de données, veuillez réessayer plus tard.');
        }
    }
}
