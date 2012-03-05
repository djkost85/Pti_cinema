<?php
function chargerClasse ($classe)
    {
        require("../Classes/".$classe.".php");
    }
    spl_autoload_register ('chargerClasse'); 
?>