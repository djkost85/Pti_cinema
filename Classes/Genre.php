<?php // Classe Genre

class Genre{
    private $num_genre;
    private $genre;
    
//$genre = new genre($db->queryArray('SELECT * FROM genre'));

    public function __construct($tab)
    {
        $this->num_genre = $tab[0];
        $this->genre = $tab[1];
    }
    
    public function getGenre()
    {
        return $this->genre;
    }
    
    public function getNum_genre()
    {
        return $this->num_genre;
    }
}

?>