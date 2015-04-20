<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classUser
 *
 * @author fabrice
 */
class classUser {

    private $idUser;
    private $login;
    private $nom;
    private $prenom;
    private $password;
    private $created_on;
    
    protected $table='users';


    public function __construct() {
        
    }
    
    public function getId() {
        return $this->idUser;
    }

    public function getLogin() {
        return $this->login;
    }
    
    public function getNom() {
        return $this->nom;
    }
    
    public function getPrenom() {
        return $this->prenom;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getCreatedOn() {
        return $this->created_on;
    }
    
    public function setId($idUser) {
        return $this->idUser = $idUser;
    }

    public function setLogin($login) {
        return $this->login = $login;
    }
    
    public function setNom($nom) {
        return $this->nom = $nom;
    }
    
    public function setPrenom($prenom) {
        return $this->prenom = $prenom;
    }
    
    public function setPassword($password) {
        return $this->password = $password;
    }
    
    public function setCreatedOn($createdOn) {
        return $this->created_on = $createdOn;
    }
    
    private function createPassword(){
        $passwordtemp = $this->nom[0] . $this->password . mb_substr($this->nom, -1, 1);

        if(version_compare(PHP_VERSION, '5.5') >= 0) {
            $cryptedPassword = password_hash($passwordtemp, PASSWORD_BCRYPT);
        } else {
            $cryptedPassword = crypt($passwordtemp, PRIVATE_KEY);
        }
        
        echo $cryptedPassword;
        
        return $cryptedPassword;
    }

        private function checkPassword($nomUtilisateur,$pwdBDD){
        $passwordtemp = $nomUtilisateur[0] . $this->password . mb_substr($nomUtilisateur, -1, 1);
        if(version_compare(PHP_VERSION, '5.5') >= 0) {
            return password_verify($this->password, $pwdBDD);
            //return hash_equals($hash, crypt($passwordtemp. PRIVATE_KEY)); // v. >= 5.6
        } else {
            return $hash == crypt($passwordtemp,PRIVATE_KEY) ? TRUE : FALSE;
        }
    }

    public function checkUser() {
        
        $objBDD = new classBDD();
        $user = $objBDD->selectByParam($this->table, array('login' => $this->login),FALSE);
        
        var_dump($user);
        
        if(empty($user)) {
             return NULL;
        }
        
        $checkpwd = $this->checkPassword($user['nom'],$user['password']);
        
        var_dump($checkpwd);
    }

    public function createUser () {
        
        //$classVars = get_class_vars(__CLASS__);
        $classVars = get_object_vars($this);
        unset($classVars['table']);
        $objBDD = new classBDD();
        $objBDD->insertDB($this->table, $classVars);
        
        //var_dump($classVars);
        
    }
    
    public function deleteUser () {
        
    }
    
    public function modifyUser() {
        
    }
    
    public function __destruct() {
        
    }
    
}
