<?php // Classe Réalisateur

class Realisateur{
    private $num_real;
    private $nom;
    private $prenom;
    private $image;
    
//$realisateur = new Realisateur($db->queryArray('SELECT * FROM realisateurs'));
//foreach($realisateurs as $real)
//echo $real->nom;

    public function __construct($tab)
    {
        $this->num_real = $tab[0];
        $this->nom = $tab[1];
        $this->prenom = $tab[2];
        $this->image = $tab[3];
    }
    
    public function getNom()
    {
        return $this->nom;
    }
    
    public function getPrenom()
    {
        return $this->prenom;
    }
    
    public function getNum_real()
    {
        return $this->num_real;
    }
}

?>