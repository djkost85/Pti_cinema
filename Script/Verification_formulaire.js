   function surligne(champ, erreur)
{
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}

function verifLogin(champ)
{
   if(champ.value.length < 3 || champ.value.length > 25)
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
    
      function verifForm(f)
{
   var loginOk = verifLogin(f.login);
   var mdpOk = verifLogin(f.mdp);
   
   if(loginOk && mdpOk)
      {
          return true;
      }
   else
   {
      alert("Veuillez remplir correctement tous les champs");
      return false; 
   }
}