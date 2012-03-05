<html>
   <head>
	 <script type='text/javascript' src='jquery-1.7.1.js'></script>
	 <script type='text/javascript' src='jquery.autocomplete.js'></script>
	 <script type="text/javascript">
	     $(document).ready(function (){
                 alert($("#fonction").val());
                 $("#fonction").val("Eric Toledano");
		$("#titre_f").keyup(function(){
		   if ($(this).val().length > 4){
		      $.ajax({
			 type: "POST",
			 url: "test4.php?action=getFilm",
			 data: "search=intouchables",
			 success: function(data){
                             alert('success');
			       /*var film = jQuery.parseJSON(data);
			       alert(film.annee);
			       for (i in film){
				  inp = '#'+i;
				  alert(i);
				  alert(inp);
				  $(inp).val(film[i]);
				  //document.getElementById(i).value = obj[i];
			       }*/
                               $("#fonction").val('Retraité');
			 }
		      });
		   }
		});
	    });
</script>
   </head>
   <body>
      <form name="film" method="post">
	 <input type="text" id="titre_f" name="film_titre" value=""> </input>
	 <input type="text" id="annee" name="lib" value=""> </input>
         <input type="text" id="realisateur" name="realisateur" value=""> </input>
         

<SELECT id="fonction" name="fonction">
		<OPTION VALUE="enseignant">Enseignant</OPTION>
		<OPTION VALUE="etudiant">Etudiant</OPTION>
		<OPTION VALUE="ingenieur">Ingénieur</OPTION>
		<OPTION VALUE="retraite">Retraite</OPTION>
		<OPTION VALUE="autre">Autre</OPTION>
                <OPTION VALUE="1">1</OPTION>
                <OPTION VALUE="Eric Toledano">Eric Toledano</OPTION>
</SELECT>

      </form>
                   <?php include_once 'Classes/PFBC/Form.php';
                   
                   $form = new PFBC\Form("monform", 300);
$form->addElement(new PFBC\Element\Textbox("Nom:", "MyTextbox"));
$form->addElement(new PFBC\Element\Select("My Select:", "MySelect", array(
   "Option #1",
   "Option #2",
   "Option #3"
)));
$form->addElement(new PFBC\Element\Button);
$form->render();
?>
   </body>
   
</html>