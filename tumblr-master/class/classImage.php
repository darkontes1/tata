<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of classImage
 *
 * @author fabrice
 */
class classImage {
    
    private $idImage;
    private $nomImage;
    private $captionImage;
    private $real_Path;
    private $created_on;
    protected $table = 'images';


    public function __construct() {
        
    }
    
    public function getId() {
        return $this->idImage;
    }
    
    public function getNom() {
        return $this->nomImage;
    }
    
    public function getCaption() {
        return $this->captionImage;
    }

    public function getRealPath() {
        return $this->real_Path;
    }

    public function getCreatedOn() {
        return $this->created_on;
    }

    public function setId() {
        return $this->idImage;
    }

    public function setNom($nomImage) {
        return $this->nomImage = $nomImage;
    }
    
    public function setCaption($captionImage) {
        return $this->captionImage = $captionImage;
    }

    public function setRealPath($realPath) {
        return $this->real_Path = $realPath;
    }

    public function setCreatedOn($createdOn) {
        return $this->created_on = $createdOn;
    }
    
    public function createImage () {
        
    }
    
    public function deleteImage () {
        
    }
    
    public function modifyImage() {
        
    }
    
    public function getAllImages() {
        
        $oBDD = new classBDD();
        $listeImages = $oBDD->selectAll($this->table);
        
        return $listeImages;
    }
    
    public function getImage($id) {
        $oBDD = new classBDD;
        $image = $oBDD->selectByParam($this->table, array('idImage'=>$id));
        
        if(empty($image)) {
             return NULL;
        }
        
        $this->idImage = $image['idImage'];
        $this->nomImage = $image['nomImage'];
        $this->captionImage = $image['captionImage'];
        $this->real_Path = DIR_IMG.$image['real_path'];
        $this->created_on = $image['created_on'];
        
        return 1;
       
    }

    public function __destruct() {
        
    }
}
