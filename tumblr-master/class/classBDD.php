<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classBDD
 *
 * @author fabrice
 */
class classBDD {
    
    protected $database_connection;

    public function __construct() {
        /* Chargement de la configuration */

        try {
            $this->database_connection = new PDO(DSN,USER_BDD,MDP_BDD);
            $this->database_connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this->database_connection->setAttribute( PDO::ATTR_PERSISTENT, true );
        }
        catch(PDOException $e) {

            /*$oError = new clsError();
            $oError->ErrorFile = __FILE__;
            $oError->ErrorFunction = __FUNCTION__;
            $oError->ErrorCode = $e->getCode();
            $oError->ErrorMessage = $e->getMessage();
            $oError->ErrorTrace = $e->getTraceAsString();
            
            $oError->showError();
            die();*/
        }
        return $this->database_connection;
    }
    
    private function cleanTable($table){
        $table_clean = filter_var($table,FILTER_SANITIZE_STRING, array(FILTER_FLAG_STRIP_LOW,FILTER_FLAG_STRIP_HIGH));
        //Cherche s'il y a un espace dans la chaine, et si oui supprime ce qu'il y a après
        
        if(mb_strpos($table_clean, ' ')) {
            $table_clean = substr($table_clean, 0, mb_strpos($table_clean, ' '));
        }
        
        return $table_clean;
    }

    private function cleanParam($tabParam){
        if(!is_array($tabParam)) {
            return 'tabParam doit être un tableau';
        }
        
        $param_clean = filter_var(key($tabParam),FILTER_SANITIZE_STRING, array(FILTER_FLAG_STRIP_LOW,FILTER_FLAG_STRIP_HIGH));
        
        if(mb_strpos($param_clean, ' ')) {
            $param_clean = substr($param_clean, 0, mb_strpos($param_clean, ' '));
        }
        
        return $param_clean;
    }
    
    private function prepareParam($tabParam) {

        $columns = array_keys($tabParam, !NULL);
        $param_clean['values'] = array_values(array_intersect_key($tabParam,array_flip($columns)));
        $param_clean['columns'] = implode(',',$columns);
        $param_clean['param'] = substr(str_repeat('?,',count($columns)),0,-1);

        return $param_clean;
        
    }
    
    public function selectAll($table) {
        
        //Nettoie la variable table des caractères ASCII < 32 et > 127
        $table_clean = filter_var($table,FILTER_SANITIZE_STRING, array(FILTER_FLAG_STRIP_LOW,FILTER_FLAG_STRIP_HIGH));
        
        //Cherche s'il y a un espace dans la chaine, et si oui supprime ce qu'il y a après
        
        if(mb_strpos($table_clean, ' ')) {
            $table_clean = substr($table_clean, 0, mb_strpos($table_clean, ' '));
        }
        
        $reqSelect = 'SELECT * FROM '.$table_clean;
        
        $prepSelect = $this->database_connection->prepare($reqSelect);
        
        $prepSelect->execute();
        
        $resSelect = $prepSelect->fetchAll(PDO::FETCH_ASSOC);
        
        return $resSelect;
        
    }
    
    public function selectByParam($table,$tabParam,$id=TRUE) {
        
        
        
        //var_dump($tabId);
        //Nettoie la variable table des caractères ASCII < 32 et > 127
        $table_clean = $this->cleanTable($table);
        $param_clean = $this->cleanParam($tabParam);
        
        $reqSelect = 'SELECT * FROM '.$table_clean.' WHERE '.$param_clean.' = :param LIMIT 1';
        
        $prepSelect = $this->database_connection->prepare($reqSelect);
        if($id === TRUE) {
            $prepSelect->bindValue('param', $tabParam[$param_clean], PDO::PARAM_INT);
        } else {
            $prepSelect->bindValue('param', $tabParam[$param_clean], PDO::PARAM_STR);
        }
       
        $prepSelect->execute();
        
        $resSelect = $prepSelect->fetch(PDO::FETCH_ASSOC);
        
        return $resSelect;
        
    }
    
    public function insertDB($table,$tabParam) {
        
        $table_clean = $this->cleanTable($table);
        $param_clean = $this->prepareParam($tabParam);

        $reqInsert = 'INSERT INTO '.$table_clean.' ('.$param_clean['columns'].') ';
        $reqInsert .= 'VALUES ('.$param_clean['param'].')';
        
        $prepInsert = $this->database_connection->prepare($reqInsert);
        $prepInsert->execute($param_clean['values']);
        
    }
    
    
}
