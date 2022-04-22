<?php
class Poste {
    private $id;
    private $libelle;

    public function __construct($unId, $unLibelle)
    {
        $this->id = $unId;
        $this->libelle = $unLibelle;

    }

    public function affichePoste() {
        return $this->id . $this->libelle;
    }



    
    public function getId() {
        return $this->id;
    }

    public function getLibelle() {
        return $this->libelle;
    }
    
    public function setId($newId) {
        return $this->id = $newId;
    }

    public function setLibelle($newLibelle) {
        return $this->libelle = $newLibelle;
    }
}
?>