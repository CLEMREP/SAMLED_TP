<?php
class accesDB {

    private $host;
    private $login;
    private $password;
    private $nom;
    private $connexion;

    public function __construct()
    {
        $this->host = "localhost";
        $this->login = "CLEMREP";
        $this->password = "";
        $this->base = "TP_SERVICES";
        $this->connexion();
    }

    private function connexion() {
        try {
            $this->connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->base . ";charset=utf8", $this->login, $this->password);
            $this->verifConnexion = true;
        } catch (PDOException $e) {
            die("Connexion à la base impossible" . $e->getMessage());
        }
    }

    public function chargement($uneTable) {
		$lesInfos=null;
		$nbTuples=0;
		$stringQuery="SELECT * FROM ".$uneTable;
		$query = $this->connexion->prepare($stringQuery);
		if($query->execute()) {
			while($row = $query->fetch(PDO::FETCH_NUM)) {
				$lesInfos[$nbTuples] = $row;
				$nbTuples++;
			}
		} else {
			die('Problème dans chargement : '.$query->errorCode());
		}
		return $lesInfos;
	}

    public function donneProchainIdentifiant($uneTable, $unIdentifiant) {
        $stringQuery = "SELECT max(".$unIdentifiant.") FROM ".$uneTable;
        $requete = $this->connexion->prepare($stringQuery);
        //$requete->bindValue(1, $unIdentifiant);

        //exécution de la requête SQL
        if($requete->execute()) {
			while($row = $requete->fetch(PDO::FETCH_NUM)) {
				return $row[0]+1;
			}
		} else {
            die('Erreur sur donneProchainIdentifiant : '+$requete->errorCode());
        }
    }


    public function insertPoste($unLibelle)
	{
		$sonId = $this->donneProchainIdentifiant("poste", "id");
		$requete = $this->connexion->prepare("INSERT INTO poste (id, libelle) VALUES (?,?)");
		$requete->bindValue(1,$sonId);
		$requete->bindValue(2,$unLibelle);
		if(!$requete->execute())
		{
			die("Erreur dans insert Poste : ".$requete->errorCode());
		}

		return $sonId;
	}
		
	public function insertSalarie($unNom, $unCommentaire, $unCodePoste)
	{
		$sonId = $this->donneProchainIdentifiant("salarie", "id");
		$requete = $this->connexion->prepare("INSERT INTO salarie (id, nom, commentaire, idPoste) VALUES (?,?,?,?)");
		$requete->bindValue(1, $sonId);
		$requete->bindValue(2, $unNom);
		$requete->bindValue(3, $unCommentaire);
		$requete->bindValue(4, $unCodePoste);
		if(!$requete->execute()) {
			die("Erreur dans insert Salarie : ".$requete->errorCode());
		}
		
		return $sonId;
	}

	public function deletePoste($unId)
	{
		$requete = $this->connexion->prepare("DELETE FROM poste WHERE id = ?");
		if(!$requete->execute([$unId]))
		{
			die("Erreur dans delete Poste : ".$requete->errorCode());
		}
	}

	public function deleteSalarie($unId)
	{
		$requete = $this->connexion->prepare("DELETE FROM salarie WHERE id = ?");
		if(!$requete->execute([$unId]))
		{
			die("Erreur dans delete Salarie : ".$requete->errorCode());
		}
	}

	public function modifierPoste($unId, $unLibelle)
	{
		$requete = $this->connexion->prepare("UPDATE poste SET libelle = ? WHERE id = ?");
		$requete->bindValue(1, $unLibelle);
		$requete->bindValue(2, $unId);
		if(!$requete->execute())
		{
			die("Erreur dans modifier Poste : ".$requete->errorCode());
		}
	}

	public function modifierSalarie($unId, $unNomSalarie, $unCommentaire, $unIdPoste)
	{
		$requete = $this->connexion->prepare("UPDATE salarie SET nom = ?, commentaire = ?, idPoste = ? WHERE id = ?");
		$requete->bindValue(1, $unNomSalarie);
		$requete->bindValue(2, $unCommentaire);
		$requete->bindValue(3, $unIdPoste);
		$requete->bindValue(4, $unId);
		if(!$requete->execute())
		{
			die("Erreur dans modifier Salarie : ".$requete->errorCode());
		}
	}
}
?>