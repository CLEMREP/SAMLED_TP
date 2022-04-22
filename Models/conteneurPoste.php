<?php
include 'classPoste.php';

class conteneurPoste
{	
	private $lesPostes;

	public function __construct() {	
		$this->lesPostes = new arrayObject();
	}

	public function ajouterUnPoste($unIdPoste, $unLibellePoste) {	
		$unPoste = new Poste($unIdPoste, $unLibellePoste);
		$this->lesPostes->append($unPoste);
	}

	public function getListePoste() {
		return $this->lesPostes;
	}

	public function nbPostes() {	
		return $this->lesPostes->count();
	}
	
	public function listeDesPostes() {	
		$liste = "";
		foreach ($this->lesPostes as $unPoste)
		{	
			$liste .= $unPoste->affichePoste() . '<br>';
		}
		return $liste;
	}

	public function listeDesPostesSelect()
	{
	$liste = "";
	foreach ($this->lesPostes as $unPoste)
		{
		$liste = $liste."<option value='".$unPoste->getId()."'>".$unPoste->getLibelle()."</option>";
		}
	$liste = $liste."";
	return $liste;
	}

	public function lesPostesEnTableau() {
		$tableau = "";
		foreach ($this->lesPostes as $unPoste) {
			$tableau .= "<tr class='border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700'>";
        	$tableau .= "<th scope='row' class='px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap'>" . $unPoste->getId() . "</th>";
			$tableau .= "<td class='px-6 py-4'>" . $unPoste->getLibelle() . "</td>";
			$tableau .= "<td class='px-6 py-4 text-right'>
							<a href='index.php?vue=Poste&action=Editer&id=".$unPoste->getId()."&nom=" . $unPoste->getLibelle() . "' class='font-medium text-blue-600 dark:text-blue-500 hover:underline'>Éditer</a>
						</td>
	  					</tr>";

		}
		return $tableau;
	}
	
	public function modifierPoste($unIdPoste, $unNomPoste) {
		foreach ($this->lesPostes as $unPoste) {
			if ($unPoste->getId() == $unIdPoste) {
				$unPoste->setLibelle($unNomPoste);
			}
		}
	}

	public function deletePoste($unIdPoste) {
		unset($this->lesPostes[$unIdPoste-1]);
	}

	public function donneObjetPosteDepuisNumero($unIdPoste) {
		$trouve=false;
		$leBonPoste=null;
		$iPoste = $this->lesPostes->getIterator();
		while ((!$trouve)&&($iPoste->valid())) {
			if ($iPoste->current()->getId()==$unIdPoste) {
				$trouve=true;
				$leBonPoste = $iPoste->current();
			} else {
				$iPoste->next();
			}
		}
		return $leBonPoste;
	}		
		
}

	
?>