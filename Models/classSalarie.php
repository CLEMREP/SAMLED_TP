<?php
class Salarie {
    private $id;
    private $nom;
    private $commentaire;
    private $lePoste;

    public function __construct($unId, $unNom, $unCommentaire, $unPoste)
    {
        $this->id = $unId;
        $this->nom = $unNom;
        $this->commentaire = $unCommentaire;
        $this->lePoste = $unPoste;
    }

    public function afficheSalarie() {
        return $this->id . $this->nom . $this->commentaire . $this->getPoste()->getLibelle();
    }



    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }

    public function getPoste() {
        return $this->lePoste;
    }

    public function setId($newId) {
        return $this->id = $newId;
    }

    public function setNom($newNom) {
        return $this->nom = $newNom;
    }

    public function setCommentaire($newCommentaire) {
        return $this->commentaire = $newCommentaire;
    }

    public function setPoste($newPoste) {
        return $this->lePoste = $newPoste;
    }
}
?>