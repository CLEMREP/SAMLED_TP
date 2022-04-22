<?php
include ("Models/conteneurPoste.php");
include ("Models/conteneurSalarie.php");
include ("Views/IHM/Salaries/vueSalarie.php");
include ("Views/IHM/Postes/vuePoste.php");
include ("DataBase/accesDB.php");

class controller {
    private $tousLesPostes;
	private $tousLesSalaries;
	private $maBD;
		
	public function __construct() {
		$this->maBD = new accesDB();
		$this->tousLesPostes = new conteneurPoste();
		$this->tousLesSalaries = new conteneurSalarie();
			
		$this->chargeLesPostes();
		$this->chargeLesSalaries();
	}

	public function afficheNavbar() {
		require ("Views/IHM/navbar.php");
	}

	public function afficheFooter() {
		require ("Views/IHM/footer.php");
	}

	public function affichePage($action, $vue) {
		if (isset($_GET['action']) && isset($_GET['vue']))
		{
			$action = $_GET['action'];
			$vue = $_GET['vue'];

			switch ($vue)
			{
				case "Poste":
					$this->actionPoste($action);
					break;
				case "Salarie":
					$this->actionSalarie($action);
					break;
			}
		}
	}

    public function actionPoste($action) {
        switch ($action) {
			case "Ajouter":
				$dernierId = $this->maBD->donneProchainIdentifiant("poste", "id");
				$vue = new vuePoste();
				$vue->ajouterUnPoste($dernierId);
				break;
			case "Creer":
				$libellePoste = htmlspecialchars($_POST['libellePoste']);
				$this->tousLesPostes->ajouterUnPoste($this->maBD->donneProchainIdentifiant("poste", "id"), $libellePoste);
				$this->maBD->insertPoste($libellePoste);
				$this->actionPoste("Liste");
				break;
			case "Liste":
				$lesPostes = $this->tousLesPostes->lesPostesEnTableau();
				$vue = new vuePoste();
				$vue->listeDesPostes($lesPostes);
				break;
			case "Editer":
				$id = htmlspecialchars($_GET['id']);
				$nomPoste = htmlspecialchars($_GET['nom']);
				$vue = new vuePoste();
				$vue->editerUnPoste($id, $nomPoste);
				break;
			case "Modifier":
				$idPoste = htmlspecialchars($_POST['idPoste']);
				$nomPoste = htmlspecialchars($_POST['nomPoste']);
				$this->tousLesPostes->modifierPoste($idPoste, $nomPoste);
				$this->maBD->modifierPoste($idPoste, $nomPoste);
				$this->actionPoste("Liste");
				break;
			case "Supprimer":
				$idPoste = htmlspecialchars($_POST['idPoste']);
				$this->tousLesPostes->deletePoste($idPoste);
				$this->maBD->deletePoste($idPoste);
				$this->actionPoste("Liste");
				break;
		}
    }

    public function actionSalarie($action) {
		switch ($action) {
			case "Ajouter":
				$dernierId = $this->maBD->donneProchainIdentifiant("salarie", "id");
				$listeDesPostes = $this->tousLesPostes->listeDesPostesSelect();
				$vue = new vueSalarie();
				$vue->ajouterUnSalarie($dernierId, $listeDesPostes);
				break;
			case "Creer":
				$nomSalarie = htmlspecialchars($_POST['nomSalarie']);
				$commentaireSalarie = htmlspecialchars($_POST['commentaireSalarie']);
				$idPosteSalarie = htmlspecialchars($_POST['idDuPoste']);
				$this->tousLesSalaries->ajouterUnSalarie($this->maBD->donneProchainIdentifiant("salarie", "id"), $nomSalarie, $commentaireSalarie, $this->tousLesPostes->donneObjetPosteDepuisNumero($idPosteSalarie));
				$this->maBD->insertSalarie($nomSalarie, $commentaireSalarie, $idPosteSalarie);
				$this->actionSalarie("Liste");
				break;
			case "Liste":
				$lesSalaries = $this->tousLesSalaries->lesSalariesEnTableau();
				$vue = new vueSalarie();
				$vue->listeDesSalaries($lesSalaries);
				break;
			case "Editer":
				$id = htmlspecialchars($_GET['id']);
				$nomSalarie = htmlspecialchars($_GET['nom']);
				$commentaire = htmlspecialchars($_GET['commentaire']);
				$nomPoste = htmlspecialchars($_GET['poste']);
				$listeDesPostes = $this->tousLesPostes->listeDesPostesSelect();
				$vue = new vueSalarie();
				$vue->editerUnSalarie($id, $nomSalarie, $commentaire, $listeDesPostes);
				break;
			case "Modifier":
				$idSalarie = htmlspecialchars($_POST['idSalarie']);
				echo $idSalarie . "ici !!";
				$nomSalarie = htmlspecialchars($_POST['nomSalarie']);
				$unCommentaire = htmlspecialchars($_POST['commentaire']);
				$idPosteSalarie = htmlspecialchars($_POST['idDuPoste']);
				$this->tousLesSalaries->modifierSalarie($idSalarie, $nomSalarie, $unCommentaire, $this->tousLesPostes->donneObjetPosteDepuisNumero($idPosteSalarie));
				$this->maBD->modifierSalarie($idSalarie, $nomSalarie, $unCommentaire, $idPosteSalarie);
				$this->actionSalarie("Liste");
				break;
			case "Supprimer":
				$idSalarie = htmlspecialchars($_POST['idSalarie']);
				$this->tousLesSalaries->deleteSalarie($idSalarie);
				$this->maBD->deleteSalarie($idSalarie);
				$this->actionSalarie("Liste");
				break;
		}
    }

    public function chargeLesPostes() { 
        $resultatPoste=$this->maBD->chargement('poste');
		$nbP=0;
		if (!$resultatPoste == "") {
			while ($nbP < sizeof($resultatPoste)) {
				$this->tousLesPostes->ajouterUnPoste($resultatPoste[$nbP][0],$resultatPoste[$nbP][1]);
				$nbP++;
			}
		}
	}

    public function chargeLesSalaries() { 
        $resultatSalarie=$this->maBD->chargement('salarie');
		$nbS=0;
		if (!$resultatSalarie == "") {
			while ($nbS < sizeof($resultatSalarie)) {
				$this->tousLesSalaries->ajouterUnSalarie($resultatSalarie[$nbS][0], $resultatSalarie[$nbS][1], $resultatSalarie[$nbS][2], $this->tousLesPostes->donneObjetPosteDepuisNumero($resultatSalarie[$nbS][3]));
				$nbS++;
			}
		}
	}


}
?>