
   function surligne(champ, erreur)
{
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}

function verif_pseudo(champ) {
if(champ.value.length < 2|| champ.value.length > 25)
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

function verif_commentaire(champ) {
if(champ.value.length < 4|| champ.value.length > 150)
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}
    
      function verifFormulaire(f)
{
   var pseudoOk = verif_pseudo(f.pseudo);
   var commentaireOk = verif_commentaire(f.commentaire);
   
   if(pseudoOk && commentaireOk)
      {
          return true;
      }
   else
   {
      alert("Veuillez remplir correctement tous les champs");
      return false; 
   }
}