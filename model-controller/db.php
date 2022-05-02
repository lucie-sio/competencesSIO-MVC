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

    $query = $pdo->prepare('SELECT IDENTIFIANT_ETUD, EMAIL_ETUD, MDP_ETUD FROM ETUDIANT WHERE EMAIL_ETUD = :email');
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
 * @return PDO
 */
function callPDO()
{
    $user = 'XXXXX';
    $password = 'XXXXX';
    $dsn = 'mysql:host=localhost;dbname=XXXXX;charset=utf8mb4';

    try {
        return new PDO($dsn, $user, $password);
    } catch (PDOException $e){
        throw new Exception('Erreur de connexion à la base de données, veuillez réessayer plus tard.'); 
    }
}
