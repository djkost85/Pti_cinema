<?php // Classe Cinéma

class Cinema{
    private $num_cin;
    private $nom_cin;
    private $adresse_cin;
    private $codepos_cin;
    private $ville_cin;
    
//$cinema = new cinema($db->queryArray('SELECT * FROM cinema;'));

    public function __construct($tab) //tableau de résultats - plusieurs objets
    {
        $this->num_cin = $tab[0];
        $this->nom_cin = $tab[1];
        $this->adresse_cin = $tab[2];
        //$this->codepos_cin = $tab[3];
        //$this->ville_cin = $tab[4];
        //print_r($tab);
    }
    
    public function __clone()
    {
        $objet = clone $this;
        return $objet;
    }
    
    public function getAdresse()
    {
        return $this->adresse_cin;        
    }
    
    public function getCodepos()
    {
        return $this->codepos_cin;
    }
    
    public function getVille()
    {
        return $this->ville_cin;
    }
    
    public function getNom()
    {
        return $this->nom_cin;
    }
    
    public function getNum_cin()
    {
        return $this->num_cin;
    }
}

?>