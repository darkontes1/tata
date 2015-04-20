<?php

$logon = FALSE;
//Supprime la variable de session error
unset($_SESSION['error']);
unset($_SESSION['msg']);
unset($_SESSION['nom']);
unset($_SESSION['prenom']);
//session_destroy();

if(filter_has_var(INPUT_POST, 'logon')) {
    // Traitement du login clique sur le submit logon
    $filterPost = array(
        'login' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => array(
                FILTER_FLAG_ENCODE_LOW, 
                FILTER_FLAG_ENCODE_HIGH
                )
            ),
        'motdepasse' => array(
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags' => FILTER_FLAG_ENCODE_HIGH
            )
        );
    
    $tabPost = filter_input_array(INPUT_POST, $filterPost);
    
    //var_dump($tabPost);
    
    $objUser = new classUser();
    
    $objUser->setLogin($tabPost['login']);
    $objUser->setPassword($tabPost['motdepasse']);
    
    $logon = $objUser->checkUser();
    
    die();
    
    if(is_numeric($logon)) {
            $_SESSION['logged_in'] = TRUE;
            $_SESSION['logged'] = time();
            $_SESSION['ID'] = $logon;
            header('Location: index.php');
    } else {
        $_SESSION['error'] = 'Problème d\'identifiant et/ou mot de passe.';
        header('Location: index.php?page=login');
    }
    
    exit();
    
} elseif(filter_has_var(INPUT_POST, 'create')) {
    // Traitement du login clique sur le submit create
    $filterPost = array(
        'nom' => array( 
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => array(
                FILTER_FLAG_ENCODE_LOW, 
                FILTER_FLAG_ENCODE_HIGH
                )
            ),
        'prenom' => array(
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => array(
                FILTER_FLAG_ENCODE_LOW, 
                FILTER_FLAG_ENCODE_HIGH
                )
            ),
        'motdepasse' => array(
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags' => FILTER_FLAG_ENCODE_HIGH
            ),
        'verifmotdepasse' => array(
            'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
            'flags' => FILTER_FLAG_ENCODE_HIGH
            )
        );
    
    
   $tabPost = filter_input_array(INPUT_POST, $filterPost);
   
    $_SESSION['nom'] = $tabPost['nom'];
    $_SESSION['prenom'] = $tabPost['prenom'];
    
    if($tabPost['motdepasse'] != $tabPost['verifmotdepasse']) {
         $_SESSION['error'] = 'Les mots de passe sont différents.';
        header('Location: login.php');
        exit();
    }
    
    $objUser = new classUser();
    $objUser->setNom($tabPost['nom']);
    $objUser->setPrenom($tabPost['prenom']);
    $objUser->setPassword($tabPost['motdepasse']);
    $resCompte = $objUser->createUser();
    
    die();
    
    if(is_array($resCompte) && $resCompte['msg'] == TRUE) {
        $_SESSION['msg'] = 'Votre compte '.$resCompte['login'].' est correctement créé.';
        header('Location: login.php');
    } else {
        $_SESSION['error'] = $resCompte;
        header('Location: login.php');
    }
    
    exit();
    
} else {
    header('Location: login.php');
    exit();
}



