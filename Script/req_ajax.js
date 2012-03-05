//autocompletion film
$("#titre").autocomplete({
	source: "ajax.php?action=autoCompFilm",
	focus: function(event, ui) {if(ui.item) this.value = ui.item.value.split('<strong>').join('').split('</strong>').join('');return false;},
	select: function(event, ui) {if(ui.item) this.value = ui.item.value.split('<strong>').join('').split('</strong>').join('');return false;}
});

