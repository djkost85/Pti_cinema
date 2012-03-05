<?php // Classe Film

class Film{
    private $id;
    private $titre;
    private $duree;
    private $resume;
    private $affiche;
    private $video;
    private $num_genre;
    private $num_real;
    private $annee;
    
    public function __construct($p_id)
    {
        $this->id = $p_id;
        $this->nom = "noname";
    }
    
    public function getTitre()
    {
        return $this->titre;
    }
    
    public function getId()
    {
        return $this->id;
    }
}

?>