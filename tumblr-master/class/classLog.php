<?php

/**
 * Description of classLog
 */

class classLog {
    
    private $fichier;
    
    /**
     * Constructeur de la classe Log
     * @param string $nom_fic Nom du fichier dans lequel l'écriture se fera
     * @param string $droits Droits du fichier
     * @throws Exception Erreur dans le nom du fichier
     * Example : clsLog::createLog($msg, "REPERTOIRE/FICHIER");
     */
    function __construct($nom_fic, $droits = "a+") {
        try {
            $this->fichier = fopen($nom_fic, $droits);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
    
    /**
     * Ecrit dans un fichier
     * @param string $string_to_write Message à insérer dans le fichier
     */
    public function writeIn($string_to_write) {
       try {
        fwrite($this->fichier, date('H:i:s').' '.$string_to_write.chr(13));
       } catch (Exception $e) {
           $this->createLog(__FUNCTION__.' '.$e->getMessage() ,'ERROR');
       }
    }
    
    
    /**
     * Fonction réalisant toutes les actions pour un log
     * @param string $msg Message à insérer dans le fichier
     */
    public static function createLog($msg, $prefixe_fichier = 'log') {
        $fichier = $prefixe_fichier . '_'.date('d.m.y').'.txt';
        $oLog = new classLog($fichier, 'a+');
        $oLog->writeIn($msg);
    }
    
    
    /**
     * Detruit une instance
     */
    function __destruct() {
        try {
            fclose($this->fichier);
        } catch(Exception $e) {
        }
    }
    
}
?>