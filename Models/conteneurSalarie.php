<?php
include 'classSalarie.php';

class conteneurSalarie
{	
	private $lesSalaries;

	public function __construct() {	
		$this->lesSalaries = new arrayObject();
	}

	public function ajouterUnSalarie($unIdSalarie, $unNomSalarie, $unCommentaireSalarie, $unPoste) {	
		$unSalarie = new Salarie($unIdSalarie, $unNomSalarie, $unCommentaireSalarie, $unPoste);
		$this->lesSalaries->append($unSalarie);
	}

	public function getLesSalaries() {
		return $this->lesSalaries;
	}

	public function nbSalaries() {	
		return $this->lesSalaries->count();
	}
	
	public function listeDesSalaries() {
		$liste = "";
		foreach ($this->lesSalaries as $unSalarie)
		{	
			$liste .= $unSalarie->afficheSalarie().'<br>';
		}
		return $liste;
	}

	public function lesSalariesEnTableau() {
		$tableau = "";
		foreach ($this->lesSalaries as $unSalarie) {
			$tableau .= "<tr class='border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700'>";
        	$tableau .= "<th scope='row' class='px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap'>" . $unSalarie->getId() . "</th>";
			$tableau .= "<td class='px-6 py-4'>" . $unSalarie->getNom() . "</td>";
			$tableau .= "<td class='px-6 py-4'>" . $unSalarie->getCommentaire() . "</td>";
			$tableau .= "<td class='px-6 py-4'>" . $unSalarie->getPoste()->getLibelle() . "</td>";
			$tableau .= "<td class='px-6 py-4 text-right'>
							<a href='index.php?vue=Salarie&action=Editer&id=" . $unSalarie->getId() . "&nom=" . $unSalarie->getNom() . "&commentaire=" . $unSalarie->getCommentaire() . "&poste=" . $unSalarie->getPoste()->getLibelle() . "' class='font-medium text-blue-600 dark:text-blue-500 hover:underline'>Éditer</a>
						</td>
	  					</tr>";

		}
		return $tableau;
	}

	public function modifierSalarie($unIdSalarie, $unNomSalarie, $unCommentaire, $unPoste) {
		foreach ($this->lesSalaries as $unSalarie) {
			if ($unSalarie->getId() == $unIdSalarie) {
				$unSalarie->setNom($unNomSalarie);
				$unSalarie->setCommentaire($unCommentaire);
				$unSalarie->setPoste($unPoste);
			}
		}
	}
		
	public function deleteSalarie($unIdSalarie) {
		unset($this->lesSalaries[$unIdSalarie-1]);
	}
	
	public function donneObjetSalarieDepuisNumero($unIdSalarie) {
		$trouve=false;
		$leBonSalarie=null;
		$iSalarie = $this->lesSalaries->getIterator();
		while ((!$trouve)&&($iSalarie->valid())) {
			if ($iSalarie->current()->getIdSalarie()==$unIdSalarie) {
				$trouve=true;
				$leBonSalarie = $iSalarie->current();
			} else {
				$iSalarie->next();
			}
		}
		return $leBonSalarie;
	}
}
?>