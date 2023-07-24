<?php

class DAO {
	/* Paramètres de connexion à la base de données 
	Dans l'idéal, il faudrait écrire les getters et setters correspondants pour pouvoir en modifier les valeurs
	au cas où notre serveur change
	*/
	
	private $host="127.0.0.1";
	private $user="root";
	private $password="";
	private $database="pays";
	private $charset="utf8";
	
	//instance courante de la connexion
	private $bdd;
	
	//stockage de l'erreur éventuelle du serveur mysql
	private $error;
	
	public function __construct() {
	
	}
	
	/* méthode de connexion à la base de donnée */
	public function connexion() {
		
		try
		{
			// On se connecte à MySQL
			$this->bdd = new PDO('mysql:host='.$this->host.';dbname='.$this->database.';charset='.$this->charset, $this->user, $this->password);
		}
		catch(Exception $e)
		{
			// En cas d'erreur, on affiche un message et on arrête tout
				$this->error='Erreur : '.$e->getMessage();
		}
	}
	
	/* méthode qui renvoit tous les résultats sous forme de tableau de la requête passée en paramètre */
	public function getResults($query) {
		$results=array();
		
		$stmt = $this->bdd->query($query);
		
		if (!$stmt) {
			$this->error=$this->bdd->errorInfo();
			return false;
		} else {
			return $stmt->fetchAll();
		}
		
	}
	
	/* méthode qui renvoit tous les résultats sous forme de tableau
	*/
	public function getCountries() {
		$sql="SELECT `id_pays`, `libelle_pays`, `population_pays`, `taux_natalite_pays`, `taux_mortalite_pays`, `esperance_vie_pays`, `taux_mortalite_infantile_pays`, `nombre_enfants_par_femme_pays`, `taux_croissance_pays`, `population_plus_65_pays` FROM `t_pays`";

		return $this->getResults($sql);
	}
	public function getSelect1() {
		$sql="SELECT`continent_id`,SUM(`population_pays`)AS pop_pays,t_continents.libelle_continent AS nom,ROUND(AVG(taux_natalite_pays),1) AS tx_nat,ROUND(AVG(taux_mortalite_pays),1)AS tx_mort,ROUND(AVG(esperance_vie_pays),1) AS espe,ROUND(AVG(taux_mortalite_infantile_pays),1)as tx_enf,ROUND(AVG(nombre_enfants_par_femme_pays),1)as enf_par_femme,ROUND(AVG(taux_croissance_pays),1) as tx_crois,SUM(population_plus_65_pays) as pop_plus FROM `t_pays`INNER JOIN t_continents ON t_pays.continent_id = t_continents.id_continent GROUP BY `continent_id`";

		return $this->getResults($sql);
	}
	public function getCalcul2() {
		$sql="SELECT`continent_id`,SUM(`population_pays`)AS pop_pays,t_continents.libelle_continent AS nom,ROUND(AVG(taux_natalite_pays),1)AS tx_nat,ROUND(AVG(taux_mortalite_pays),1)AS tx_mort,ROUND(AVG(esperance_vie_pays),1)AS espe,ROUND(AVG(taux_mortalite_infantile_pays),1)AS tx_enf,ROUND(AVG(nombre_enfants_par_femme_pays),1)AS enf_femme,ROUND(AVG(taux_croissance_pays),1)AS tx_crois,SUM(population_plus_65_pays)AS pop_plus FROM `t_pays`INNER JOIN t_continents ON t_pays.continent_id = t_continents.id_continent";

		return $this->getResults($sql);
	}
	public function getSelect3($concat) {
		$sql="SELECT `libelle_region` AS nom,SUM(t_pays.population_pays) AS pop_pays,ROUND(AVG(taux_natalite_pays),1) AS tx_nat,ROUND(AVG(esperance_vie_pays),1) AS espe,ROUND(AVG(taux_mortalite_infantile_pays),1) AS tx_enf,ROUND(AVG(taux_mortalite_pays),1)AS tx_mort,ROUND(AVG(nombre_enfants_par_femme_pays),1) AS enf_par_femme,ROUND(AVG(taux_croissance_pays),1) AS tx_crois, SUM(population_plus_65_pays) AS pop_plus FROM `t_regions`INNER JOIN t_continents ON t_regions.continent_id=t_continents.id_continent INNER JOIN t_pays ON t_regions.id_region=t_pays.region_id WHERE `libelle_continent`IN ('".$concat."') GROUP BY t_regions.id_region";

		return $this->getResults($sql);
	}
	public function getCalcul4($concat) {
		$sql="SELECT`continent_id`,SUM(`population_pays`)AS pop_pays,t_continents.libelle_continent AS nom,ROUND(AVG(taux_natalite_pays),1)AS tx_nat,ROUND(AVG(taux_mortalite_pays),1)AS tx_mort,ROUND(AVG(esperance_vie_pays),1)AS espe,ROUND(AVG(taux_mortalite_infantile_pays),1)AS tx_enf,ROUND(AVG(nombre_enfants_par_femme_pays),1)AS enf_femme,ROUND(AVG(taux_croissance_pays),1)AS tx_crois,SUM(population_plus_65_pays)AS pop_plus FROM `t_pays`INNER JOIN t_continents ON t_pays.continent_id = t_continents.id_continent WHERE libelle_continent IN ('".$concat."') GROUP BY id_continent";

		return $this->getResults($sql);
	}
	public function getSelect5() {
		$sql="SELECT `libelle_continent`,t_pays.libelle_pays AS nom,t_pays.population_pays AS pop_pays, taux_natalite_pays AS tx_nat,esperance_vie_pays AS espe,taux_mortalite_infantile_pays AS tx_enf,taux_mortalite_pays AS tx_mort,nombre_enfants_par_femme_pays AS enf_par_femme,taux_croissance_pays AS tx_crois,population_plus_65_pays AS pop_plus FROM `t_continents` INNER JOIN t_pays ON t_continents.id_continent=t_pays.continent_id WHERE libelle_continent IN ('Amérique SEPTENTRIONALE')";

		return $this->getResults($sql);
	}
	public function getCalcul6($concat) {
		$sql="SELECT`continent_id`,SUM(`population_pays`)AS pop_pays,t_continents.libelle_continent AS nom,ROUND(AVG(taux_natalite_pays),1)AS tx_nat,ROUND(AVG(taux_mortalite_pays),1)AS tx_mort,ROUND(AVG(esperance_vie_pays),1)AS espe,ROUND(AVG(taux_mortalite_infantile_pays),1)AS tx_enf,ROUND(AVG(nombre_enfants_par_femme_pays),1)AS enf_femme,ROUND(AVG(taux_croissance_pays),1)AS tx_crois,SUM(population_plus_65_pays)AS pop_plus FROM `t_pays`INNER JOIN t_continents ON t_pays.continent_id = t_continents.id_continent WHERE libelle_continent IN ('".$concat."') GROUP BY id_continent";

		return $this->getResults($sql);
	}
	public function getSelect7($concat) {
		$sql='SELECT `libelle_pays`AS nom,t_pays.population_pays AS pop_pays, taux_natalite_pays AS tx_nat,esperance_vie_pays AS espe,taux_mortalite_infantile_pays AS tx_enf,taux_mortalite_pays AS tx_mort,nombre_enfants_par_femme_pays AS enf_par_femme,taux_croissance_pays AS tx_crois,population_plus_65_pays AS pop_plus FROM t_pays INNER JOIN t_regions ON t_pays.region_id=t_regions.id_region WHERE t_regions.libelle_region IN ("'.$concat.'");';

		return $this->getResults($sql);
	}
	public function getCalcul8($concat) {
		$sql="SELECT region_id,SUM(`population_pays`)AS pop_pays,t_regions.libelle_region AS nom,ROUND(AVG(taux_natalite_pays),1)AS tx_nat,ROUND(AVG(taux_mortalite_pays),1)AS tx_mort,ROUND(AVG(esperance_vie_pays),1)AS espe,ROUND(AVG(taux_mortalite_infantile_pays),1)AS tx_enf,ROUND(AVG(nombre_enfants_par_femme_pays),1)AS enf_femme,ROUND(AVG(taux_croissance_pays),1) AS tx_crois,SUM(population_plus_65_pays) AS pop_plus FROM `t_pays` INNER JOIN t_continents ON t_pays.continent_id = t_continents.id_continent INNER JOIN t_regions ON t_pays.region_id = t_regions.id_region WHERE t_regions.libelle_region IN ('".$concat."') GROUP BY t_regions.libelle_region";

		return $this->getResults($sql);
	}
	public function getContinent() {
		$sql='SELECT`continent_id`,SUM(`population_pays`)AS pop_pays,t_continents.libelle_continent,ROUND(AVG(taux_natalite_pays),1) AS tx_nat,ROUND(AVG(taux_mortalite_pays),1)AS tx_mort,ROUND(AVG(esperance_vie_pays),1) AS espe,ROUND(AVG(taux_mortalite_infantile_pays),1)as tx_enf,ROUND(AVG(nombre_enfants_par_femme_pays),1)as enf_par_femme,ROUND(AVG(taux_croissance_pays),1) as tx_crois,SUM(population_plus_65_pays) as pop_plus FROM `t_pays`INNER JOIN t_continents ON t_pays.continent_id = t_continents.id_continent GROUP BY `continent_id`';

		return $this->getResults($sql);
	}

	/* méthode pour fermer la connexion à la base de données */
	public function disconnect() {
		$this->bdd=null;
	}
	
	/* méthode pour récupérer la dernière erreur fournie par le serveur mysql */
	public function getLastError() {
		return $this->error;
	}
	
}

?>
