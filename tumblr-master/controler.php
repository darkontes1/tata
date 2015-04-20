<?php
    include('../conf/_conf.php');
    /*Verification de la page*/
    
    /*Verification de la session*/
    if(!isset($_SESSION)){
        if(empty($_SESSION)){
            $_SESSION['logged_in'] = FALSE;
        }
    }
    var_dump($_SESSION);
    
    
    
    /*Action par default*/
    if($_SESSION['logged_in'] == TRUE){
        
    }
    if(empty($_GET)){
        include ('../view/default.php');
    }
    

    /*Action demandée*/
    if(isset($_GET['page']) && $_GET['page'] == "login"){
        echo "page login";
        include ('../view/login.php');
    }
    if(isset($_POST))
    /*erreur faite*/
?>